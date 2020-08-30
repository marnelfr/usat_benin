import Modal from '../import/modal'
import Button from '../import/button'

$(function () {
  // TODO: Faire les controlles par rapport aux champs renseigner et tout avant de permettre le changement de page
  $('#register_next').click(function (e) {
    e.preventDefault()
    if ($('#registration_form_profil').val() === 'agent') {
      $('#registration_form_fleet').closest('.form-group').addClass('d-none')
    } else {
      $('#registration_form_fleet').closest('.form-group').removeClass('d-none')
    }
    $('#register_first_page').fadeOut(1000)
    $('#register_last_page').fadeIn(1000)
  })

  $('#register_prev').click(function (e) {
    e.preventDefault()
    $('#register_first_page').fadeIn(1000)
    $('#register_last_page').fadeOut(1000)
  })

  let label = $('#registration_form_agreeTerms').closest('.form-check').find('label')
  label.html(
    `J'accepte <a href="#">les conditions d'utilisation</a>`
  )
  label.find('a').on('click', function (e) {
    e.preventDefault()
    const btn = $(this)
    btn.html(`les conditions d'utilisation <i class="spinner-border spinner-border-sm"></i>`)
    import('../../../public/js/fos_js_routes.json').then(({default: routes}) => {
      import('../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js').then(({default: Routing}) => {
        Routing.setRoutingData(routes);
        $.get(Routing.generate('condition_show')).then(function (data) {
          if (data.typeMessage) {
            const modal = new Modal()
            modal.setContent(data.view)
            modal.show(function () {
              $('#close-condition').on('click', function () {
                modal.hide()
              })
            })
          }else{
            alert('Erreur de chargement...')
          }
        }).always(function () {
          btn.text('les conditions d\'utilisation')
        })
      })
    })
  })

  const register = new Button('#btn-registration')
  register.loadOnClick(true)

})