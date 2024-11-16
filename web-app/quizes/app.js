const quiz  = [
  {
    quiz1: [
      {
        question: "1: Which one is the biggest Counrty?",
        answers: [
          {"name":"Chine", "state": true},
          {"name":"Russian", "state": false},
          {"name":"America", "state": false},
          {"name":"Brasil", "state": false}
        ]
      },
      {
        question: "2: Which one is the longest River?",
        answers: [
          {"name":"Amazon", "state": false},
          {"name":"Nil", "state": true},
          {"name":"Rain", "state": false},
          {"name":"Tune", "state": false}
        ]
      },
      {
        question: "3: Which one is the richest Person?",
        answers: [
          {"name":"Bil Gates", "state": false},
          {"name":"Elin Mask", "state": true},
          {"name":"Messi", "state": false},
          {"name":"King Faysal", "state": false}
        ]
      }
    ],
    quiz2: [
      {
        question: "1: Which one is the biggest Man?",
        answers: [
          {"name":"Chine", "state": true},
          {"name":"Russian", "state": false},
          {"name":"America", "state": false},
          {"name":"Brasil", "state": false}
        ]
      },
      {
        question: "2: Which one is the longest Women?",
        answers: [
          {"name":"Amazon", "state": false},
          {"name":"Nil", "state": true},
          {"name":"Rain", "state": false},
          {"name":"Tune", "state": false}
        ]
      },
      {
        question: "3: Which one is the richest Player?",
        answers: [
          {"name":"Bil Gates", "state": false},
          {"name":"Elin Mask", "state": true},
          {"name":"Messi", "state": false},
          {"name":"King Faysal", "state": false}
        ]
      }
    ]
  }
]

let quizIndex = 0
let score = 0
let correctAnswers = []

const startQuiz = (param = 0) => {
  let selectedQuiz = document.getElementById('quizes').value
  document.getElementById('question').innerText = quiz[0][selectedQuiz][param].question
  quiz[0][selectedQuiz][param].answers.forEach((item, index) => {
    let btn = document.createElement('button')
    btn.setAttribute('id', index)
    btn.classList.add('btn')
    btn.innerText = item.name
    document.getElementById('btn-con').appendChild(btn)


    btn.addEventListener('click', () => {
      document.querySelectorAll('.btn').forEach(item => {
        item.disabled = true
      })
      document.getElementById('btn-next').style.display = 'block'
      if(item.state === true){
        btn.classList.add('btn-true')
        score += 10
        correctAnswers.push(item.name)
      } else {
        btn.classList.add('btn-false')
      }
    })
  })
}

document.getElementById('quizes').addEventListener('change', () => {
  document.getElementById('btn-con').innerText = ''
  startQuiz()
})

document.getElementById('btn-next').addEventListener('click', () => {
  quizIndex += 1
  document.querySelectorAll('.btn').forEach(item => {
    item.remove()
  })
  if(quizIndex > 2){
    document.getElementById('question').innerText = 'Quiz is finished'
    document.getElementById('btn-next').style.display = 'none'
    document.getElementById('score').innerText = 'Correct Answers: ' + correctAnswers + '\n' + 'Your score is : ' + score
  } else {
    startQuiz(quizIndex)
  }
})