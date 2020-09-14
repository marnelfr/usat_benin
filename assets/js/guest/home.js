import '../../css/guest/home.scss';
import Button from '../import/button'
import Modal from '../import/modal'
import Utility from '../import/utility'
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

  let connexion = new Button('#connexion')
  connexion.loadOnClick(true)

  //Animation des images
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


  //Animation de la voiture
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


  //Affichage des informations des communiquées
  const link = $('.btn_link')
  link.on('click', function (e) {
    e.preventDefault()
    const btn = $(this)
    const text = btn.html()
    btn.html(text + '<i class="spinner-border spinner-border-sm"></i>')
    $.get(link.attr('href')).then(function (data) {
      btn.html(text)
      if (data.typeMessage) {
        if (data.typeMessage === 'success') {
          const modal = new Modal(false, 'large')
          modal.setContent(data.view)
          modal.show()
        } else {
          alert(data.message)
        }
      } else {
        alert('Erreur de chargement...')
      }
    })
  })


  //Affichage des informations d'un parc
  const fleetBtn = new Button('#guest-show-fleet')
  fleetBtn.click(function () {
    import('../../../public/js/fos_js_routes.json').then(({default: routes}) => {
      import('../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js').then(({default: Routing}) => {
        Routing.setRoutingData(routes);
        let $form = fleetBtn.getForm()
        $.ajax({
          url: $form.attr('action'),
          type: 'POST',
          data: new FormData($form[0]),
          processData: false,
          contentType: false,
          success: function (data) {
            if (data.typeMessage) {
              const modal = new Modal()
              modal.setContent(data.view)
              modal.show()
            } else {
              alert('Echec de chargement. Veuillez réessayer');
            }
          },
          error: function () {
            alert('Echec de chargement. Veuillez réessayer');
          }
        }).always(function () {
          fleetBtn.reset()
        });
      })
    })

  })
})

