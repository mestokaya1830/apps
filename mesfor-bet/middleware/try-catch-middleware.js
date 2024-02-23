const wrapAsync = (param) => {
  return (req, res, next) => {
    param(req, res, next).catch(next)
  }
}

export default  wrapAsync