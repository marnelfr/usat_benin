import '../../css/guest/home.scss';
$(document).ready(function() {
  // Carousel configuration
  $('#proceduresCarousel').carousel({
    interval: 6000,
    pause: 'hover'
  });

  // Active smooth scrolling
  $('a.nav-link, a.btn').on('click', function(event) {
    if (this.hash !== "" && $(this).attr('data-toggle') !== 'modal') {
      event.preventDefault();
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top - 70
      }, 800);
    }
  });
  // Configuration du Carousel Principal
  $('#mainHeroCarousel').carousel({
    interval: 5000,
    pause: false,
    ride: 'carousel'
  });

  // Configuration du Carousel Procédures
  $('#proceduresCarousel').carousel({
    interval: 7000,
    pause: 'hover'
  });

  // Smooth scrolling global
  $('a.nav-link, a.btn').on('click', function(event) {
    if (this.hash !== "" && $(this).attr('data-toggle') !== 'modal') {
      event.preventDefault();
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top - 70
      }, 800);
    }
  });

  if ($('#error-auth-modal').length) {
    $("#authModal").modal('show');
  }
});