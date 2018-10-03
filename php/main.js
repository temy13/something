$(document).ready(function(){
  //alert("Hi")
  timeSet("auto")
});


function timeSet(p){
    $(".timing-set").hide()
    $(".timing-" + p).show()
}
