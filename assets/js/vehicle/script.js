import Button from '../import/button'
// import Routing from 'rou'
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
//https://symfony.com/doc/master/bundles/FOSJsRoutingBundle/index.html
import Modal from '../import/modal'
import u from '../import/utility'

$(function () {
  Routing.setRoutingData(routes);

  let saver = new Button('#vehicle-new-saver')
  saver.loadOnClick()

  let btnImporter = new Button('#vehicle-new-importer')

  btnImporter.click(function () {
    $.get(Routing.generate('importer_new')).then(function (view) {
      btnImporter.reset()
      let modal = new Modal()
      modal.setContent(view)

      modal.show(function () {
        let modalBtnSaver = new Button('#modal-importer-saver')
        modalBtnSaver.click(function (e) {
          e.preventDefault()
          modalBtnSaver.loading()

          let $form = $('#modal_form_importer_new')
          var formData = new FormData($form[0])
          $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
              if (!!data.typeMessage) {
                u.notif(data.message, data.typeMessage)
                if (data.typeMessage === 'success') {
                  // TODO: Recuperer le select
                  let select = $('')
                  select.prepend(`<option value="${data.id}">${data.fullname}</option>`)

                  //Ici, j'essaie d'afficher en même temps l'importer
                  select.val(data.id)
                  modal.hide()
                }
              } else {
                u.notif('Erreur fatale. Veuillez contacter le service informatique', 'danger')
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