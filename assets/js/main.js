/* Sunset v Raji 2026 */
(function () {
  'use strict';

  /* ---------- nav ---------- */
  var nav = document.getElementById('nav');
  var burger = document.getElementById('navBurger');
  var links = document.getElementById('navLinks');
  function onScrollNav() {
    nav.classList.toggle('solid', window.scrollY > 40);
  }
  window.addEventListener('scroll', onScrollNav, { passive: true });
  onScrollNav();
  burger.addEventListener('click', function () {
    var open = links.classList.toggle('open');
    burger.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
  links.addEventListener('click', function (e) {
    if (e.target.tagName === 'A') {
      links.classList.remove('open');
      burger.setAttribute('aria-expanded', 'false');
    }
  });

  /* ---------- back to top ---------- */
  var toTop = document.getElementById('toTop');
  window.addEventListener('scroll', function () {
    toTop.classList.toggle('show', window.scrollY > 700);
  }, { passive: true });
  toTop.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  /* ---------- lightbox ---------- */
  var gallery = document.getElementById('gallery');
  var lb = document.getElementById('lightbox');
  var lbImg = document.getElementById('lbImg');
  var items = gallery ? Array.prototype.slice.call(gallery.querySelectorAll('.g-item')) : [];
  var idx = 0;
  function showLb(i) {
    idx = (i + items.length) % items.length;
    lbImg.src = items[idx].getAttribute('href');
    lbImg.alt = items[idx].querySelector('img').alt || '';
    lb.hidden = false;
    document.body.style.overflow = 'hidden';
  }
  function hideLb() {
    lb.hidden = true;
    lbImg.src = '';
    document.body.style.overflow = '';
  }
  if (gallery) {
    gallery.addEventListener('click', function (e) {
      var a = e.target.closest('.g-item');
      if (!a) return;
      e.preventDefault();
      showLb(parseInt(a.dataset.index, 10));
    });
    document.getElementById('lbClose').addEventListener('click', hideLb);
    document.getElementById('lbPrev').addEventListener('click', function () { showLb(idx - 1); });
    document.getElementById('lbNext').addEventListener('click', function () { showLb(idx + 1); });
    lb.addEventListener('click', function (e) { if (e.target === lb) hideLb(); });
    document.addEventListener('keydown', function (e) {
      if (lb.hidden) return;
      if (e.key === 'Escape') hideLb();
      if (e.key === 'ArrowLeft') showLb(idx - 1);
      if (e.key === 'ArrowRight') showLb(idx + 1);
    });
    var touchX = null;
    lb.addEventListener('touchstart', function (e) { touchX = e.touches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', function (e) {
      if (touchX === null) return;
      var dx = e.changedTouches[0].clientX - touchX;
      if (Math.abs(dx) > 50) showLb(dx > 0 ? idx - 1 : idx + 1);
      touchX = null;
    }, { passive: true });
  }

  /* ---------- map on demand ---------- */
  var mapBox = document.getElementById('mapBox');
  var mapLoad = document.getElementById('mapLoad');
  if (mapLoad) {
    mapLoad.addEventListener('click', function () {
      var q = encodeURIComponent(mapBox.dataset.q || 'Kamenná Poruba');
      var f = document.createElement('iframe');
      f.src = 'https://maps.google.com/maps?q=' + q + '&t=k&z=14&hl=sk&output=embed';
      f.loading = 'lazy';
      f.title = 'Mapa – miesto podujatia';
      f.setAttribute('allowfullscreen', '');
      f.referrerPolicy = 'no-referrer-when-downgrade';
      mapBox.innerHTML = '';
      mapBox.appendChild(f);
    });
  }

  /* ---------- cookies + tracking ---------- */
  var CK = 'svr_consent';
  var bar = document.getElementById('cookiebar');
  function getConsent() {
    try { return localStorage.getItem(CK); } catch (e) { return null; }
  }
  function setConsent(v) {
    try { localStorage.setItem(CK, v); } catch (e) {}
    bar.hidden = true;
    if (v === 'all') loadTracking();
  }
  function loadTracking() {
    var pixelId = document.body.dataset.pixel;
    var gaId = document.body.dataset.ga;
    if (pixelId) {
      !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
      n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
      document,'script','https://connect.facebook.net/en_US/fbevents.js');
      window.fbq('init', pixelId);
      window.fbq('track', 'PageView');
    }
    if (gaId) {
      var s = document.createElement('script');
      s.async = true;
      s.src = 'https://www.googletagmanager.com/gtag/js?id=' + gaId;
      document.head.appendChild(s);
      window.dataLayer = window.dataLayer || [];
      window.gtag = function () { window.dataLayer.push(arguments); };
      window.gtag('js', new Date());
      window.gtag('config', gaId, { anonymize_ip: true });
    }
  }
  var consent = getConsent();
  if (consent === 'all') {
    loadTracking();
  } else if (consent === null) {
    bar.hidden = false;
  }
  document.getElementById('ckAll').addEventListener('click', function () { setConsent('all'); });
  document.getElementById('ckNec').addEventListener('click', function () { setConsent('necessary'); });
})();
