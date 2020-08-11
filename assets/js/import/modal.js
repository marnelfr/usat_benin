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

  function appendScript() {
    var head = document.head || document.getElementsByTagName('head')[0],
      $script;
    if (typeof jQuery === "undefined") {
      $script = document.createElement('script');
      $script.type = 'text/javascript';
      $script.onload = jQueryLoaded;
      $script.src = "//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js";
      head.appendChild($script);
    } else {
      jQueryLoaded();
    }
  }

  jQueryLoaded() {
    var head = document.head || document.getElementsByTagName('head')[0],
      linkTB = document.createElement('link'),
      scriptTB = document.createElement('script');

    if (typeof jQuery.fn.modal === "undefined") {
      linkTB.rel = "stylesheet";
      linkTB.type = "text/css";
      linkTB.href = "//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css";
      head.appendChild(linkTB);

      scriptTB.type = "text/javascript";
      scriptTB.onload = this.twitterBSLoaded;
      scriptTB.src = "//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/js/bootstrap.min.js";
      head.appendChild(scriptTB);
    } else {
      this.twitterBSLoaded();
    }
  }

  twitterBSLoaded() {
    jQuery(document.body).append('<div id="myModal"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"   aria-hidden="true"><div class="modal-header"><button type="button" class="close"  data-dismiss="modal" aria-hidden="true">×</button><h3 id="myModalLabel">Modal header</h3></div><div class="modal-body"><p>One fine body…</p></div><div  class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Close</button><button class="btn btn-primary">Save changes</button></div></div>');
    jQuery('#myModal').modal('show');
  }

}