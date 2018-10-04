$(document).ready(function(){
  $(".timing-set").hide()
  if($("input:checked").attr("id") == "timing-type-btn-auto"){
    timeSet("auto")
  }else if($("input:checked").attr("id") == "timing-type-btn-manual"){
    timeSet("manual")
  }
});


function timeSet(p){
  console.log($("input:checked").attr("id"))
  $(".timing-set").hide()
  $(".timing-" + p).show()
}
