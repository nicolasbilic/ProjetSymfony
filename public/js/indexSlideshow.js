export default function indexSlideshow() {
  const container = document.querySelector(".slideshowContainer");
  const slides = document.querySelectorAll(".slideshowContainer img");
  const contentHeight = slides[0].offsetHeight;
  container.style.height = `${contentHeight}px`; //Use to set the slideshow header
  const slideCount = slides.length;
  let currentIndex = 0; //var to folloow the current slide
  slides[currentIndex].style.opacity = 1;
  //Infinit repeat
  setInterval(() => {
    slides[currentIndex].style.opacity = 0;
    currentIndex = (currentIndex + 1) % slideCount; //currentIndex++
    slides[currentIndex].style.opacity = 1;
  }, 4000); //Repeat each 4s
}

indexSlideshow();
