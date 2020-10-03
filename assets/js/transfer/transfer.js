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


  let modalAddRemover = new Button('#vehicle-new-importer')
  modalAddRemover.click(function () {
    u.entityModalAdd(modalAddRemover, 'importer_new', 'modal-importer-saver', 'vehicle_importer')
  })

  //Affichage
  u.showPicture('transfer-show-bol', 'vehicle_img')
  u.showPicture('transfer-show-assurance', 'transfer_img')

  //Affichage pdf   static showPdf(btnID, pdfPath, typeDemand) {
  u.showPdf('transfer-show-attestation', 'transfer_attestation_pdf', 'transfer')
    //modal.setContent('<embed src="https://www.labri.fr/perso/billaud/Resources/resources/bash2004/COURS-BASH-2004.pdf" width="100%" height="600" type="application/pdf">')

})
