let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  slideIndex += n;
  showSlides(slideIndex);
}

function showSlides(n) {
  let slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slides[slideIndex-1].style.display = "block";
}

let cards = document.getElementsByClassName("card");

// მასივად ვაქცევთ getElementsByClassName-იდან მიღებულ ინფორმაციას
let cardsArray = [...cards];

cardsArray.forEach(function(card) {
  card.addEventListener("click", function(event) {
    event.preventDefault();

    // Find the closest form element to the clicked card
    let form = this.closest('form');
    
    if (form) {
      form.submit(); // Submit the form
    }
  });
});