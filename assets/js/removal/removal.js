import Button from '../import/button'
import u from '../import/utility'
import Modal from '../import/modal'

$(function () {
  let removalSaver = new Button('#removal-new-saver')
  removalSaver.loadOnClick(true)

  let btnVehicleChecker = new Button('#removal-vehicle-checker')
  btnVehicleChecker.click(function () {
    let $form = btnVehicleChecker.getForm()
    let formData = new FormData($form[0])
    $.ajax({
      url: $form.attr('action'),
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (data) {
        if (!!data.typeMessage) {
          if (data.typeMessage === 'form') {
            $form.closest('div').html(data.form)
          } else if (data.typeMessage === 'vehicle_found') {
            const modal = new Modal()
            modal.setContent(data.show_view)
            modal.show(function () {
              const btn = new Button('#removal-use-vehicle')
              btn.loadOnClick()
            })
          } else {
            u.notif('Echec de chargement', 'danger')
          }
        } else {
          $('.content').html(data)
          let vehicleSaver = new Button('#vehicle-new-saver')
          vehicleSaver.loadOnClick(true)
        }
      },
      error: function () {
        u.notif("Echec de chargement. Veuillez réessayer", 'warning');
      }
    }).always(function () {
      btnVehicleChecker.reset()
    });
  })
})