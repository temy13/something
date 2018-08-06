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
        $("#box").velocity(
            {
              right:0
            }, {
    		      duration: 1000,
    		      easing: "easeInCubic",
    		      complete : function() {
    		         deferred.resolve();
                 // console.log("out")
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