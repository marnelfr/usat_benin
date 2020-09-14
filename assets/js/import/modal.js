export default class Modal {

  constructor(noKeyBoradAction = false, size = 'medium') {
    let typeModal
    const strict = noKeyBoradAction ? 'data-backdrop="static" data-keyboard="false"' : ''
    this.modal = $(`<div class="modal modal-info fade" ${strict}></div>`)

    switch (size) {
      case 'large':
        typeModal = 'modal-lg'
        break
      case 'ultra-large':
        typeModal = 'modal-xl'
        break
      default:
        typeModal = ''
    }
    this.modal.html(`<div class="modal-dialog ${typeModal}"></div>`);
  }

  /*
  <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Large Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
   */

  /**
   *
   * @param view
   * @param callable
   */
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