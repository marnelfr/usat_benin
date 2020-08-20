import Button from '../import/button'
import Modal from '../import/modal'
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import u from '../import/utility'

$(function () {
  let btn = new Button('.btn-remover-saver')
  btn.loadOnClick(true)

  //Affichage
  u.showPicture('remover-show-cin', 'remover_img')
})


//Affichage
/*
$(function () {
  Routing.setRoutingData(routes);
  let btn = new Button('#')
  btn.click(function () {
    $.get(Routing.generate('', {id: btn.data('id')})).then(function (view) {
      btn.reset()
      let modal = new Modal()
      modal.setContent(view)
      modal.show()
    })
  })
})*/
