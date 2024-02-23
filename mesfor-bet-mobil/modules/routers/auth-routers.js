import express from "express";
const router = express.Router();
import Cryptr from "cryptr";
const cryptr = new Cryptr("myTotalySecretKey");
import tryCatch from "../../middleware/try-catch-middleware.js";
import Users from "../schemas/users-schema.js"
import Loginlogs from "../schemas/login-logs-schema.js"

router.post("/login", tryCatch(async (req, res) => {
  if (req.body.user) {
    const result = await Users.findOne({ user: req.body.user });
    if (result) {
      if (req.body.pass === String(cryptr.decrypt(result.pass))) {
        if (result.state === "pasif") {
          res.json({ login: "Hesap askıya alınmıştır" });
        } else if (result.fakelogin >= result.logincount) {
          res.json({ login: "Hatalı giriş sınırı!" });
        } else {
          const ip =
            req.headers["x-forwarded-for"] ||
            req.connection.remoteAddress ||
            req.socket.remoteAddress ||
            (req.connection.socket ? req.connection.socket.remoteAddress : null)

          let loginlogs = new Loginlogs({
            user: result.user,
            admin: result.admin,
            superadmin: result.superadmin,
            date: new Date(),
            proccess: "Online",
            ip: ip,
          });
          await loginlogs.save();
          await Users.updateOne({ user: req.body.user },{ logincheck: "active"});
          req.session.auth = result
          req.session.save()
          res.json({ code: 200, login: "Giriş Başarılı", auth: result});
        }
      } else {
        if (result.fakelogin < result.logincount) {
          await Users.updateOne(
            { user: req.body.user },
            { $inc: { fakelogin: + 1 } }
          );
          res.json({ login: "Geçersiz üye" });
        } else {
          res.json({ login: "Hatalı giriş sınırı!" });
        }
      }
    } else {
      res.json({ login: "Geçersiz üye" });
    }
  }
}))
router.post("/logout", tryCatch(async (req, res) => {
  const ip =
    req.headers["x-forwarded-for"] ||
    req.connection.remoteAddress ||
    req.socket.remoteAddress ||
    (req.connection.socket ? req.connection.socket.remoteAddress : null);
    
  let loginlogs = new Loginlogs({
    user: req.session.auth.user,
    admin: req.session.auth.admin,
    superadmin: req.session.auth.superadmin,
    date: new Date(),
    proccess: "Offline",
    ip: ip,
  });
  await loginlogs.save();
  await Users.updateOne({ user: req.session.auth.user },{ logincheck: "passive" })
  delete req.session.auth
  res.send({code: 200})
}));
router.post("/reset-password", tryCatch(async (req, res) => {
  const result = await Users.findOne({ user: req.body.user }, "user nick");
  if (result) {
    let newPass = cryptr.encrypt(req.body.pass);
    if (req.body.nick === result.nick) {
      await Users.updateOne({ user: req.body.user },{pass: newPass, logincheck: "passive", fakelogin: 0, sessioncount: 0,});
      res.json({ code: 200, message: "Sıfırlama başarılı" });
    } else {
      return res.json({ message: "Gecersiz nick" });
    }
  } else {
    return res.json({ message: "Gecersiz kullanici" });
  }
}))

export default router;
