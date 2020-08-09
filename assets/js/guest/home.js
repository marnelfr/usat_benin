import '../../css/guest/home.scss';
// import $ from 'jquery';
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything

$(function () {
  $('.btn-plus').on('click', (e) => {
    e.preventDefault()
    alert('Fonctionnalité non codée pour le moment')
  })

  $('.btn-ambition').on('mouseover', function(){
    $('.details').hide()
    $('.ambition').show('slow')
  })

  $('.btn-ambition').on('mouseout', function(){
    $('.ambition').hide('slow')
  })

  $('.btn-service').on('mouseover', function(){
    $('.details').hide()
    $('.services').show('slow')
  })

  $('.btn-service').on('mouseout', function(){
    $('.services').hide('slow')
  })

  $('.btn-contacte').on('mouseover', function(){
    $('.details').hide()
    $('.contacte').show('slow')
  })

  $('.btn-contacte').on('mouseout', function(){
    $('.contacte').hide('slow')
  })

  /*$('.btn-enregistrement').on('click', function(){
    $('.enregistrement').toggle('slow')
  })*/

  $('.btn-ambition').on('click', function (e) {
    e.preventDefault()
    alter('okkdsdss')
  })

  $('#connexion').on('click', function (e) {
    $(this).button('loading')
  })

  let i = 1
  let ff = function () {
    setInterval(() => {
      if (i === 1) {
        i = 2
        document.querySelector('#imgc2').setAttribute('style', '');

        document.querySelector('#imgc1').setAttribute('style', 'display: none');
        document.querySelector('#imgc3').setAttribute('style', 'display: none');
      } else if (i === 2) {
        i = 3
        document.querySelector('#imgc3').setAttribute('style', '');

        document.querySelector('#imgc1').setAttribute('style', 'display: none');
        document.querySelector('#imgc2').setAttribute('style', 'display: none');
      } else if (i === 3) {
        i = 1
        document.querySelector('#imgc1').setAttribute('style', '');

        document.querySelector('#imgc3').setAttribute('style', 'display: none');
        document.querySelector('#imgc2').setAttribute('style', 'display: none');
      }
    }, 5000)
  }
  ff()


  let ij = 1
  let fff = function () {
    setInterval(() => {
      if (ij === 1) {
        ij = 2
        document.querySelector('#auto2').setAttribute('style', '');

        document.querySelector('#auto1').setAttribute('style', 'display: none');
        document.querySelector('#auto3').setAttribute('style', 'display: none');
        document.querySelector('#auto4').setAttribute('style', 'display: none');
        document.querySelector('#auto5').setAttribute('style', 'display: none');
      } else if (ij === 2) {
        ij = 3
        document.querySelector('#auto3').setAttribute('style', '');

        document.querySelector('#auto1').setAttribute('style', 'display: none');
        document.querySelector('#auto2').setAttribute('style', 'display: none');
        document.querySelector('#auto4').setAttribute('style', 'display: none');
        document.querySelector('#auto5').setAttribute('style', 'display: none');
      } else if (ij === 3) {
        ij = 4
        document.querySelector('#auto4').setAttribute('style', '');

        document.querySelector('#auto1').setAttribute('style', 'display: none');
        document.querySelector('#auto2').setAttribute('style', 'display: none');
        document.querySelector('#auto3').setAttribute('style', 'display: none');
        document.querySelector('#auto5').setAttribute('style', 'display: none');
      } else if (ij === 4) {
        ij = 5
        document.querySelector('#auto5').setAttribute('style', '');

        document.querySelector('#auto1').setAttribute('style', 'display: none');
        document.querySelector('#auto2').setAttribute('style', 'display: none');
        document.querySelector('#auto3').setAttribute('style', 'display: none');
        document.querySelector('#auto4').setAttribute('style', 'display: none');
      } else if (ij === 5) {
        ij = 1
        document.querySelector('#auto1').setAttribute('style', '');

        document.querySelector('#auto5').setAttribute('style', 'display: none');
        document.querySelector('#auto2').setAttribute('style', 'display: none');
        document.querySelector('#auto3').setAttribute('style', 'display: none');
        document.querySelector('#auto4').setAttribute('style', 'display: none');
      }
    }, 2000)
  }
  fff()


  let logoutPath = document.querySelector('#lph')
  if (!!logoutPath) {
    $.get(logoutPath.value)
  }
})

