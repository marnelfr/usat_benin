import Button from '../import/button'
import u from '../import/utility'
import Modal from '../import/modal'
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
//https://symfony.com/doc/master/bundles/FOSJsRoutingBundle/index.html

$(function () {
  Routing.setRoutingData(routes);

  //Etape 1 du formulaire de demande
  //Pour la vérification de l'existance d'un vehicule a parti de son numéro chassis et sa marque
  let btnVehicleChecker = new Button('#removal-vehicle-checker')
  btnVehicleChecker.click(function () {
    let $form = btnVehicleChecker.getForm()
    let formData = new FormData($form[0])
    $.ajax({
      url: $form.attr('action'),
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (data) {
        //Si typeMessage n'est pas défini, alors c'est pas moi-même, j'ai fait le retour
        if (!!data.typeMessage) {
          //C'est qu'il y a une erreur par rapport à la validation du formulaire
          if (data.typeMessage === 'form') {
            //On affiche donc le nouveau formulaire reçu
            $form.closest('div').html(data.form)

          } else
          //Un vehicule a été trouvé, on affiche donc ses informations dans un modal
          if (data.typeMessage === 'vehicle_found') {
            const modal = new Modal()
            modal.setContent(data.show_view)
            modal.show(function () {
              //Si l'utilisateur accepte utiliser le vehicule retrouve a base de ses informations,
              // on l'envoie à l'étape 2 du formulaire de demande
              const btn = new Button('#removal-use-vehicle')
              btn.loadOnClick()
            })
          } else
            //Si aucun vehicule n'est trouvé, on renvoie la vue de l'etape 2 du formulaire
          if(data.typeMessage === 'next') {
            $('.content').html(data.view_new_vehicle)
            let vehicleSaver = new Button('#vehicle-new-saver')
            vehicleSaver.loadOnClick(true)

            let modalAddRemover = new Button('#vehicle-new-importer')
            modalAddRemover.click(function () {
              u.entityModalAdd(modalAddRemover, 'importer_new', 'modal-importer-saver', 'vehicle_importer')
            })
          } else {
            u.notif('Echec de chargement...', 'warning')
          }
        } else {
            u.notif('Echec de chargement... Veuillez vérifier votre connexion internet et réessayer.', 'danger')
        }
      },
      error: function () {
        u.notif("Echec de chargement. Veuillez vérifier votre connexion internet et réessayer", 'danger');
      }
    }).always(function () {
      btnVehicleChecker.reset()
    });
  })


  //Pour l'étape 3 du forumaire de demande
  let modalAddRemover = new Button('#vehicle-new-remover')
  modalAddRemover.click(function () {
    u.entityModalAdd(modalAddRemover, 'remover_new', 'modal-remover-saver', 'removal_remover')
  })


  //Submit du formulaire de demande
  let removalSaver = new Button('#removal-new-saver')
  removalSaver.loadOnClick(true)

  //Affichage
  u.showPicture('removal-show-bol', 'removal_img')
  u.showPicture('removal-show-bfu', 'removal_img')
  u.showPicture('removal-show-entry', 'removal_img')
  u.showPicture('removal-show-receipt', 'removal_img')
})

