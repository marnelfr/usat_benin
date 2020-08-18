import Button from '../import/button'
// import Routing from 'rou'
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
//https://symfony.com/doc/master/bundles/FOSJsRoutingBundle/index.html
import Modal from '../import/modal'
import u from '../import/utility'

//Enregistrement
$(function () {
  Routing.setRoutingData(routes);

  let saver = new Button('#transfer-new-saver')
  saver.loadOnClick(true)
  if (saver.text().trim() === 'Renvoyer la demande') {
    $('#vehicle_bol').removeAttr('required')
  }

  let btnImporter = new Button('#vehicle-new-importer')

  btnImporter.click(function () {
    $.get(Routing.generate('importer_new')).then(function (data) {
      btnImporter.reset()
      let modal = new Modal()
      modal.setContent(data.view)

      modal.show(function () {
        let modalBtnSaver = new Button('#modal-importer-saver')
        modalBtnSaver.click(function () {
          let $form = modalBtnSaver.getForm()
          let formData = new FormData($form[0])
          $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
              if (!!data.typeMessage) {
                if (data.typeMessage === 'success') {
                  u.notif(data.message, data.typeMessage)
                  let select = $('#vehicle_importer')
                  select.prepend(`<option value="${data.id}">${data.name}</option>`)

                  //Ici, j'essaie d'afficher en même temps l'importer
                  select.val(data.id)
                  modal.hide()
                } else {
                  modal.setContent(data.view)
                }
              } else {
                u.notif('Echec de chargement.', 'danger')
              }
            },
            error: function () {
              u.notif("Echec de chargement. Veuillez réessayer", 'warning');
            }
          }).always(function () {
            modalBtnSaver.reset()
          });

        })
      })
    })
  })

})

//Affichage
$(function () {
  Routing.setRoutingData(routes);
  let btn = new Button('#transfer-show-bol')
  btn.click(function () {
    $.get(Routing.generate('vehicle_img', {id: btn.data('id')})).then(function (view) {
      btn.reset()
      let modal = new Modal()
      modal.setContent(view)
      modal.show()
    })
  })
})