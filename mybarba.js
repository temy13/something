Barba.Pjax.init();
Barba.Prefetch.init();
//http://barbajs.org/demo/nextprev/3.html

var PageTransition = Barba.BaseTransition.extend({
    start: function() {
      var _this = this;

      // トランジション開始と同時にnewContainerLoadingメソッドも呼ばれ、
      // トランジション用のメソッドとどちらもresolve()であればthen()が呼ばれる。
      Promise
          .all([this.newContainerLoading, this.loadOut()])
          .then(this.loadIn.bind(this));
    },
    loadOut: function(resolve) {

        var deferred = Barba.Utils.deferred();
        // $("#box").velocity(
        //     {
        //       right:-100
        //     }, {
    		//       duration: 1000,
    		//       easing: "easeInCubic",
    		//       complete : function() {
    		//          deferred.resolve();
    		//     }
        // });
        anime({
            targets: "#box",
            right: 0,
            easing: 'easeInCubic',
            duration: 1000,
            begin: function(){
              $('body').addClass('normal');
            },
            complete: function(){
              deferred.resolve();
            }
        });
        return deferred.promise;
    },
    loadIn: function() {
        var _this = this;

        anime({
            //targets: this.newContainer,
            targets: "#box",
            //translateX: "-100%",
            right: "100%",
            easing: 'linear',
            duration: 500,
            begin: function(){
              $('body').removeClass('open');
              $('body').addClass('normal');
            },
            complete: function(){
              boots()
            }
        });
        $(this.oldContainer).hide();
        _this.done();
    },
});

Barba.Pjax.getTransition = function() {
    return PageTransition;
};

Barba.Pjax.start();
