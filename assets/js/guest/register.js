import Modal from '../import/modal'

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
    const modal = new Modal()
    modal.setContent(`
    
    `)
    modal.show(function () {
      $('#condition-btn').on('click', function () {
        modal.hide()
      })
    })
  })

})