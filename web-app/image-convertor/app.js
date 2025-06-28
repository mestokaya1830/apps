import express from 'express'
import helmet from 'helmet'
import multer from 'multer'
import sharp from 'sharp'
import fs from 'fs'
import dotenv from 'dotenv'
import path from 'path'
import { fileURLToPath } from 'url'
import zip from 'express-zip'
import rateLimit from 'express-rate-limit'

const apiLimiter = rateLimit({
  windowMs: 15 * 60 * 1000, // 15 minutes
  max: 100, // Maksimum 100 request
  message: {
    code: 429,
    error: 'Try again after 15 minutes.'
  }
})

dotenv.config()

const __dirname = path.dirname(fileURLToPath(import.meta.url))
const app = express()

// Middleware
app.use(helmet())
app.use(express.json())
app.use(express.urlencoded({ extended: true, limit: '3mb' }))
app.use(express.static('dist'))
app.use('/api', apiLimiter)

if (process.env.NODE_ENV === 'production') {
  app.use(express.static('dist'))
  app.get('*', (req, res) => {
    res.sendFile(path.resolve('dist/index.html'))
  })
}

// Multer setup
const storage = multer.diskStorage({
  destination: (_, __, cb) => cb(null, 'dist/'),
  filename: (_, file, cb) => {
    const uniqueName = `${Date.now()}-${file.originalname}`
    cb(null, uniqueName)
  }
})

const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/avif']
const fileFilter = (_, file, cb) => {
  if (!allowedTypes.includes(file.mimetype)) {
    const error = new Error('Wrong file type')
    error.code = 'LIMIT_FILE_TYPES'
    return cb(error, false)
  }
  cb(null, true)
}

const upload = multer({
  storage,
  fileFilter,
  limits: { fileSize: 10 * 1024 * 1024 } // 10 MB
})

// Sharp format handlers
const formatHandlers = {
  jpeg: img => img.jpeg({ quality: 100 }),
  jpg:  img => img.jpeg({ quality: 100 }),
  png:  img => img.png({ quality: 100 }),
  gif:  img => img.gif({ quality: 100 }),
  webp: img => img.webp({ quality: 100 }),
  avif: img => img.avif({ quality: 100 })
}

// Convert Endpoint
app.post('/api/convert/:format/:imagepath', upload.array('files', 20), async (req, res) => {
  try {
    const format = req.params.format.toLowerCase()
    const folder = path.basename(req.params.imagepath)
    const uploadDir = path.join(__dirname, 'dist/uploads', folder)
    await fs.promises.mkdir(uploadDir, { recursive: true })

    const convertedFiles = []

    for (const file of req.files) {
      const extIndex = file.originalname.lastIndexOf('.')
      const baseName = file.originalname.substring(0, extIndex)
      const newFilename = `${baseName}.${format}`
      const outputPath = path.join(uploadDir, newFilename)

      const transformer = formatHandlers[format]
      if (!transformer) {
        throw new Error('Unsupported format')
      }

      await transformer(sharp(file.path)).toFile(outputPath)
      await fs.promises.unlink(file.path)

      convertedFiles.push({
        filename: newFilename,
        mimetype: `image/${format}`
      })
    }

    res.json({ code: 200, files: convertedFiles })

  } catch (err) {
    console.error(err)
    res.status(500).json({ error: 'Conversion failed' })
  }
})

// Download Endpoint
app.post('/api/download/:imagepath', async (req, res) => {
  try {
    const folder = path.basename(req.params.imagepath)
    const folderPath = path.join(__dirname, 'dist/uploads', folder)

    if (!fs.existsSync(folderPath)) {
      return res.status(400).json({ code: 400, message: 'No images found' })
    }

    const files = await fs.promises.readdir(folderPath)
    const zipFiles = files.map(file => ({
      path: path.join(folderPath, file),
      name: file
    }))

    res.zip(zipFiles)
  } catch (err) {
    console.error(err)
    res.status(500).json({ error: 'Download failed' })
  }
})

// Remove Images Endpoint
app.post('/api/remove-images', async (req, res) => {
  try {
    const folder = path.basename(req.body.imagepath)
    const folderPath = path.join(__dirname, 'dist/uploads', folder)

    if (!fs.existsSync(folderPath)) {
      return res.status(400).json({ code: 400, message: 'No folder to delete' })
    }

    fs.rmSync(folderPath, { recursive: true, force: true })
    res.json({ code: 200, message: 'Images removed' })
  } catch (err) {
    console.error(err)
    res.status(500).json({ error: 'Removal failed' })
  }
})

// Error Middleware
app.use((error, req, res, next) => {
  if (error.code === 'LIMIT_FILE_TYPES') {
    return res.status(400).json({ error: 'Wrong file type!' })
  }
  if (error.code === 'LIMIT_FILE_SIZE') {
    return res.status(400).json({ error: 'File too large! Max 10MB.' })
  }
  console.error(error)
  res.status(500).json({ error: 'Server error' })
})

// Start Server
app.listen(3000, () => {
  console.log('Server is running on http://localhost:3000')
})
