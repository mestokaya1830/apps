const isLogin = (req, res, next) => {
  if (req.session.auth) {
    next()
  }
}
export default isLogin