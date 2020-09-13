import '@fortawesome/fontawesome-free/css/all.min.css'
import '../css/adminlte.min.scss'
import '../css/admin.scss';

import 'jquery'
import 'bootstrap'

import '../js/adminlte.min'
import '../js/demo'
import u from './import/utility'
import Table from './import/table'


$(function () {
  let table = new Table()
  table.DataTable()
  setTimeout(function () {
    //Permet d'afficher les alerts au chargement de la page
    $('.alert').each(function () {
      const alert = $(this)
      u.notif(alert.val(), alert.attr('data-type'))
    })
  }, 1000)
})

$(function () {
  //Si l'input ayant pour id, ce token est présent dans menu_items.html.twig,
  // c'est que l'utilisateur doit changer son mot de passe
  let changer = document.querySelector('#e84nel915737a83ea2a59627de15bc521')
  if (!!changer) {
    import('../../public/js/fos_js_routes.json').then(({default: routes}) => {
      import('../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js').then(({default: Routing}) => {
        import('./import/button').then(({default: Button}) => {
          import('./import/modal').then(({default: Modal}) => {
            Routing.setRoutingData(routes);
            //On charge le contenu du formulaire
            $.get(Routing.generate('pcn')).then(function (data) {
              if (data.typeMessage) {
                const modal = new Modal(true)
                modal.setContent(data.view)
                //On informe l'utilisateur de ce qui se passe
                u.notif("Merci de personnalisez votre code d'accès <br>C'est important de garder son code secret.", 'info')
                //On affiche le formulaire
                modal.show(function () {
                  let modalBtnSaver = new Button('#change-password-saver')
                  //Le formulaire sera soumit par ajax
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
                            u.notif('Les codes doivent être les mêmes et comporter au moins 6 charatères.', 'info')
                            modalBtnSaver.reset()
                          } else
                          //On redirige l'utilisateur vers link si le mot de passe à été modifié avec succès
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
              } else {
                u.notif('Erreur de chargement. Veuillez vérifier votre connexion internet et réessayer', 'danger')
              }
            })
          })
        })
      })
    })
  }
})