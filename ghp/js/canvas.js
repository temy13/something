var zeroPadding = function(num,length){
    return ('0000000000' + num).slice(-length);
}

var fillArray = function(value, len) {
  var arr = [];
  for (var i = 0; i < len; i++) {
    arr.push(value + zeroPadding(i, 3) + ".gif");
  }
  return arr;
}


var urls = fillArray("images/gifs/separate-", 144)


var w = 768, h = 768,
    canvas, ctx, encoder, image;

var addFrame = function(i, callback) {
  this.img = new Image();
  this.img.src = urls[i];
  // Wait for image to be loaded
  img.onload = function() {
    // Clear canvas by painting white
    // ctx.fillStyle = 'transparent';
    // ctx.fillRect(0, 0, w, h);
    // Copy image element onto canvas
    ctx.drawImage(this, 0, 0, w, h);

    // Add animation frame
    encoder.addFrame(ctx);

    // Call next iteration only if there's more images left
    if (urls[++i]) {
      // Time wait only for demo purpose
      setTimeout(function() {
        callback(i, callback);
      }, 500);
    } else {
      encoder.finish();
    }
  };
};


window.onload = function() {
  canvas = document.getElementById('canvas');
  ctx = canvas.getContext('2d');
  encoder = new GIFEncoder();
  encoder.setRepeat(0);
  encoder.setDelay(0);
  encoder.setSize(w, h);
  canvas.width = w;
  canvas.height = h;
  ctx.fillStyle = "rgb(255,255,255)";
  ctx.fillRect(0,0,canvas.width, canvas.height); //GIF can't do transparent so do white

  encoder.start();
  addFrame(0, addFrame);
}

// var canvas = document.getElementById('bitmap');
// var context = canvas.getContext('2d');
//
// var encoder = new GIFEncoder();
// encoder.setRepeat(0); //auto-loop
// encoder.setDelay(0);
// canvas.width = 150;
// canvas.height = 150;
// encoder.setSize(150,150);
//
// console.log(encoder.start());

/*
var now = new Date();
for(var i = 0; i < 10; i++){
  now.setSeconds(now.getSeconds() + 10)
  clock(now);
}
encoder.finish();
document.getElementById('image').src = 'data:image/gif;base64,'+encode64(encoder.stream().getData())

//based on: https://developer.mozilla.org/en/Canvas_tutorial/Basic_animations#An_animation_example_2
function clock(now){
  var ctx = context;
  ctx.save();
  context.fillStyle = "rgb(255,255,255)";
  context.fillRect(0,0,150, 150); //GIF can't do transparent so do white

  ctx.translate(75,75);
  ctx.scale(0.4,0.4);
  ctx.rotate(-Math.PI/2);
  ctx.strokeStyle = "black";
  ctx.fillStyle = "white";
  ctx.lineWidth = 8;
  ctx.lineCap = "round";

  // Hour marks
  ctx.save();
  for (var i=0;i<12;i++){
    ctx.beginPath();
    ctx.rotate(Math.PI/6);
    ctx.moveTo(100,0);
    ctx.lineTo(120,0);
    ctx.stroke();
  }
  ctx.restore();

  // Minute marks
  ctx.save();
  ctx.lineWidth = 5;
  for (i=0;i<60;i++){
    if (i%5!=0) {
      ctx.beginPath();
      ctx.moveTo(117,0);
      ctx.lineTo(120,0);
      ctx.stroke();
    }
    ctx.rotate(Math.PI/30);
  }
  ctx.restore();

  var sec = now.getSeconds();
  var min = now.getMinutes();
  var hr  = now.getHours();
  hr = hr>=12 ? hr-12 : hr;

  ctx.fillStyle = "black";

  // write Hours
  ctx.save();
  ctx.rotate( hr*(Math.PI/6) + (Math.PI/360)*min + (Math.PI/21600)*sec )
  ctx.lineWidth = 14;
  ctx.beginPath();
  ctx.moveTo(-20,0);
  ctx.lineTo(80,0);
  ctx.stroke();
  ctx.restore();

  // write Minutes
  ctx.save();
  ctx.rotate( (Math.PI/30)*min + (Math.PI/1800)*sec )
  ctx.lineWidth = 10;
  ctx.beginPath();
  ctx.moveTo(-28,0);
  ctx.lineTo(112,0);
  ctx.stroke();
  ctx.restore();

  // Write seconds
  ctx.save();
  ctx.rotate(sec * Math.PI/30);
  ctx.strokeStyle = "#D40000";
  ctx.fillStyle = "#D40000";
  ctx.lineWidth = 6;
  ctx.beginPath();
  ctx.moveTo(-30,0);
  ctx.lineTo(83,0);
  ctx.stroke();
  ctx.beginPath();
  ctx.arc(0,0,10,0,Math.PI*2,true);
  ctx.fill();
  ctx.beginPath();
  ctx.arc(95,0,10,0,Math.PI*2,true);
  ctx.stroke();
  ctx.fillStyle = "#555";
  ctx.arc(0,0,3,0,Math.PI*2,true);
  ctx.fill();
  ctx.restore();

  ctx.beginPath();
  ctx.lineWidth = 14;
  ctx.strokeStyle = '#325FA2';
  ctx.arc(0,0,142,0,Math.PI*2,true);
  ctx.stroke();

  ctx.restore();

  encoder.addFrame(ctx);
}*/
