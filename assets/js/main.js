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

  /* ---------- back to top + scroll progress ---------- */
  var toTop = document.getElementById('toTop');
  var ringFg = document.getElementById('ringFg');
  var RING_LEN = 131.9; // 2 * PI * r(21)
  function onScroll() {
    onScrollNav();
    var max = document.documentElement.scrollHeight - window.innerHeight;
    var p = max > 0 ? Math.min(1, window.scrollY / max) : 0;
    ringFg.style.strokeDashoffset = String(RING_LEN * (1 - p));
    toTop.classList.toggle('show', window.scrollY > 700);
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll, { passive: true });
  onScroll();
  toTop.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  /* ---------- galéria: lightbox + ajax load more ---------- */
  var gallery = document.getElementById('gallery');
  var lb = document.getElementById('lightbox');
  var lbImg = document.getElementById('lbImg');
  var idx = 0;
  function items() {
    return gallery ? Array.prototype.slice.call(gallery.querySelectorAll('.g-item')) : [];
  }
  function showLb(i) {
    var list = items();
    if (!list.length) return;
    idx = (i + list.length) % list.length;
    lbImg.src = list[idx].getAttribute('href');
    lbImg.alt = list[idx].querySelector('img').alt || '';
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
      showLb(items().indexOf(a));
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

    var moreBtn = document.getElementById('galleryMore');
    if (moreBtn) {
      moreBtn.addEventListener('click', function () {
        moreBtn.classList.add('loading');
        var offset = parseInt(moreBtn.dataset.offset, 10) || 0;
        fetch('gallery.php?offset=' + offset, { headers: { 'Accept': 'application/json' } })
          .then(function (r) { return r.json(); })
          .then(function (data) {
            (data.items || []).forEach(function (g) {
              var a = document.createElement('a');
              a.href = g.src;
              a.className = 'g-item g-new';
              var img = document.createElement('img');
              img.src = g.thumb || g.src;
              img.alt = g.alt || '';
              img.loading = 'lazy';
              img.decoding = 'async';
              a.appendChild(img);
              gallery.appendChild(a);
            });
            moreBtn.dataset.offset = String(offset + (data.items || []).length);
            if (!data.hasMore) moreBtn.classList.add('hide');
          })
          .catch(function () {})
          .finally(function () { moreBtn.classList.remove('loading'); });
      });
    }
  }

  /* ---------- kontaktný formulár ---------- */
  var form = document.getElementById('contactForm');
  if (form) {
    var status = document.getElementById('formStatus');
    var submitBtn = document.getElementById('contactSubmit');
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!form.reportValidity()) return;
      status.textContent = '';
      status.className = 'form-status';
      submitBtn.disabled = true;
      submitBtn.textContent = 'Odosielam…';
      fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'Accept': 'application/json' } })
        .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, data: d }; }); })
        .then(function (res) {
          if (res.ok && res.data.ok) {
            status.textContent = 'Ďakujeme, správa bola odoslaná. Ozveme sa čo najskôr.';
            status.classList.add('ok');
            form.reset();
          } else {
            status.textContent = (res.data && res.data.error) || 'Správu sa nepodarilo odoslať.';
            status.classList.add('err');
          }
        })
        .catch(function () {
          status.textContent = 'Správu sa nepodarilo odoslať. Skúste to prosím neskôr.';
          status.classList.add('err');
        })
        .finally(function () {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Odoslať správu';
        });
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
