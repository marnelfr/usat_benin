import Modal from './modal'
import Button from './button'

export default class Utility {

  static notif(message, type) {
    if (type === 'danger') {
      type = 'error'
    }
    import('sweetalert2').then(({default: Swal}) => {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 15000
      });
      Toast.fire({
        icon: type,
        title: message,
      })
    })


    /*
    if(!type) type = 'success'
    let element = $('#alert-raw')
    element.fadeOut(1)
    element.removeClass('alert-danger')
    element.removeClass('alert-success')
    element.removeClass('alert-warning')
    element.addClass('alert-' + type)
    element.find('p').text(message)
    element.fadeIn(500)
    setTimeout(function () {
      element.fadeOut(2000)
    }, 10000)*/
  }


  /**
   * Fonction utilisable pour les ajouts d'entité via modal
   *
   * Cette fonction-ci se charge principalement de charger le formulaire d'ajout dans le modal et
   * Afficher le modal. Une fois le modal affiché, il appel modalFormRuner() pour la suite
   *
   * @param btnModalAdd         C'est le btn présent sur le formulaire parent, sur lequel on click pour charger le modal
   * @param form_path           Le chemin de l'action d'ajout de l'entité. Est sensé aussi renvoyé le formulaire
   * @param idModalBtnSaver     L'id du btn d'enregistrement présent sur le modal.
   * @param idSelectList        L'id du select contenant la liste de l'entité dont on veut faire un nouveau enregistrement
   * @param path_data
   * @param ajax_treatment
   */
  static entityModalAdd (btnModalAdd, form_path, idModalBtnSaver, idSelectList, path_data = {}, ajax_treatment = true) {
    import('../../../public/js/fos_js_routes.json').then(({default: routes}) => {
      import('../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js').then(({default: Routing}) => {
        Routing.setRoutingData(routes);
        $.get(Routing.generate(form_path, path_data)).then(function (data) {
          if (data.typeMessage) {
            btnModalAdd.reset()
            let modal = new Modal()
            modal.setContent(data.view)

            modal.show(function () {
              let modalBtnSaver = new Button('#'+idModalBtnSaver)
              modalBtnSaver.click(function () {
                Utility.modalFormRuner(modal, modalBtnSaver, idModalBtnSaver, idSelectList, ajax_treatment)
              })
            })
          }else{
            u.notif('danger', 'Erreur de chargement..')
          }
        })
      })
    })
  }

  /**
   * Principalement utiliser pour la soumission du formulaire d'ajout d'entité
   *
   * Le fait est que si le formulaire n'est pas valide après soumission,
   * Le formulaire est renvoyé et il faut remettre les points sur les i pour sa soumission
   * Donc la fonction se rappel au fait.
   * D'où le besoin de le mettre à part: pour qu'elle puisse se rappeler
   *
   * @param modal
   * @param modalBtnSaver
   * @param idModalBtnSaver
   * @param idSelectList
   */
  static modalFormRuner (modal, modalBtnSaver, idModalBtnSaver, idSelectList, ajax_treatment) {
    let $form = modalBtnSaver.getForm()
    if (!ajax_treatment) {
      $form.submit()
      return;
    }
    let formData = new FormData($form[0])
    $.ajax({
      url: $form.attr('action'),
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (data) {
        if (!!data.typeMessage) {
          if (data.typeMessage === 'success') {
            Utility.notif(data.message, data.typeMessage)
            let select = $('#'+idSelectList)
            if (select.length > 0) {
              select.prepend(`<option value="${data.id}">${data.name}</option>`)

              //Ici, j'affiche en même temps l'enleveur
              select.val(data.id)
              modal.hide()
            }
          } else {
            //Les informations entrées dans le formulaire se sont pas valides
            modal.setContent(data.view)
            let modalBtnSaver2 = new Button('#'+idModalBtnSaver)
            modalBtnSaver2.click(function () {
              Utility.modalFormRuner(modal, modalBtnSaver2, idModalBtnSaver, idSelectList)
            })
          }
        } else {
          Utility.notif('Echec de chargement.', 'danger')
        }
      },
      error: function () {
        Utility.notif("Echec de chargement. Veuillez réessayer", 'warning');
      }
    }).always(function () {
      modalBtnSaver.reset()
    });
  }


  static showPicture(btnID, imgPath) {
    import('../../../public/js/fos_js_routes.json').then(({default: routes}) => {
      import('../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js').then(({default: Routing}) => {
        Routing.setRoutingData(routes);
        let btn = new Button('#'+btnID)
        btn.click(function () {
          let datum = {id: btn.data('id')}
          if (btn.data('use')) {
            datum['use'] = btn.data('use')
          }
          $.get(Routing.generate(imgPath, datum)).then(function (data) {
            if (data.error) {
              alert('Aucune image trouvée')
            }else{
              let modal = new Modal()
              modal.setContent(data.view)
              modal.show()
            }
          }).always(function () {
            btn.reset()
          })
        })
      })
    })
  }


}