<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

body,
button {
  font-family: "Poppins", sans-serif;
}

.container {
  min-height: 100vh;
  width: 100%;
  background: radial-gradient(
    circle at 10% 20%,
    rgb(87, 108, 117) 0%,
    rgb(37, 50, 55) 100.2%
  );

  overflow-x: hidden;
  transform-style: preserve-3d;
}

.navbar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 10;
  height: 3rem;
}

.menu {
  max-width: 72rem;
  width: 100%;
  margin: 0 auto;
  padding: 0 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #fff;
}

.logo {
  font-size: 1.1rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  line-height: 4rem;
}

.logo span {
  font-weight: 300;
}

.hamburger-menu {
  height: 4rem;
  width: 3rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}

.bar {
  width: 1.9rem;
  height: 1.5px;
  border-radius: 2px;
  background-color: #eee;
  transition: 0.5s;
  position: relative;
}

.bar:before,
.bar:after {
  content: "";
  position: absolute;
  width: inherit;
  height: inherit;
  background-color: #eee;
  transition: 0.5s;
}

.bar:before {
  transform: translateY(-9px);
}

.bar:after {
  transform: translateY(9px);
}

.main {
  position: relative;
  width: 100%;
  left: 0;
  z-index: 5;
  overflow: hidden;
  transform-origin: left;
  transform-style: preserve-3d;
  transition: 0.5s;
}

header {
  header {
  width: 300px;
  height: 300px;
  background-image: url(https://clickup.com/blog/wp-content/uploads/2020/01/note-taking.png);
  border: 6px solid #333;
  margin: 20px;
}
.my-element {
  
}


}

.overlay {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background-color: rgba(36, 40, 43, 0.803);
  display: flex;
  justify-content: center;
  align-items: center;
}

.inner {
  max-width: 35rem;
  text-align: center;
  color: #fff;
  padding: 0 2rem;
}

.title {
  font-size: 3.3rem;
}

.btn {
  margin-top: 1.4rem;
  padding: 0.6rem 1.8rem;
  background-color: #1179e7;
  border: none;
  border-radius: 25px;
  color: #fff;
  text-transform: uppercase;
  cursor: pointer;
  text-decoration: none;
}

.container.active .bar {
  transform: rotate(360deg);
  background-color: transparent;
}

.container.active .bar:before {
  transform: translateY(0) rotate(45deg);
}

.container.active .bar:after {
  transform: translateY(0) rotate(-45deg);
}

.container.active .main {
  animation: main-animation 0.5s ease;
  cursor: pointer;
  transform: perspective(1300px) rotateY(20deg) translateZ(310px) scale(0.5);
}

@keyframes main-animation {
  from {
    transform: translate(0);
  }

  to {
    transform: perspective(1300px) rotateY(20deg) translateZ(310px) scale(0.5);
  }
}

.links {
  position: absolute;
  width: 30%;
  right: 0;
  top: 0;
  height: 100vh;
  z-index: 2;
  display: flex;
  justify-content: center;
  align-items: center;
}

ul {
  list-style: none;
}

.links a {
  text-decoration: none;
  color: #eee;
  padding: 0.7rem 0;
  display: inline-block;
  font-size: 1rem;
  font-weight: 300;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: 0.3s;
  opacity: 0;
  transform: translateY(10px);
  position: relative;
  animation: hide 0.5s forwards ease;
}

.links a:hover {
  color: #fff;
}

.links a::before {
  content: "";
  position: absolute;
  display: block;
  width: 100%;
  height: 2px;
  bottom: 9px;
  left: 0;
  background-color: rgb(255, 255, 255);
  transform: scaleX(0);
  transform-origin: top left;
  transition: transform 0.3s ease;
}

.links a:hover::before {
  transform: scaleX(1);
}

.container.active .links a {
  animation: appear 0.5s forwards ease var(--i);
}

@keyframes appear {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0px);
  }
}

@keyframes hide {
  from {
    opacity: 1;
    transform: translateY(0px);
  }
  to {
    opacity: 0;
    transform: translateY(10px);
  }
}

.shadow {
  position: absolute;
  width: 100%;
  height: 100vh;
  top: 0;
  left: 0;
  transform-style: preserve-3d;
  transform-origin: left;
  transition: 0.5s;
  background-color: white;
}

.shadow.one {
  z-index: -1;
  opacity: 0.15;
}

.shadow.two {
  z-index: -2;
  opacity: 0.1;
}

.container.active .shadow.one {
  animation: shadow-one 0.6s ease-out;
  transform: perspective(1300px) rotateY(20deg) translateZ(215px) scale(0.5);
}

@keyframes shadow-one {
  0% {
    transform: translate(0);
  }

  5% {
    transform: perspective(1300px) rotateY(20deg) translateZ(310px) scale(0.5);
  }

  100% {
    transform: perspective(1300px) rotateY(20deg) translateZ(215px) scale(0.5);
  }
}

.container.active .shadow.two {
  animation: shadow-two 0.6s ease-out;
  transform: perspective(1300px) rotateY(20deg) translateZ(120px) scale(0.5);
}

