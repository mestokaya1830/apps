document.getElementById("go-top").addEventListener("click", (e) => {
  window.scrollTo(0, 0);
});

document.querySelectorAll('.links').forEach(item => {
  item.addEventListener('click', () => {
    document.querySelectorAll('.links').forEach(item2 => {
      item2.style.color = "#fff"
    })
    item.style.color = '#fddf85'
  })
})