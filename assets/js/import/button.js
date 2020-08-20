export default class Button {

  constructor(btn_selector) {
    this.btn = $(btn_selector);
    this.i = this.btn.find('i')
    this.icon = this.i.attr('class')
  }

  click(callable) {
    let $this = this
    this.btn.each(function () {
      const b = $(this)
      b.off('click').click(function (e) {
          e.preventDefault()

          // b.loading()
          callable()
        })
    })
  }

  text() {
    return this.btn.text()
  }

  data($lib) {
    return this.btn.attr('data-'+$lib)
  }

  id() {
    return this.btn.attr('id')
  }

  getForm() {
    return this.btn.closest('form')
  }

  loadOnClick(submit_form) {
    let $this = this
    $this.btn.on('click', function () {
      $this.loading()
      if (submit_form) {
        $this.btn.closest('form').submit()
      }
    })
  }

  loading() {
    this.i.attr('class', 'spinner-border spinner-border-sm')
    this.btn.attr('disabled', true)
  }

  reset() {
    this.btn.removeAttr('disabled')
    this.i.attr('class', this.icon)
  }


}