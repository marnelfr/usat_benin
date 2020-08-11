export default class Button {

  constructor(btn_selector) {
    this.btn = $(btn_selector);
    this.i = this.btn.find('i')
    this.icon = this.i.attr('class')
  }

  click(callable) {
    this.btn.click(callable)
  }

  loading() {
    this.i.attr('class', 'fas fa-spin fa-spinner')
    this.btn.attr('disabled', true)
  }

  reset() {
    this.btn.removeAttr('disabled')
    this.i.attr('class', this.icon)
  }


}