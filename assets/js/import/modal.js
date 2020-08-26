export default class Modal {

  constructor(noKeyBoradAction = false) {
    const strict = noKeyBoradAction ? 'data-backdrop="static" data-keyboard="false"' : ''
    this.modal = $(`<div class="modal modal-info fade" ${strict}></div>`)
    this.modal.html('<div class="modal-dialog"></div>');
  }

  setContent(view, callable) {
    this.modal.find('.modal-dialog').html(view)
    $(document).find('body').append(this.modal)
  }

  show(callable) {
    let $this = this
    $this.modal.modal('show')
    $this.modal.on('shown.bs.modal', callable)
    $this.modal.on('hidden.bs.modal', function () {
      $this.modal.remove()
    })
  }

  hide() {
    this.modal.modal('hide')
  }

}