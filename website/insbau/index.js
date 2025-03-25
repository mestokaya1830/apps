
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('loading-container').style.display = 'none'
  document.getElementById('home').style.display = 'block'

  window.onscroll = () => {
    if (
      document.body.scrollTop > 500 ||
      document.documentElement.scrollTop > 500
    ) {
      document.getElementById("go-top").style.display = "block";
    } else {
      document.getElementById("go-top").style.display = "none";
    }
  };

  document.querySelector(".startseite").style.color = "#fddf85";

  document.getElementById("go-top").addEventListener("click", (e) => {
    window.scrollTo(0, 0);
    document.querySelectorAll(".navigation-bar-links").forEach((item2) => {
      item2.style.color = "#fff";
    });
    document.querySelector(".startseite").style.color = "#fddf85";
  });
  
  document.querySelectorAll(".navigation-bar-links").forEach((item) => {
    item.addEventListener("click", () => {
      document.querySelectorAll(".navigation-bar-links").forEach((item2) => {
        item2.style.color = "#fff" ;
      });
      item.style.color = "#fddf85";
      document.querySelector(".mobil-navigation").style.display = "none";
  
      setTimeout(() => {
        history.replaceState(
          "",
          document.title,
          window.location.origin +
            window.location.pathname +
            window.location.search
        );
      }, 100);
    });
  });
  document.querySelectorAll(".mobil-links").forEach((item) => {
    item.addEventListener("click", () => {
      document
        .querySelector(".mobil-navigation")
        .classList.toggle("mobil-menu-handle");
    });
  });
  
  document
    .querySelector(".mobil-navigation-icon")
    .addEventListener("click", (e) => {
      document
        .querySelector(".mobil-navigation")
        .classList.toggle("mobil-menu-handle");
    });
  
  const username = document.getElementById("username");
  const email = document.getElementById("email");
  const subject = document.getElementById("subject");
  const message = document.getElementById("message");
  let errorUsername = document.getElementById("error-username");
  let errorSubject = document.getElementById("error-subject");
  let errorEmail = document.getElementById("error-email");
  let errorMessage = document.getElementById("error-message");
  
  let pattern = {
    username: /^.{3,50}[a-z0-9]$/,
    email: /([^ ]+)@([^ ]+)\.([a-z]{2,3})(\.[a-z]{2,3})?/,
    subject: /^.{5,50}\w$/,
    message: /^.{10,50}\w$/,
  };
  
  document.querySelectorAll(".inputs").forEach((item) => {
    item.addEventListener("keyup", (e) => {
      e.target.nextElementSibling.innerText = "";
    });
  });
  
  document.getElementById("submit").addEventListener("click", function(e) {
    e.preventDefault();
    if (!username.value.match(pattern.username)) {
      username.focus();
      errorUsername.innerText =
        "Der Benutzername muss mehr als 2 Buchstaben haben!";
    } else if (!email.value.match(pattern.email)) {
      errorEmail.innerText = "E-Mail hat ein ungültiges Format!";
    } else if (!subject.value.match(pattern.subject)) {
      errorSubject.innerText = "Der Betreff muss mehr als 5 Buchstaben haben!";
    } else if (!message.value.match(pattern.message)) {
      errorMessage.innerText =
        "Die Nachricht muss mehr als 10 Buchstaben haben!";
    } else {
      e.preventDefault();
      emailjs.init({
        publicKey: "1riu53UzmeZ24N7vp",
      });
      const data = {
        email: document.getElementById("email").value,
        subject: document.getElementById("subject").value,
        message: document.getElementById("message").value,
      };
      emailjs.send("service_87pljbv", "template_ost5nnu", data).then(
        (response) => {
          alert('Ihre Nachricht wurde erfolgreich gesendet');
        },
        (error) => {
          console.log("FAILED...", error);
        }
      );
      document.getElementById("email-form").reset();
      alert('Message sent')
    }
  });
  
  const sr = ScrollReveal({
    distance: "60px",
    duration: 2500,
    delay: 400,
    reset: true,
  });
  
  sr.reveal(".banner-text", { delay: 100, origin: "top" });
  sr.reveal(".services-container", { delay: 100, origin: "top" });
  sr.reveal(".galerie-title", { delay: 100, origin: "left" });
  sr.reveal(".abouts-title", { delay: 100, origin: "top" });
  sr.reveal(".abouts-text", { delay: 100, origin: "left" });
  sr.reveal(".abouts-img", { delay: 200, origin: "top" });
  sr.reveal(".contact-container", { delay: 100, origin: "top" });
  
  // if ('serviceWorker' in navigator) {
  //   navigator.serviceWorker.register('sw.js').then(res => {
  //       console.log(res)
  //   }).catch((err) => {
  //       console.log(err)
  //   })
  // }
  

});  
