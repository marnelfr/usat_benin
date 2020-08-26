import '@fortawesome/fontawesome-free/css/all.min.css'
import '../css/adminlte.min.scss'
import '../css/admin.scss';

import 'jquery'
import 'bootstrap'

import '../js/adminlte.min'
import '../js/demo'
import Button from './import/button'
import Modal from './import/modal'
import u from './import/utility'


$(function () {
  setTimeout(function () {
    $('.alert').fadeOut(2000)
  }, 10000)
})




$(function () {
    let changer = document.querySelector('#e84nel915737a83ea2a59627de15bc521')
    if (!!changer) {
      import('../../public/js/fos_js_routes.json').then(({default: routes}) => {
        import('../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js').then(({default: Routing}) => {
          Routing.setRoutingData(routes);
          $.get(Routing.generate('pcn')).then(function (data) {
            if (data.typeMessage) {
              const modal = new Modal(true)
              modal.setContent(data.view)
              modal.show(function () {
                let modalBtnSaver = new Button('#change-password-saver')
                modalBtnSaver.click(function () {
                  let $form = modalBtnSaver.getForm()
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
                          let div = $form.closest('div')
                          div.html(data.form)
                          div.find('.message').html('<p style="color: red"><i class="fas fa-exclamation-circle fa-2x"></i> <br> Les codes doivent être les mêmes et comporter au moins 6 charatères.</p>')

                        } else
                        //Un vehicule a été trouvé, on affiche donc ses informations dans un modal
                        if (data.typeMessage === 'success') {
                          window.location = data.link
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
            }else{
              u.notif('danger', 'Erreur de chargement..')
            }
          })
        })
      })
    }
})