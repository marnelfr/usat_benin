export default class Button {

  constructor(btn_selector) {
    this.btn = $(btn_selector);
    this.i = this.btn.find('i')
    this.icon = this.i.attr('class')
  }

  click(callable) {
    this.loading()
    this.btn.click(callable)
  }

  loadOnClick() {
    let btn = this.btn
    btn.click(function () {
      btn.loading()
    })
  }

  loading() {
    this.i.attr('class', 'spinner-grow spinner-grow-sm')
    this.btn.attr('disabled', true)
  }

  reset() {
    this.btn.removeAttr('disabled')
    this.i.attr('class', this.icon)
  }


}