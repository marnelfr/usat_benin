export default class Utility {

  static notif(message, type) {
    if(!type) type = 'success'
    let element = $('#alert-raw')
    element.fadeOut(1)
    element.removeClass('alert-danger')
    element.removeClass('alert-success')
    element.removeClass('alert-warning')
    element.addClass('alert-' + type)
    element.find('p').text(message)
    element.fadeIn(500)
    setTimeout(function () {
      element.fadeOut(2000)
    }, 10000)
  }

}