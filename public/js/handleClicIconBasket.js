export default function handleClicIconBasket() {
  const basketIcon = document.querySelector(".iconBasket");
  const basketBody = document.querySelector("#basket");
  const basketHeader = document.querySelector(".basketHeader");
  const basketH1 = document.querySelector(".basketHeader h1");
  const basketItem = document.querySelectorAll(".basketItem");
  const counter = document.querySelector("#count");
  const price = document.querySelector("#price");
  const basketSubmit = document.querySelector(".basketSubmit");

  let basketOpen = false;

  basketHeader.addEventListener("click", () => {
    if (!basketOpen) {
      basketOpen = true;
      //Apply basketBody style
      basketIcon.src = "/images/iconbasket.png";
      basketBody.style.transition = "transform 1s";
      basketBody.style.transform = "translateX(-300px)";
      basketBody.style.backgroundColor = "rgba(0, 0, 0, 0.95)";
      basketBody.style.border = "1px solid #9E9E9E";
      basketBody.style.borderRight = "none";
      //Apply basket header style
      basketH1.style.visibility = "visible";
      basketHeader.style.borderBottom = "1px solid #186F37";
      //Display all items
      basketItem.forEach((item) => {
        item.style.visibility = "visible";
      });
      //Display counter / price / buttonn
      counter.style.visibility = "visible";
      price.style.visibility = "visible";
      basketSubmit.style.visibility = "visible";
    } else {
      basketOpen = false;
      setTimeout(() => {
        basketIcon.src = "/images/iconbasketwhite.png";
      }, 1000);
      basketBody.style.transition = "transform 1s, background-color 1s";
      basketBody.style.transform = "translateX(0px)";
      basketBody.style.backgroundColor = "transparent";
      basketBody.style.border = "none";
      //Apply basket header style
      basketH1.style.transition = "visibility 1s";
      basketH1.style.visibility = "hidden";
      basketHeader.style.borderBottom = "none";
      basketItem.forEach((item) => {
        item.style.transition = "visibility 1s";
        item.style.visibility = "hidden";
      });
      counter.style.transition = "visibility 1s";
      counter.style.visibility = "hidden";
      price.style.transition = "visibility 1s";
      price.style.visibility = "hidden";
      basketSubmit.style.transition = "visibility 1s";
      basketSubmit.style.visibility = "hidden";
    }
  });
}

// Appelle la fonction handleClicIconBasket une fois que le DOM est chargé
document.addEventListener("DOMContentLoaded", handleClicIconBasket);
