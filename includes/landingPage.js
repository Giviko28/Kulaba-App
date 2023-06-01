
/*
let index = 1;
showSlides(index);
function nextIndex(n) {
    showSlides(index+=n);
}
function showSlides(n) {
    let slides = document.getElementsByClassName("mySlide");
    if (n>slides.length()) {index = 1};
    if(n<1) {index=slides.length()};

    for(let i = 0; i<slides.length();i++){
        slides[i].style.display = "none";
    }
    slides[n-1].style.display = "block";
}
*/
let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slides[slideIndex-1].style.display = "block";
}