
document.addEventListener('DOMContentLoaded',() => {
  window.onscroll = () => {
    if(document.body.scrollTop > 500 || document.documentElement.scrollTop > 500){
     document.getElementById('go-top').style.display = 'block'
    } else {
      document.getElementById('go-top').style.display = 'none'
    }
  }
  document.getElementById('home').style.color = '#fddf85'
  document.getElementById("go-top").addEventListener("click", (e) => {
    window.scrollTo(0, 0);
    document.querySelectorAll('.links').forEach(item2 => {
      item2.style.color = "#fff"
    })
    document.getElementById('home').style.color = '#fddf85'
  });
  
  document.querySelectorAll('.links').forEach(item => {
    item.addEventListener('click', () => {
      document.querySelectorAll('.links').forEach(item2 => {
        item2.style.color = "darkgray"
      })
      item.style.color = '#fddf85'
      document.querySelector('.mobil-navigation').style.display = "none"
     
      setTimeout(() => {
        history.replaceState('', document.title, window.location.origin + window.location.pathname + window.location.search);
      }, 0);
    })
  })
  document.querySelectorAll('.mobil-links').forEach(item => {
    item.addEventListener('click', () => {
      document.querySelector('.mobil-navigation').classList.toggle('mobil-menu-handle')
    })
  })
  
  document.querySelector('.mobil-navigation-icon').addEventListener('click', (e) => {
    document.querySelector('.mobil-navigation').classList.toggle('mobil-menu-handle')
  })
  
  const username = document.getElementById('username')
  const email = document.getElementById('email')
  const subject = document.getElementById('subject')
  const message = document.getElementById('message')
  let errorUsername =  document.getElementById('error-username')
  let errorSubject =  document.getElementById('error-subject')
  let errorEmail =  document.getElementById('error-email')
  let errorMessage =  document.getElementById('error-message')
  
  let pattern = {
    username: /^.{3,50}[a-z0-9]$/,
    email: /([^ ]+)@([^ ]+)\.([a-z]{2,3})(\.[a-z]{2,3})?/,
    subject: /^.{5,50}\w$/,
    message:/^.{10,50}\w$/
  }
  
  document.querySelectorAll('.inputs').forEach(item => {
    item.addEventListener('keyup', (e) => {
      e.target.nextElementSibling.innerText = ''
    })
  })
  
  
  const sr = ScrollReveal ({
    distance: '60px',
    duration: 2500,
    delay: 400,
    reset: true
  })
  
  sr.reveal('.logo-container', { delay: 100, origin: 'top'})
  sr.reveal('.banner-center', { delay: 100, origin: 'bottom'})
  sr.reveal('.aboutus-right-title', { delay: 100, origin: 'top'})
  sr.reveal('.aboutus-right-btn', { delay: 100, origin: 'bottom'})
  sr.reveal('.services-title', { delay: 100, origin: 'top'})
  sr.reveal('.services-text', { delay: 100, origin: 'bottom'})
  sr.reveal('.contact', { delay: 100, origin: 'top'})
  
  // if ('serviceWorker' in navigator) {
  //   navigator.serviceWorker.register('sw.js').then(res => {
  //       console.log(res)
  //   }).catch((err) => {
  //       console.log(err)
  //   })
  // }

  // document.getElementById("submit").addEventListener("click", (e) => {
  //   e.preventDefault();
  //   if(!username.value.match(pattern.username)){
  //     username.focus()
  //     errorUsername.innerText = 'Der Benutzername muss mehr als 2 Buchstaben haben!'
  //   } else if(!email.value.match(pattern.email)){
  //     errorEmail.innerText = 'E-Mail hat ein ungültiges Format!'
  //   } else if(!subject.value.match(pattern.subject)){
  //     errorSubject.innerText = 'Der Betreff muss mehr als 5 Buchstaben haben!'
  //   } else if(!message.value.match(pattern.message)){
  //     errorMessage.innerText = 'Die Nachricht muss mehr als 10 Buchstaben haben!'
  //   } else {
  //     emailjs.init({
  //       publicKey: "dfViWTkCiA7tGvXSm",
  //     });
  //     const data = {
  //       email: document.getElementById("email").value,
  //       subject: document.getElementById("subject").value,
  //       message: document.getElementById("message").value,
  //     };
  //     emailjs
  //       .send("service_18hr2f9", "template_nr7p6b2", data)
  //       .then(
  //         (response) => {
  //           console.log("SUCCESS!", response.status, response.text);
  //         },
  //         (error) => {
  //           console.log("FAILED...", error);
  //         }
  //       );
  //     document.getElementById("email-form").reset();
  //   }
   
  // });
})