@keyframes shadow-two {
  0% {
    transform: translate(0);
  }

  20% {
    transform: perspective(1300px) rotateY(20deg) translateZ(310px) scale(0.5);
  }

  100% {
    transform: perspective(1300px) rotateY(20deg) translateZ(120px) scale(0.5);
  }
}

.container.active .main:hover + .shadow.one {
  transform: perspective(1300px) rotateY(20deg) translateZ(230px) scale(0.5);
}

.container.active .main:hover {
  transform: perspective(1300px) rotateY(20deg) translateZ(340px) scale(0.5);
}
</style>


<!DOCTYPE html>
<html lang="en">
  
  <head>
  <meta property="og:title" content="QuickNotes - The Simple Way to Take Notes">
<meta property="og:description" content="QuickNotes is a sleek and efficient web-based note-taking application that helps you capture and organize your thoughts with ease.">
<meta property="og:image" content="https://selene.hud.ac.uk/quicknotes/final/images/logo-black.png">
<meta property="og:url" content="https://selene.hud.ac.uk/quicknotes/final/">

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quick-Notes</title>
    <link rel="stylesheet" href="HomePage.css" />
  </head>
  <body>
    <div class="container">
      <div class="navbar">
        <div class="menu">
          <h3 class="logo">The<span>Debuggers</span></h3>
          <div class="hamburger-menu">
            <div class="bar"></div>
          </div>
        </div>
      </div>

      <div class="main-container">
        <div class="main">
          <header>
            <div class="overlay">
              <div class="inner">
                <h2 class="title">Quick-Notes</h2>


                <!-- <p>
                A digital notepad for capturing every thought and idea, without the worry of losing track. Organize your musings in one place and never forget a genius thought again!
                </p> -->

                <style>
    /* .art-lg-text {
    font-size: 22px;
    font-weight: bold;
    line-height: 1.5;
  }
  
  .art-code {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    font-family: monospace;
  }
  
  .mb-25 {
    margin-bottom: 25px;
  } */
  .txt-rotate {
    display: inline-block;
    position: relative;
    font-size: 1em;
    font-weight: normal;
  }
  .txt-rotate > .wrap {
    border-right: 0.08em solid #666;
    padding-right: 0.5em;
    animation: typing 0.5s steps(30, end),
               blink-caret 0.4s step-end infinite;
}
  
  @keyframes typing {
    from { width: 0 }
    to { width: 100% }
  }
  
  @keyframes blink-caret {
    from, to { border-color: transparent }
    50% { border-color: #666; }
  }
    
</style>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous"></script>
    </head>
    <body>
    <div class="main-container">
    <div ><span class="txt-rotate" data-period="2000"
     data-rotate='[ "A digital notepad for capturing every thought and idea, without the worry of losing track. Organize your musings in one place and never forget a genius thought again!", "Quick Notes." ]'></span></div>
               </body>
               <script>
                var TxtRotate = function(el, toRotate, period) {
  this.toRotate = toRotate;
  this.el = el;
  this.loopNum = 0;
  this.period = parseInt(period, 10000) || 6000;
  this.txt = '';
  this.tick();
  this.isDeleting = false;
};

TxtRotate.prototype.tick = function() {
  var i = this.loopNum % this.toRotate.length;
  var fullTxt = this.toRotate[i];

  if (this.isDeleting) {
    this.txt = fullTxt.substring(0, this.txt.length - 1);
  } else {
    this.txt = fullTxt.substring(0, this.txt.length + 1);
  }

  this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

  var that = this;
  var delta = 300 - Math.random() * 100;

  if (this.isDeleting) { delta /= 2; }

  if (!this.isDeleting && this.txt === fullTxt) {
    delta = this.period;
    this.isDeleting = true;
  } else if (this.isDeleting && this.txt === '') {
    this.isDeleting = false;
    this.loopNum++;
    delta = 500;
  }

  setTimeout(function() {
    that.tick();
  }, delta);
};

window.onload = function() {
  var elements = document.getElementsByClassName('txt-rotate');
  for (var i=0; i<elements.length; i++) {
    var toRotate = elements[i].getAttribute('data-rotate');
    var period = elements[i].getAttribute('data-period');
    if (toRotate) {
      new TxtRotate(elements[i], JSON.parse(toRotate), period);
    }
  }
  // INJECT CSS
  var css = document.createElement("style");
  css.type = "text/css";
  css.innerHTML = ".txt-rotate > .wrap { border-right: 0.08em solid #666 }";
  document.body.appendChild(css);
};

                </script>

                <button class="btn">
                <a href="details.html" style="color: white; text-decoration: none;" > Lets Start </a></button>
                </p>
                <!-- <a href="login1.php" > </a>
                <button class="btn"> <a href="signup.php" style="color: white; text-decoration: none;" > Signup</a></button> -->
              </div>
            </div>
          </header>
        </div>

        <div class="shadow one"></div>
        <div class="shadow two"></div>
      </div>

      <div class="links">
        <ul>
          <li>
            <a>Home</a>
          </li>
          <!-- <li>
            <a href="team.html" style="--i: 0.25s">  Team </a>
          </li> -->
          <li>
            <a href="contactpage.php" style="--i: 0.3s"> Contact</a>
          </li>
        </ul>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>
