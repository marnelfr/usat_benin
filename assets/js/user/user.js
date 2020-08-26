import Button from '../import/button'

$(function () {
  let btn = new Button('.btn-user-saver')
  btn.loadOnClick(true)

  let lockers = document.querySelectorAll('.btn-lock-user')
  lockers.forEach(function (btn) {
    const locker = new Button(btn)
    locker.click(function () {
      if (confirm('Voulez-vous vraiment changer le status de cet utilisateur ?')) {
        locker.getForm().submit()
      }
    })
  })

  // TODO: remove() le champs du password sur le formulaire d'édition de la personne
})