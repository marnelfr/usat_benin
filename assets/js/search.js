import Button from './import/button'

$(function () {
  setTimeout(function () {
    const btn = new Button('#search-btn')
    btn.click(function () {
      let search = $('#search-term').val()
      search = search.split(' ').join('+')
      window.location = 'https://www.google.com/search?q=' + search
    })
  }, 1000)
})