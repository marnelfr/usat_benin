$(function () {
  // TODO: Faire les controlles par rapport aux champs renseigner et tout avant de permettre le changement de page
  $('#register_next').click(function (e) {
    e.preventDefault()
    if ($('#registration_form_profil').val() === 'commissionnaire') {
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
})