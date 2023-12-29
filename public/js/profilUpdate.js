export default function profilUpdate() {
  const profilForm = document.querySelector("#updateProfil");
  const profil = document.querySelector("#profil");
  const updateButton = document.querySelector(".update");
  const cancelButton = document.querySelector(".cancelButton");

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
