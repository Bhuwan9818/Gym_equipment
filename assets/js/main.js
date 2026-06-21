/* ============================================================
   FITRONFITNESS — shared front-end behaviour
   ============================================================ */

/* ─ THEME ─ */
const html = document.documentElement;
let theme = localStorage.getItem('ig-theme') || 'dark';
function applyTheme(t) {
  html.setAttribute('data-theme', t);
  localStorage.setItem('ig-theme', t);
  const d = t === 'dark';
  const deskBtn = document.getElementById('deskThBtn');
  const mobBtn = document.getElementById('mobThBtn');
  const mobLbl = document.getElementById('mobThLbl');
  if (deskBtn) deskBtn.textContent = d ? '☀️' : '🌙';
  if (mobBtn) mobBtn.textContent = d ? '☀️' : '🌙';
  if (mobLbl) mobLbl.textContent = d ? 'Light Mode' : 'Dark Mode';
}
function toggleTheme() { theme = theme === 'dark' ? 'light' : 'dark'; applyTheme(theme); }
applyTheme(theme);

/* ─ CURSOR ─ */
const cd = document.getElementById('cd'), cr = document.getElementById('cr');
let mx = 0, my = 0, rx = 0, ry = 0;
if (cd && cr && window.matchMedia('(pointer:fine)').matches) {
  document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; cd.style.left = mx + 'px'; cd.style.top = my + 'px'; });
  document.addEventListener('mouseover', e => { cr.classList.toggle('h', !!e.target.closest('a,button')); });
  (function loop() { rx += (mx - rx) * .12; ry += (my - ry) * .12; cr.style.left = rx + 'px'; cr.style.top = ry + 'px'; requestAnimationFrame(loop); })();
}

/* ─ NAV SCROLL STATE ─ */
const navEl = document.getElementById('nav');
if (navEl) {
  window.addEventListener('scroll', () => navEl.classList.toggle('s', scrollY > 60), { passive: true });
}

/* ─ HAMBURGER ─ */
const ham = document.getElementById('ham'), mob = document.getElementById('mobNav');
if (ham && mob) {
  ham.addEventListener('click', () => {
    const o = ham.classList.toggle('o');
    mob.classList.toggle('o', o);
    document.body.style.overflow = o ? 'hidden' : '';
  });
}
function closeMob() {
  if (ham) ham.classList.remove('o');
  if (mob) mob.classList.remove('o');
  document.body.style.overflow = '';
}

/* ─ REVEAL ON SCROLL ─ */
const ro = new IntersectionObserver(es => es.forEach(e => {
  if (e.isIntersecting) { e.target.classList.add('vis'); ro.unobserve(e.target); }
}), { threshold: .1, rootMargin: '0px 0px -36px 0px' });
document.querySelectorAll('.reveal').forEach(el => ro.observe(el));

/* ─ PRODUCT SUB-CATEGORY FILTER (progressive enhancement) ─
   Tabs are real links (?sub=slug) that work without JS. If JS is
   available we intercept the click, filter the already-rendered
   grid instantly, and update the URL without a full reload. */
document.querySelectorAll('.tab[data-subcat]').forEach(btn => {
  btn.addEventListener('click', function (e) {
    e.preventDefault();
    const cat = this.dataset.subcat;
    document.querySelectorAll('.tab[data-subcat]').forEach(b => b.classList.remove('a'));
    this.classList.add('a');
    document.querySelectorAll('.pcard[data-subcat]').forEach(c => {
      c.style.display = (cat === 'all' || c.dataset.subcat === cat) ? '' : 'none';
    });
    const url = new URL(window.location);
    if (cat === 'all') { url.searchParams.delete('sub'); } else { url.searchParams.set('sub', cat); }
    history.replaceState(null, '', url);
  });
});

/* ─ ENQUIRY MODAL ─ */
const modal = document.getElementById('modal');
function enquire(name, sku) {
  if (!modal) return;
  const nameEl = document.getElementById('modalName');
  const skuEl = document.getElementById('modalProductSku');
  if (nameEl) nameEl.textContent = name || 'Product Enquiry';
  if (skuEl) skuEl.value = sku || '';
  const prodField = document.getElementById('modalProductField');
  if (prodField) prodField.value = name || '';
  modal.classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeModal() {
  if (!modal) return;
  modal.classList.remove('open');
  document.body.style.overflow = '';
  const msg = modal.querySelector('.form-msg');
  if (msg) msg.classList.remove('show');
}
if (modal) {
  modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
}

/* ─ AJAX FORM SUBMIT HELPER ─ */
function submitEnquiryForm(form, msgEl, onSuccess) {
  const data = new FormData(form);
  const endpoint = window.ENQUIRE_URL || 'enquire.php';
  fetch(endpoint, { method: 'POST', body: data, headers: { 'X-Requested-With': 'fetch' } })
    .then(r => r.json())
    .then(res => {
      if (msgEl) {
        msgEl.textContent = res.message || (res.ok ? 'Thank you! We will call you shortly.' : 'Something went wrong. Please try again.');
        msgEl.classList.add('show');
      }
      if (res.ok) {
        form.reset();
        if (onSuccess) onSuccess();
      }
    })
    .catch(() => {
      if (msgEl) { msgEl.textContent = 'Network error — please call us directly.'; msgEl.classList.add('show'); }
    });
}

const modalForm = document.getElementById('enquiryForm');
if (modalForm) {
  modalForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const msgEl = modalForm.querySelector('.form-msg');
    submitEnquiryForm(modalForm, msgEl, () => setTimeout(closeModal, 1600));
  });
}

