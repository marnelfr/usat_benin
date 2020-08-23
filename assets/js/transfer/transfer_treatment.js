import Button from '../import/button'
// import Routing from 'rou'
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
//https://symfony.com/doc/master/bundles/FOSJsRoutingBundle/index.html
import u from '../import/utility'

//Enregistrement
$(function () {
  Routing.setRoutingData(routes);

  //Start treatment
  // const btnStartTreatment = new Button('.transfer-start-treatment')

  const btns = document.querySelectorAll('.transfer-start-treatment')
  btns.forEach(function (btn) {
    let button = new Button(btn)
    button.click(function () {
      const startTreatmentPath = button.data('href')
      $.get(startTreatmentPath).then(function (data) {
        if (data.typeMessage === 'success') {
          window.location = startTreatmentPath
        }else if (data.typeMessage === 'warning') {
          alert(data.message)
        } else {
          u.notif('Erreur de chargement..')
        }
      }).always(function () {
        button.reset()
      })
    })
  })

  /*btnStartTreatment.click(function () {
    const startTreatmentPath = btnStartTreatment.data('href')
    $.get(startTreatmentPath).then(function (data) {
      if (data.typeMessage === 'success') {
        window.location = startTreatmentPath
      }else if (data.typeMessage === 'warning') {
        alert(data.message)
      } else {
        u.notif('Erreur de chargement..')
      }
    }).always(function () {
      btnStartTreatment.reset()
    })
  })*/


  const modalRejectTransfer = new Button('#transfert-verdict-reject')
  modalRejectTransfer.click(function () {
    u.entityModalAdd(modalRejectTransfer, 'staff_reject_transfer', 'modal-transfer-reject-saver', '', {id: modalRejectTransfer.data('id')}, false)
  })

  //Affichage
  u.showPicture('transfer-show-bol', 'vehicle_img')

})
