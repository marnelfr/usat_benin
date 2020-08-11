export default class Modal {

  constructor() {
    // this.modal = $('<div class="modal modal-info fade" id="nedllement"></div>')
    // this.modal.html('<div class="modal-dialog"></div>');
  }

  setContent(view, callable) {
    this.modal.find('.modal-dialog').html(view)
    $(document).find('body').append(this.modal)
    console.log(this.modal.html())
  }

  show() {
    this.modal.modal('show')
  }

  hide() {
    this.modal.modal('hide')
  }

}