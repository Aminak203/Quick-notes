<!-- Begin Left Column -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="stylecolumn.css" href="style2.css" />
    <title>QUICK NOTES</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <div class="container">
      <ul class="link-items">
        <li class="link-item top">
          <a href="#" class="link">
            <img src="https://www.35mmc.com/wp-content/uploads/2021/10/00-logo.png" alt="" />
            <span style="--i: 9">
              <h4>Quick-Notes</h4>
            </span>
          </a>
          <li class="link-item ">
        <a href="main.php" class="link">
            <ion-icon name="home-outline"></ion-icon>
            <span style="--i: 1">Notes</span>
          </a>
        </li>
          <li class="link-item ">
    <a href="search.php" class="link">
        <ion-icon name="search-outline"></ion-icon>
        <span style="--i: 4">Search</span>
    </a>
</li>
<li class="link-item">
    <a href="all_notes.php" class="link">
        <ion-icon name="document-text-outline"></ion-icon>
        <span style="--i: 3">Note Space</span>
    </a>
</li>
<li class="link-item">
  <a href="ocean.php" class="link">
    <ion-icon name="chatbubbles-outline"></ion-icon>
    <span style="--i: 6">Bot Chat</span>
  </a>
</li>
<li class="link-item">
  <a href="accounts.php" class="link">
    <ion-icon name="settings-outline"></ion-icon>
    <span style="--i: 6">Account Settings</span>
  </a>
</li>
          <li class="link-item">
  <a href="logout.php" class="link">
    <ion-icon name="log-out-outline"></ion-icon>
    <span style="--i: 6">Logout</span>
  </a>
</li>


        <li class="link-item dark-mode ">
          <a href="#" class="link">
            <ion-icon name="moon-outline"></ion-icon>
            <span style="--i: 8">dark mode</span>
          </a>
        </li>

      </ul>
    </div>
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
    ></script>
    <script src="scriptcolumn.js"></script>
    <script>
  function setActiveLinkItem() {
    var href = window.location.href;
    var linkItems = document.querySelectorAll('.link-item');
    for (var i = 0; i < linkItems.length; i++) {
      var link = linkItems[i].querySelector('a');
      if (href.includes(link.getAttribute('href'))) {
        linkItems[i].classList.add('active');
        break;
      }
    }
  }
  
  function toggleDarkMode() {
  var body = document.querySelector('body');
  body.classList.toggle('dark-mode');
  var isDarkMode = body.classList.contains('dark-mode');
  localStorage.setItem('isDarkMode', isDarkMode);
 }
  
  function checkDarkMode() {
    var isDarkMode = localStorage.getItem('isDarkMode');
     if (isDarkMode === 'true') {
       var body = document.querySelector('body');
       body.classList.add('dark-mode');
     }
   }
   document.querySelector('.dark-mode a').addEventListener('click', toggleDarkMode);
  setActiveLinkItem();
   checkDarkMode();
</script>
  </body>
</html>
<!-- End Left Column -->