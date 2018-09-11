(function($) {

    circle = function(size, selector, bf, delay, cf){
      $(selector).velocity({
          width: size * 4,
          height: size * 4,
          marginRight: size * -2,
          marginTop: size * -2,
        },{
          begin: bf,
          delay: delay,
          complete: cf
        })
    }

    large = function(){
      w = window.parent.screen.width
      h = window.parent.screen.height
      size = w > h ? w : h
      circle(size, "#nav-bg", null, 0, null)
      circle(size, "#nav-bg-inner", function(){
        $("#nav-bg-inner").css("background-color", "#ffffff")
        $("#nav-bg-fix").css("background-color", "#efbc22")
      }, 400, function(){
        $("#nav-bg-fix").css("background-color", "transparent")
      })
    }

    small = function(n){
      n = n || 75
      circle(12, "#nav-bg-inner", null, 0, function(){
        $("#nav-bg-inner").css("background-color", "transparent")
      })
      circle(12, "#nav-bg", null, n, null)
    }

    boots = function(){
      //これ危ないかもだけど発動タイミング的にセーフなはず。
      if ($("#box").css("right") != "-100%"){
        $("#box").css("right", "-100%")
      }
      $('#nav-toggle').click(function(){
          console.log("click")
          $('body').toggleClass('open');
          if($('body').hasClass("open")){
            large()
          }else{
            small()
          }
      });
      if(location.pathname.startsWith("/index")){
        anime({
          targets: '#top-img',
          scale: {
                  value:[0,1],
                  duration: 1000,
                  easing: 'easeOutQuad'
              },
        });
      }
    }

    // Barba.Dispatcher.on('newPageReady', function () {
    //     $(document).ready(function () {
    //         console.log("ready")
    //
    //         if ($("#box").css("right") != "-100%"){
    //           $("#box").css("right", "-100%")
    //         }
    //     });
    //     $('#nav-toggle').click(function(){
    //         console.log("click")
    //         $('body').toggleClass('open');
    //         if($('body').hasClass("open")){
    //           large()
    //         }else{
    //           small()
    //         }
    //     });
    // });
    $(document).ready(function(){
      boots()
      // try {
      // 		$('.rip').ripples({
      // 			resolution: 512,
      // 			dropRadius: 20, //px
      // 			perturbance: 0.04,
      // 		});
      // 	}
      // 	catch (e) {
      // 		$('.error').show().text(e);
      // 	}

    });





})(jQuery);

// var loaded = false
//
//
// var Main= Barba.BaseView.extend({
//   namespace: 'main',
//   onEnter: function() {
//   },
//   onEnterCompleted: function() {
//       if (loaded){
//         return
//       }
//       loaded = true
//       console.log("ec")
//       if ($("#box").css("right") != "-100%"){
//         $("#box").css("right", "-100%")
//       }
//       // The Transition has just finished.
//
//   },
//   onLeave: function() {
//       // A new Transition toward a new page has just started.
//       console.log("l")
//       loaded = false
//   },
//   onLeaveCompleted: function() {
//       // The Container has just been removed from the DOM.
//       console.log("lc")
//       loaded = false
//   }
// });
// Main.init()
