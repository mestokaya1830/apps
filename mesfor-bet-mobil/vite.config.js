import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { VitePWA } from "vite-plugin-pwa";
import { fileURLToPath, URL } from "url";
export default defineConfig({
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", import.meta.url)),
    }
  },
  server:{//for development short url (http://localhost:3000)
    proxy:{
      '/api':{
        target:'http://localhost:3000',
        changeOrigin: true
      }
    }
  },
  plugins: [
    vue(),
    VitePWA({
      mode: 'production',
      registerType: "autoUpdate",
      injectRegister: "auto",
      workbox: {
        globPatterns: ["**/*.{js,css,html,ico,png,svg,webp}"],
      },
      selfDestroying: true,
      includeAssets: ["icon.ico", "apple-touch-icon.webp", "mask-icon.svg"],
      manifest: {
        name: "Mesfor",
        short_name: "Mesfor",
        description: "Mesfor",
        theme_color: "#ffffff",
        icons: [
          {
            src: "/icons/icon_x192.webp",
            sizes: "192x192",
            type: "image/webp",
          },
          {
            src: "/icons/icon_x512.webp",
            sizes: "512x512",
            type: "image/webp",
          }
        ]
      }
    })
  ]
})