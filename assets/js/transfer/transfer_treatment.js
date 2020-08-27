import Button from '../import/button'
// import Routing from 'rou'
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
//https://symfony.com/doc/master/bundles/FOSJsRoutingBundle/index.html
import u from '../import/utility'
import Modal from '../import/modal'
import Cookies from 'js-cookie'

$(function () {
  Routing.setRoutingData(routes);
  //Approval
  const approval = new Button('#transfert-verdict-accept')
  approval.loadOnClick(false, function () {
    const interval = setInterval(function () {
      if (Cookies.get('downloaded') == 1) {
        clearInterval(interval)
        // approval.reset()
        //window.location = Routing.generate('staff_transfer_inprogress')
      }
    }, 1000)
  })

  //Finalisation
  const finalizers = document.querySelectorAll('.staff-transfer-finalizer')
  finalizers.forEach(function (btn) {
    const finalizer = new Button(btn)
    finalizer.click(function () {
      $.get(Routing.generate('staff_finalize_transfer', {id: finalizer.data('id')})).then(function (data) {
        if (data.typeMessage) {
          let modal = new Modal()
          modal.setContent(data.view)
          //On informe l'utilisateur de ce qui se passe
          u.notif("Veuillez renseigner le fichier d'assurance", 'info')
          //On affiche le formulaire
          modal.show(function () {
            let modalBtnSaver = new Button('#modal-transfer-finalizer-saver')
            //Le formulaire sera soumit par ajax
            modalBtnSaver.click(function () {
              let $form = modalBtnSaver.getForm()
              let formData = new FormData($form[0])
              $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false, //todo: je crois que l'un de ces machins là est à true. il faut voir
                contentType: false,
                success: function (data) {
                  //Si typeMessage n'est pas défini, alors c'est pas moi-même, j'ai fait le retour
                  if (!!data.typeMessage) {
                    //C'est qu'il y a une erreur par rapport à la validation du formulaire
                    if (data.typeMessage === 'form') {
                      //On affiche donc le nouveau formulaire reçu
                      let div = $form.closest('div')
                      div.html(data.form)
                      //u.notif('Les codes doivent être les mêmes et comporter au moins 6 charatères.', 'info')
                      modalBtnSaver.reset()
                    } else
                    //On ferme le modal et supprime la ligne de la demande de transfer de la liste des demandes en cours
                    if (data.typeMessage === 'success') {
                      modal.hide()
                      const row = finalizer.row()
                      row.hide('slow', function () {
                        row.remove()
                        u.notif('Demande de transfert finalisée avec succès', 'success')
                      })
                    } else {
                      u.notif('Echec de chargement...', 'warning')
                    }
                  } else {
                    u.notif('Echec de chargement... Veuillez vérifier votre connexion internet et réessayer.', 'danger')
                  }
                },
                error: function () {
                  modalBtnSaver.reset()
                  u.notif("Echec de chargement. Veuillez vérifier votre connexion internet et réessayer", 'danger');
                }
              })
            })
          })
        } else {
          u.notif('Erreur de chargement. Veuillez vérifier votre connexion internet et réessayer', 'danger')
        }
      }).always(function () {
        finalizer.reset()
      })
    })
  })

  //Index
  //Le seul moyen que j'ai trouvé pour ma class Button avec plusieurs btn en même temps
  const btns = document.querySelectorAll('.transfer-start-treatment')
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



  //Rejected
  const modalRejectTransfer = new Button('#transfert-verdict-reject')
  modalRejectTransfer.click(function () {
    u.entityModalAdd(modalRejectTransfer, 'staff_reject_transfer', 'modal-transfer-reject-saver', '', {id: modalRejectTransfer.data('id')}, false)
  })

  //Affichage
  u.showPicture('transfer-show-bol', 'vehicle_img')
  u.showPicture('transfer-show-assurance', 'transfer_img')

})
