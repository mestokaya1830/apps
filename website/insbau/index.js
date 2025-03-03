document.getElementById("go-top").addEventListener("click", (e) => {
  window.scrollTo(0, 0);
});

document.querySelectorAll('.links').forEach(item => {
  item.addEventListener('click', () => {
    document.querySelectorAll('.links').forEach(item2 => {
      item2.style.color = "#fff"
    })
    item.style.color = '#fddf85'
    document.querySelector('.mobil-navigation').style.display = "none"
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

document.getElementById('submit').addEventListener('click' , (e) => {
  e.preventDefault()
  if(!username.value.match(pattern.username)){
    username.focus()
    errorUsername.innerText = 'Username must be more 2 letter!'
  } else if(!email.value.match(pattern.email)){
    errorEmail.innerText = 'Email is invalid format!'
  } else if(!subject.value.match(pattern.subject)){
    errorSubject.innerText = 'Subject must be more 5 letter!'
  } else if(!message.value.match(pattern.message)){
    errorMessage.innerText = 'Message must be more 10 letter!'
  } else {
    document.getElementById("email-form").reset();
  }
})