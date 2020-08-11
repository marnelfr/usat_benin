import Button from '../import/button'
// import Routing from 'rou'
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import Modal from '../import/modal'
//https://symfony.com/doc/master/bundles/FOSJsRoutingBundle/index.html

$(function () {
  Routing.setRoutingData(routes);
  let btnImporter = new Button('#vehicle-new-importer')
  btnImporter.click(function () {
    btnImporter.loading()
    $.get(Routing.generate('importer_new')).then(function (view) {
      btnImporter.reset()
      let modal = new Modal()
      modal.setContent(view)
      modal.show()
    })
  })
})