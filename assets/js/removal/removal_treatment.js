import Button from '../import/button'
// import Routing from 'rou'
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
//https://symfony.com/doc/master/bundles/FOSJsRoutingBundle/index.html
import u from '../import/utility'
import Cookies from 'js-cookie'
//Enregistrement
$(function () {
  Routing.setRoutingData(routes);
  const approval = new Button('#removal-verdict-accept')
  approval.loadOnClick(false, function () {
    const interval = setInterval(function () {
      if (Cookies.get('downloaded') == 1) {
        clearInterval(interval)
        // approval.reset()
        window.location = Routing.generate('staff_removal_finalized')
      }
    }, 1000)
  })

  const btns = document.querySelectorAll('.removal-start-treatment')
  btns.forEach(function (btn) {
    let button = new Button(btn)
    button.click(function () {
      const startTreatmentPath = button.data('href')
      $.get(startTreatmentPath).then(function (data) {
        if (data.typeMessage === 'success') {
          window.location = startTreatmentPath
        }else if (data.typeMessage === 'warning') {
          button.reset()
          alert(data.message)
        } else {
          button.reset()
          u.notif('Erreur de chargement..')
        }
      })
    })
  })



  const modalRejectRemoval = new Button('#removal-verdict-reject')
  modalRejectRemoval.click(function () {
    u.entityModalAdd(modalRejectRemoval, 'staff_reject_removal', 'modal-removal-reject-saver', '', {id: modalRejectRemoval.data('id')}, false)
  })

  //Affichage
  u.showPicture('removal-show-bol', 'vehicle_img')
  u.showPicture('removal-show-bfu', 'removal_img')
  u.showPicture('removal-show-entry', 'removal_img')
  u.showPicture('removal-show-receipt', 'removal_img')

})
