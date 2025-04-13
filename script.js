const logo=document.getElementById('user-logo');
const side_bar=document.getElementById('side-bar');
const main=document.getElementsByTagName('main');
const body=document.querySelector('body');

function showNav(){
    side_bar.style.left=0;
    body.style.backgroundColor="rgba(0, 0, 0, 0.218)";
}
function hideNav(){
    side_bar.style.left='-100%';
    body.style.backgroundColor="white";

}


// make a slider

let currentSlide = 0;
    const move = document.querySelectorAll(".move");

    function showSlide(index) {
      const slidesContainer = document.querySelector(".img-slider");
      if (index >= move.length) currentSlide = 0;
      else if (index < 0) currentSlide = move.length - 1;
      else currentSlide = index;

      slidesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    function nextSlide() {
      showSlide(currentSlide + 1);
    }

    function prevSlide() {
      showSlide(currentSlide - 1);
    }             

    showSlide(currentSlide);