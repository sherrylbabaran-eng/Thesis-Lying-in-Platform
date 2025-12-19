
AOS.init({duration:1000,once:true});

// Modal JS
const modal = document.getElementById('articleModal');
const modalTitle = document.getElementById('modalTitle');
const modalContent = document.getElementById('modalContent');
const closeModal = document.getElementById('closeModal');

document.querySelectorAll('.article-card .read-more').forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    const card = btn.closest('.article-card');
    modalTitle.textContent = card.querySelector('h3').textContent;
    modalContent.textContent = card.querySelector('.preview-text').textContent;
    modal.style.display = 'flex';
  });
});

closeModal.addEventListener('click', () => modal.style.display = 'none');
window.addEventListener('click', e => { if(e.target === modal) modal.style.display = 'none'; });

// Hero image slider
const hero = document.querySelector('.hero');
// Reliable online background images (Unsplash CDN with query params)
const heroImages = [
  'https://images.pexels.com/photos/28099425/pexels-photo-28099425.jpeg?auto=compress&cs=tinysrgb&w=1600',
  'https://images.pexels.com/photos/7055942/pexels-photo-7055942.jpeg?auto=compress&cs=tinysrgb&w=1600',
  'https://images.pexels.com/photos/7485055/pexels-photo-7485055.jpeg?auto=compress&cs=tinysrgb&w=1600',
  'https://images.pexels.com/photos/19751878/pexels-photo-19751878.jpeg?auto=compress&cs=tinysrgb&w=1600'
];




let current = 0;

// Preload images to reduce flicker
if (Array.isArray(heroImages) && heroImages.length) {
  heroImages.forEach(src => { const i = new Image(); i.src = src; });
}

// Background layer (so content doesn't blink)
const heroBg = document.querySelector('.hero .hero-bg');

// Set initial background on the background layer
if (heroBg && Array.isArray(heroImages) && heroImages.length > 0) {
  heroBg.style.backgroundImage = `url('${heroImages[current]}')`;
  heroBg.style.opacity = '1';
}

// Smooth image change that only affects the background layer
function changeHeroImage() {
  if (!heroBg || !Array.isArray(heroImages) || heroImages.length === 0) return;

  // Fade out current background
  heroBg.style.opacity = '0';

  setTimeout(() => {
    current = (current + 1) % heroImages.length;
    heroBg.style.backgroundImage = `url('${heroImages[current]}')`;
    heroBg.style.opacity = '1';
  }, 1000);
}

// Auto-change every 5 seconds
setInterval(changeHeroImage, 5000);

// Smooth scroll for nav links (improves behavior on older browsers)
document.querySelectorAll('nav a[href^="#"]').forEach(link => {
  link.addEventListener('click', function(e){
    const targetId = this.getAttribute('href').slice(1);
    const target = document.getElementById(targetId);
    if(target){
      e.preventDefault();
      target.scrollIntoView({behavior:'smooth', block:'start'});
      // Update the URL hash without jumping
      history.pushState(null, '', `#${targetId}`);
    }
  });
});

// Keep nav active state in sync with scroll position using IntersectionObserver
(() => {
  const navLinks = Array.from(document.querySelectorAll('nav a[href^="#"]'));
  const sections = navLinks.map(l => document.getElementById(l.getAttribute('href').slice(1))).filter(Boolean);
  if(!sections.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(!entry.target.id) return;
      const id = entry.target.id;
      // When a section is intersecting, highlight corresponding link
      if(entry.isIntersecting){
        navLinks.forEach(a => {
          a.classList.toggle('active', a.getAttribute('href') === `#${id}`);
        });
      }
    });
  }, { root: null, rootMargin: '-40% 0px -40% 0px', threshold: 0 });

  sections.forEach(s => observer.observe(s));
})();

// Mobile nav toggle
(function(){
  const header = document.querySelector('header');
  const btn = document.querySelector('.menu-btn');
  const nav = document.querySelector('nav');
  if(!btn || !header || !nav) return;

  // write header height into CSS variable so the nav overlay positions correctly
  const setHeaderHeightVar = () => {
    const h = header.getBoundingClientRect().height || 64;
    document.documentElement.style.setProperty('--header-h', `${Math.round(h)}px`);
  };
  setHeaderHeightVar();
  window.addEventListener('resize', setHeaderHeightVar);

  const closeNav = () => {
    header.classList.remove('nav-open');
    btn.setAttribute('aria-expanded','false');
    btn.setAttribute('aria-label','Open navigation');
    document.body.style.overflow = '';
  };
  const openNav = () => {
    header.classList.add('nav-open');
    btn.setAttribute('aria-expanded','true');
    btn.setAttribute('aria-label','Close navigation');
    document.body.style.overflow = 'hidden';
  };

  btn.addEventListener('click', (e)=>{
    const expanded = btn.getAttribute('aria-expanded') === 'true';
    if(expanded) closeNav(); else openNav();
  });

  // Close when clicking a nav link
  nav.addEventListener('click', (e)=>{
    if(e.target.tagName === 'A') closeNav();
  });

  // Close on Escape
  document.addEventListener('keydown', (e)=>{
    if(e.key === 'Escape') closeNav();
  });

  // Close on outside click
  document.addEventListener('click', (e)=>{
    if(!header.classList.contains('nav-open')) return;
    if(header.contains(e.target)) return;
    closeNav();
  });
})();
