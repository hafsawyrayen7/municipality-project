var xx = 0;
slideX();

function slideX() {
  var i;
  var x = document.getElementsByClassName("x");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  xx++;
  if (xx > x.length) {xx = 1}
  x[xx-1].style.display = "block";
  setTimeout(slideX, 2000); // Change image every 2 seconds
}
