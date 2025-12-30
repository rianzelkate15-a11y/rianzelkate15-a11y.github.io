// -------------------- TYPING EFFECT --------------------
const text = "Hi, I'm Rianzel 💜";
let i = 0;
const typing = document.querySelector(".typing");

function type() {
  if(i < text.length){
    typing.textContent += text.charAt(i);
    i++;
    setTimeout(type,120);
  }
}
type();

// -------------------- SMOOTH SCROLL NAV --------------------
document.querySelectorAll('.top-nav a').forEach(link=>{
  link.addEventListener('click', e=>{
    e.preventDefault();
    const target = document.querySelector(link.getAttribute('href'));
    target.scrollIntoView({behavior:'smooth'});
  });
});

// -------------------- DARK MODE WITH LOCALSTORAGE --------------------
const darkToggle = document.getElementById('dark-toggle');

if(localStorage.getItem('darkMode') === 'true'){
  document.body.classList.add('dark');
  darkToggle.checked = true;
}

darkToggle.addEventListener('change', ()=>{
  document.body.classList.toggle('dark');
  localStorage.setItem('darkMode', darkToggle.checked);
});

// -------------------- HERO BACKGROUND ANIMATION --------------------
const canvas = document.getElementById('game-bg');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const stars = [];
const spaceships = [];
for(let i=0;i<100;i++){ stars.push({x:Math.random()*canvas.width,y:Math.random()*canvas.height,radius:Math.random()*2+1,speed:Math.random()*0.5+0.2}); }
for(let i=0;i<5;i++){ spaceships.push({x:Math.random()*canvas.width,y:Math.random()*canvas.height/2,width:40,height:20,speed:Math.random()*2+1}); }

function animateBg(){
  ctx.clearRect(0,0,canvas.width,canvas.height);
  stars.forEach(s=>{
    ctx.beginPath();
    ctx.arc(s.x,s.y,s.radius,0,Math.PI*2);
    ctx.fillStyle='#FFF';
    ctx.fill();
    ctx.closePath();
    s.y += s.speed;
    if(s.y>canvas.height) s.y=0;
  });
  spaceships.forEach(ship=>{
    ctx.fillStyle='#FF69B4';
    ctx.beginPath();
    ctx.moveTo(ship.x, ship.y);
    ctx.lineTo(ship.x-ship.width/2, ship.y+ship.height);
    ctx.lineTo(ship.x+ship.width/2, ship.y+ship.height);
    ctx.closePath();
    ctx.fill();
    ship.x += ship.speed;
    if(ship.x>canvas.width+50) ship.x=-50;
  });
  requestAnimationFrame(animateBg);
}
animateBg();

// -------------------- RESIZE CANVAS --------------------
window.addEventListener('resize', ()=>{
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
});

function launchConfetti() {
  const colors = ['#FFD700', '#FF69B4', '#FF00FF', '#00FFFF', '#7C5DFA'];
  
  // Create 30 confetti pieces
  for (let i = 0; i < 30; i++) {
    const confetti = document.createElement('div');
    confetti.classList.add('confetti');
    confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
    
    // Random horizontal position
    confetti.style.left = Math.random() * window.innerWidth + 'px';
    confetti.style.top = '-10px';
    
    // Random size
    const size = Math.random() * 10 + 5;
    confetti.style.width = size + 'px';
    confetti.style.height = size + 'px';
    
    // Add to body
    document.body.appendChild(confetti);

    // Remove confetti after 2s
    setTimeout(() => confetti.remove(), 2000);
  }
}

// Trigger confetti when image is clicked
document.querySelector('.hero-pic').addEventListener('click', launchConfetti);

const heroPic = document.querySelector('.hero-pic');

function triggerEffect() {
  heroPic.classList.remove('interact'); // reset animation
  void heroPic.offsetWidth;             // force reflow
  heroPic.classList.add('interact');

  // Confetti
  for (let i = 0; i < 30; i++) {
    const confetti = document.createElement('div');
    confetti.className = 'confetti';

    confetti.style.left = Math.random() * 100 + 'vw';
    confetti.style.backgroundColor =
      ['#FFD700', '#FF69B4', '#7c5dfa', '#00FFFF'][Math.floor(Math.random() * 4)];

    document.body.appendChild(confetti);
    setTimeout(() => confetti.remove(), 2000);
  }
}

heroPic.addEventListener('click', triggerEffect);
heroPic.addEventListener('mouseenter', triggerEffect);
