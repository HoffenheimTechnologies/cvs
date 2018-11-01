function counter(date){
  var countDownDate = new Date(date).getTime();
  // Update the count down every 1 second
  var x = setInterval(function() {
    // Get todays date and time
    var now = new Date().getTime();
    // Find the distance between now and the count down date
    var distance = countDownDate - now;
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    // Output the result"
    jQuery('#countdown #day').html(("0" + days).slice(-2));
    jQuery('#countdown #hour').html(("0" + hours).slice(-2));
    jQuery('#countdown #min').html(("0" + minutes).slice(-2));
    jQuery('#countdown #sec').html(("0" + seconds).slice(-2));
    // If the count down is over, hide the event
    if (distance < 0) {
      clearInterval(x);
      $('#question').hide();
    }
  }, 1000);
}
