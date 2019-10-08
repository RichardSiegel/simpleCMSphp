function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

(function(){

  var parallax = document.querySelectorAll(".parallax"),
      speed = 0.5;

  window.onscroll = function(){
    if (!isMobile())
    {
        [].slice.call(parallax).forEach(function(el,i){

          var windowYOffset = window.pageYOffset;
              elBackgrounPos = "0px " + (windowYOffset * speed) + "px";
          
          el.style.backgroundPosition = elBackgrounPos;

        });
    }
  };

})();
