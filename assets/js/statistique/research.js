import u from '../import/utility'

const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import Button from '../import/button'

export default class Research{
  debut
  fin
  btn
  container

  constructor(debut, fin, load_btn, container) {
    this.container = $(container)
    this.btn = new Button(load_btn)
    this.debut = $(debut)
    this.fin = $(fin)
    Routing.setRoutingData(routes);

    //La première exécution au chargement de la page
    this.search(true)

    //A chaque fois qu'on clique sur le bouton de chargement
    this.btn.click(this.search)
  }

  search(initialLoad = false) {
    const dateDebut = this.debut.val()
    const dateFin = this.fin.val()
    $.get(Routing.generate('statistic_load', {debut: dateDebut, fin: dateFin, initial: initialLoad})).then(function (data) {
      if (data.typeMessage) {
        if (data.typeMessage === 'warning') {
          u.notif(data.message, data.typeMessage)
        } else {
          this.container.html(data.view)
        }
      }else{
        u.notif('Erreur de chargement des statistiques', 'danger')
      }
    })
  }


}