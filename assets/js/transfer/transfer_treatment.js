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


  let modalRejectTransfer = new Button('#transfert-verdict-reject')
  modalRejectTransfer.click(function () {
    u.entityModalAdd(modalRejectTransfer, 'staff_reject_transfer', 'modal-transfer-reject-saver', '', {id: modalRejectTransfer.data('id')}, false)
  })

  //Affichage
  u.showPicture('transfer-show-bol', 'vehicle_img')

})
