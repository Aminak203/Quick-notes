const hamburger_menu = document.querySelector(".hamburger-menu");
const container = document.querySelector(".container");
function toggleColorMode() {
  const body = document.body;
  const isDarkMode = body.classList.toggle("dark-mode");
  localStorage.setItem("color-mode", isDarkMode ? "dark" : "light");
}

hamburger_menu.addEventListener("click", () => {
  container.classList.toggle("active");
});
