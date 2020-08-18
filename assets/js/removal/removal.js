import Button from '../import/button'
import u from '../import/utility'
import Modal from '../import/modal'

$(function () {
  //Pour l'étape 3 du forumaire de demande
  let removalSaver = new Button('#removal-new-saver')
  removalSaver.loadOnClick(true)

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
              const btn = new Button('#removal-use-vehicle')
              btn.loadOnClick()
            })
          } else {
            u.notif('Echec de chargement', 'danger')
          }
        } else {
          $('.content').html(data)
          let vehicleSaver = new Button('#vehicle-new-saver')
          vehicleSaver.loadOnClick(true)
        }
      },
      error: function () {
        u.notif("Echec de chargement. Veuillez réessayer", 'warning');
      }
    }).always(function () {
      btnVehicleChecker.reset()
    });
  })
})