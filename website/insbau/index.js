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