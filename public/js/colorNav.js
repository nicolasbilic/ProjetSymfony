export default function colorNav() {
  const navList = document.querySelectorAll(".headerList li a");
  const path = window.location.pathname;
  if (path === "/" || path === "/accueil") {
    navList.forEach((link) => {
      if (link.textContent.toLowerCase() === "accueil") {
        // Votre logique ici pour le lien correspondant
        link.style.color = "#186F37";
      }
    });
  } else if (path === "/list-products") {
    const query = window.location.search;
    navList.forEach((link) => {
      if (
        "?category=" + link.textContent.toLowerCase() ===
        decodeURIComponent(query)
      ) {
        link.style.color = "#186F37";
      }
    });
  } else if (path === "/contact") {
    navList.forEach((link) => {
      if ("/" + link.textContent.toLowerCase() === path) {
        // Votre logique ici pour le lien correspondant
        link.style.color = "#186F37";
      }
    });
  } else if (path === "/register") {
    navList.forEach((link) => {
      if ("/" + link.textContent.toLowerCase() === "/inscription") {
        link.style.color = "#186F37";
      }
    });
  } else if (path === "/login") {
    navList.forEach((link) => {
      if ("/" + link.textContent.toLowerCase() === "/connexion") {
        link.style.color = "#186F37";
      }
    });
  } else if (path === "/products") {
    const li = document
      .querySelector(".track-list")
      .children[2].querySelector("a");
    navList.forEach((link) => {
      if (link.textContent.toLowerCase() === li.textContent) {
        link.style.color = "#186F37";
      }
    });
  } else if (path === "/updateProfil" || path === "/customer/orders/list") {
    navList.forEach((link) => {
      if (link.textContent.toLowerCase() === "profil") {
        // Votre logique ici pour le lien correspondant
        link.style.color = "#186F37";
      }
    });
  }
}

colorNav();