/* ─ CALLBACK MINI-FORM (hero / CTA strip) ─ */
function submitCb() {
  const inp = document.getElementById('phInp');
  if (!inp) return;
  if (!inp.value.trim() || inp.value.trim().length < 7) {
    inp.style.borderColor = '#C0392B';
    inp.focus();
    return;
  }
  const fd = new FormData();
  fd.append('type', 'callback');
  fd.append('phone', inp.value.trim());
  fd.append('page', window.location.href);
  const endpoint = window.ENQUIRE_URL || 'enquire.php';
  fetch(endpoint, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'fetch' } })
    .then(r => r.json())
    .then(() => {
      inp.style.borderColor = '#44ff88';
      inp.placeholder = '✓ We\'ll call you shortly!';
      inp.value = '';
      setTimeout(() => { inp.style.borderColor = ''; inp.placeholder = 'Your mobile number'; }, 3500);
    })
    .catch(() => {
      inp.style.borderColor = '#C0392B';
    });
}

/* ─ SMOOTH SCROLL FOR IN-PAGE ANCHORS ─ */
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const hsel = a.getAttribute('href');
    if (hsel === '#') return;
    const t = document.querySelector(hsel);
    if (t) { e.preventDefault(); closeMob(); setTimeout(() => t.scrollIntoView({ behavior: 'smooth', block: 'start' }), 50); }
  });
});

/* ═══════════════════════════════════════
   HERO CAROUSEL (homepage + category banners)
═══════════════════════════════════════ */
(function () {
  const heroEl = document.getElementById('home');
  if (!heroEl) return;
  const slides = Array.from(document.querySelectorAll('.hero-slide'));
  if (!slides.length) return;
  const dots = Array.from(document.querySelectorAll('.hero-dot'));
  const prevBtn = document.getElementById('heroPrev');
  const nextBtn = document.getElementById('heroNext');
  const curEl = document.getElementById('heroCur');
  const progBar = document.getElementById('heroProgressBar');
  const DUR = parseInt(heroEl.dataset.slideDur) || 5500;

  let current = 0, isPaused = false, rafId = null, segStart = 0;
  const total = slides.length;

  slides.forEach(s => {
    const img = s.querySelector('.hero-slide-imgwrap img');
    if (img && img.complete === false) { const pre = new Image(); pre.src = img.src; }
  });

  function pad(n) { return String(n + 1).padStart(2, '0'); }

  function goTo(idx) {
    const prevIdx = current;
    current = (idx + total) % total;
    if (prevIdx === current) return;
    slides[prevIdx].classList.remove('active');
    slides[prevIdx].setAttribute('aria-hidden', 'true');
    slides[current].classList.add('active');
    slides[current].setAttribute('aria-hidden', 'false');
    if (dots.length) {
      dots[prevIdx].classList.remove('active');
      dots[prevIdx].setAttribute('aria-selected', 'false');
      dots[current].classList.add('active');
      dots[current].setAttribute('aria-selected', 'true');
    }
    if (curEl) curEl.textContent = pad(current);
    restartTimer();
  }
  function next() { goTo(current + 1); }
  function prev() { goTo(current - 1); }

  let pausedAt = 0;
  function tick(now) {
    if (!segStart) segStart = now;
    if (isPaused) { pausedAt = now; rafId = requestAnimationFrame(tick); return; }
    const elapsed = now - segStart;
    const pct = Math.min(elapsed / DUR, 1);
    if (progBar) progBar.style.transform = `scaleX(${pct})`;
    if (pct >= 1) { next(); segStart = now; if (progBar) progBar.style.transform = 'scaleX(0)'; }
    rafId = requestAnimationFrame(tick);
  }
  function restartTimer() { segStart = 0; if (progBar) progBar.style.transform = 'scaleX(0)'; }

  if (total > 1 && window.matchMedia('(hover:hover)').matches) {
    heroEl.addEventListener('mouseenter', () => { isPaused = true; });
    heroEl.addEventListener('mouseleave', () => { isPaused = false; segStart = 0; });
  }
  document.addEventListener('visibilitychange', () => {
    isPaused = document.hidden ? true : isPaused;
    if (!document.hidden) segStart = 0;
  });
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(([entry]) => {
      isPaused = !entry.isIntersecting;
      if (entry.isIntersecting) segStart = 0;
    }, { threshold: 0.15 });
    io.observe(heroEl);
  }
  let touchStartX = 0;
  heroEl.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].clientX; }, { passive: true });
  heroEl.addEventListener('touchend', e => {
    const dx = e.changedTouches[0].clientX - touchStartX;
    if (Math.abs(dx) > 50) { dx < 0 ? next() : prev(); }
  }, { passive: true });
  document.addEventListener('keydown', e => {
    if (e.key === 'ArrowLeft') prev();
    if (e.key === 'ArrowRight') next();
  });
  if (prevBtn) prevBtn.addEventListener('click', prev);
  if (nextBtn) nextBtn.addEventListener('click', next);
  dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)));

  if (total > 1) rafId = requestAnimationFrame(tick);
})();
