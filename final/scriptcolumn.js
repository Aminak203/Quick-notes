const container = document.querySelector(".container");
const linkItems = document.querySelectorAll(".link-item");

container.addEventListener("mouseenter", () => {
  container.classList.add("active");
});

//Container Hover Leave
container.addEventListener("mouseleave", () => {
  container.classList.remove("active");
});

//Link-items Clicked
for (let i = 0; i < linkItems.length; i++) {
  if (!linkItems[i].classList.contains("dark-mode")) {
    linkItems[i].addEventListener("click", (e) => {
      linkItems.forEach((linkItem) => {
        linkItem.classList.remove("active");
      });
      linkItems[i].classList.add("active");
    });
  }
}
const darkModeToggle = document.querySelector('#dark-mode');

function saveDarkModePreference() {
  var darkMode = document.body.classList.contains("dark-mode");
  localStorage.setItem("darkMode", darkMode);
  console.log('Dark mode preference saved:', darkMode);
}

function getDarkModePreference() {
  var darkMode = localStorage.getItem("darkMode");

  if (darkMode === null) {
    darkMode = false;
  } else {
    darkMode = JSON.parse(darkMode);
  }

  console.log('Dark mode preference retrieved:', darkMode);
  return darkMode;
}

function toggleDarkMode() {
  document.body.classList.toggle("dark-mode");
  console.log('Toggling dark mode:', document.body.classList.contains("dark-mode")); // Add this line
  saveDarkModePreference();
  updateIcon();
}


function updateIcon() {
  const darkModeEnabled = getDarkModePreference();
  const icon = darkModeToggle.querySelector('ion-icon');
  if (darkModeEnabled) {
    icon.setAttribute('name', 'moon');
  } else {
    icon.setAttribute('name', 'moon-outline');
  }
}

window.onload = function() {
  if (getDarkModePreference()) {
    document.body.classList.add("dark-mode");
  }
  updateIcon();
  darkModeToggle.addEventListener("click", toggleDarkMode);

  setActiveLinkItem();
};
