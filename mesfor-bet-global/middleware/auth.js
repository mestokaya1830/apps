const isLogin = (req, res, next) => {
  if (req.session.auth) {
    next()
  } else {
    res.json({auth: 'Session Expired'})
  }
}
export default isLogin