export default function carouselBestSale() {
  const previous = document.querySelector(".previousArrow");
  const next = document.querySelector(".nextArrow");
  const gallery = document.querySelector(".carouselGallery"); // Assurez-vous d'avoir un conteneur pour votre galerie
  const galleryItems = document.querySelectorAll(".cardContainerBestSale");
  const itemWidth = galleryItems[0].offsetWidth;
  let translateValue = 0; // Initialisez la valeur à 0 pour commencer
  let movementCount = 0; // Initialisez le compteur de mouvements

  previous.addEventListener("click", () => {
    if (movementCount > 0) {
      translateValue += itemWidth + 160;
      movementCount--;
      updateGalleryTransform();
    }
  });

  next.addEventListener("click", () => {
    if (movementCount < galleryItems.length - 3) {
      translateValue -= itemWidth + 160;
      movementCount++;
      updateGalleryTransform();
    }
  });

  function updateGalleryTransform() {
    galleryItems.forEach((item) => {
      item.style.transition = "transform 1s";

      item.style.transform = `translateX(${translateValue}px)`;
    });
  }
}

carouselBestSale();
