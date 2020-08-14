export default class Modal {

  constructor() {
    this.modal = $('<div class="modal modal-info fade"></div>')
    this.modal.html('<div class="modal-dialog"></div>');
  }

  setContent(view, callable) {
    this.modal.find('.modal-dialog').html(view)
    $(document).find('body').append(this.modal)
  }

  show(callable) {
    this.modal.modal('show')
    this.modal.on('shown.bs.modal', callable)
  }

  hide() {
    this.modal.modal('hide')
  }

}