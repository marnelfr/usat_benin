import Button from '../import/button'
import Modal from '../import/modal'
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

$(function () {
  let btn = new Button('.btn-remover-saver')
  btn.loadOnClick(true)
})


//Affichage
$(function () {
  Routing.setRoutingData(routes);
  let btn = new Button('#remover-show-cin')
  btn.click(function () {
    $.get(Routing.generate('remover_img', {id: btn.data('id')})).then(function (view) {
      btn.reset()
      let modal = new Modal()
      modal.setContent(view)
      modal.show()
    })
  })
})