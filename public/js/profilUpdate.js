export default function profilUpdate() {
  const profilForm = document.querySelector("#updateProfil");
  const profil = document.querySelector("#profil");
  const updateButton = document.querySelector(".update");
  const cancelButton = document.querySelector(".cancelButton");
  const errorMessage = document.querySelector(
    "#updateProfil .sectionContainer ul"
  );
  const profilSectionContainer = document.querySelector(
    "#profil .sectionContainer"
  );

  if (errorMessage && profilSectionContainer) {
    profilSectionContainer.insertBefore(
      errorMessage,
      profilSectionContainer.firstChild
    );
    errorMessage.style.color = "red";
    errorMessage.style.listStyle = "none";
    errorMessage.style.paddingLeft = "0";
  }
  updateButton.addEventListener("click", () => {
    profilForm.style.display = "flex";
    profil.style.display = "none";
  });
  cancelButton.addEventListener("click", () => {
    profilForm.style.display = "none";
    profil.style.display = "flex";
  });
}

profilUpdate();
