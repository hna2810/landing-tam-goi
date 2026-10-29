/**
 * Landing Page Tam Goi Gung Nghe May May - Core Interactions
 *
 * @package LXLanding
 */

(function(){
  var DURATION = 51;
  var box = document.getElementById('ltgType');
  if (!box) return;

  var outB = document.getElementById('ltgTypeBody');
  var outH = document.getElementById('ltgTypeHl');
  var voice = document.getElementById('ltgTypeVoice');
  var ghosts = box.querySelectorAll('.ltg-type-ghost');
  if (!outB || !outH || ghosts.length < 2) return;

  function split(s){
    s = s.replace(/[ \t\r]+/g, ' ').replace(/ *\n */g, '\n').replace(/\n{3,}/g, '\n\n').trim();
    return window.Intl && Intl.Segmenter ? Array.from(new Intl.Segmenter('vi', { granularity: 'grapheme' }).segment(s), function(x){ return x.segment; }) : Array.from(s);
  }

  var cb = split(ghosts[0].textContent);
  var ch = split(ghosts[1].textContent);
  var NB = cb.length;
  var N = NB + ch.length;
  var caret = document.createElement('span');
  caret.className = 'ltg-type-caret';
  caret.setAttribute('aria-hidden', 'true');
  var t0 = 0, raf = 0, shown = -1, running = false, useVoice = false;

  function render(el){
    var k = Math.min(N, Math.floor(el / DURATION * N));
    if (k === shown) return;
    shown = k;
    outB.textContent = cb.slice(0, Math.min(k, NB)).join('');
    outH.textContent = ch.slice(0, Math.max(0, k - NB)).join('');
    (k < NB ? outB : outH).appendChild(caret);
  }

  function frame(){
    var el = useVoice ? voice.currentTime : (performance.now() - t0) / 1000;
    render(el);
    if (el < DURATION && !(useVoice && voice.ended)) {
      raf = requestAnimationFrame(frame);
    } else {
      render(DURATION);
      running = false;
      box.classList.add('is-done');
    }
  }

  function start(){
    cancelAnimationFrame(raf);
    shown = -1;
    running = true;
    box.classList.remove('is-done');
    box.classList.add('is-typing');
    useVoice = voice && !!voice.getAttribute('src');
    if (useVoice) {
      voice.currentTime = 0;
      var pr = voice.play();
      if (pr && pr.catch) pr.catch(function(){ useVoice = false; t0 = performance.now(); });
    }
    t0 = performance.now();
    raf = requestAnimationFrame(frame);
  }

  box.addEventListener('click', function(){ if (!running) start(); });
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function(es){
      if (es[0].isIntersecting && !running && shown < 0) {
        start();
        io.disconnect();
      }
    }, { threshold: 0.4 });
    io.observe(box);
  } else {
    start();
  }
})();

(function(){
  var fmt = function(n){ return (n || 0).toLocaleString('vi-VN') + 'đ'; };
  var root = document.querySelector('.ltg') || document.body;

  /* Safe Element Reveal */
  function initReveal(){
    var rvs = document.querySelectorAll('.ltg-rv');
    if (!rvs.length) return;

    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
          if (e.isIntersecting) {
            e.target.classList.add('is-in');
            io.unobserve(e.target);
          }
        });
      }, { threshold: 0.05, rootMargin: '60px 0px 60px 0px' });

      rvs.forEach(function(el){ io.observe(el); });
    } else {
      rvs.forEach(function(el){ el.classList.add('is-in'); });
    }

    // Safety checks: ensure above-the-fold content is NEVER stuck transparent
    setTimeout(function(){
      rvs.forEach(function(el){
        var rect = el.getBoundingClientRect();
        if (rect.top < (window.innerHeight || document.documentElement.clientHeight) + 150) {
          el.classList.add('is-in');
        }
      });
    }, 400);

    setTimeout(function(){
      rvs.forEach(function(el){ el.classList.add('is-in'); });
    }, 2500);
  }
  initReveal();

  /* Chọn dung tích sản phẩm */
  root.querySelectorAll('[data-card]').forEach(function(card){
    var sizes = card.querySelectorAll('.ltg-size');
    var out = card.querySelector('[data-out]');
    sizes.forEach(function(b, i){
      b.addEventListener('click', function(){
        sizes.forEach(function(x){ x.classList.remove('is-on'); });
        b.classList.add('is-on');
        if (out && out.firstChild) {
          out.firstChild.nodeValue = fmt(+b.dataset.price);
        }
        card.dataset.idx = i;
      });
    });
  });

  /* Tab Trước / Sau */
  var baTabs = root.querySelectorAll('.ltg-ba2-tab');
  var baPanels = root.querySelectorAll('.ltg-ba2-p');
  baTabs.forEach(function(t){
    t.addEventListener('click', function(){
      baTabs.forEach(function(x){ x.classList.toggle('is-on', x === t); });
      baPanels.forEach(function(p){ p.classList.toggle('is-on', p.dataset.bap === t.dataset.ba); });
    });
  });

  /* Chọn combo đặt hàng */
  var cbox = document.getElementById('ltgCombo');
  var wrap = document.getElementById('ltgWrap');
  var msg = document.getElementById('ltgMsg');

  function syncCombo(){
    root.querySelectorAll('.ltg-copt input').forEach(function(r){
      var parent = r.closest('.ltg-copt');
      if (parent) parent.classList.toggle('is-on', r.checked);
    });
    if (cbox) cbox.classList.remove('is-err');
  }

  root.querySelectorAll('.ltg-copt input').forEach(function(r){
    r.addEventListener('change', syncCombo);
  });

  root.querySelectorAll('[data-combo]').forEach(function(a){
    a.addEventListener('click', function(){
      var r = root.querySelector('.ltg-copt input[value="' + a.dataset.combo + '"]');
      if (r) { r.checked = true; syncCombo(); }
    });
  });

  /* Nút "Chọn set này" ở phần quà 20/11 */
  root.querySelectorAll('[data-set]').forEach(function(a){
    a.addEventListener('click', function(){
      if (wrap) wrap.checked = true;
      if (msg) msg.style.display = 'block';
    });
  });

  if (wrap && msg) {
    wrap.addEventListener('change', function(){
      msg.style.display = this.checked ? 'block' : 'none';
    });
  }

  /* Form Đặt Hàng AJAX */
  var form = document.getElementById('ltgForm');
  if (form) {
    form.addEventListener('submit', function(e){
      e.preventDefault();
      var f = this, ok = true;
      var c = root.querySelector('.ltg-copt input[type=radio]:checked');

      ['name','phone','address'].forEach(function(n){
        var el = f.elements[n];
        if (!el) return;
        if (!el.value.trim()) {
          el.style.borderColor = '#b8412b';
          ok = false;
        } else {
          el.style.borderColor = '';
        }
      });

      if (f.elements.phone) {
        var cleanPhone = f.elements.phone.value.replace(/[\s.]/g, '');
        if (!/^0\d{9}$/.test(cleanPhone)) {
          f.elements.phone.style.borderColor = '#b8412b';
          ok = false;
        }
      }

      if (!c && cbox) {
        cbox.classList.add('is-err');
        ok = false;
      }
      if (!ok) return;

      var btn = f.querySelector('button[type=submit]');
      var oldBtnText = btn ? btn.textContent : '';
      if (btn) {
        btn.disabled = true;
        btn.textContent = 'Đang gửi thông tin...';
      }

      var comboText = c ? (c.closest('.ltg-copt') ? c.closest('.ltg-copt').textContent.trim() : c.value) : '';
      var formData = new FormData();
      formData.append('action', 'lx_submit_order');
      if (window.lx_landing_vars && window.lx_landing_vars.nonce) {
        formData.append('nonce', window.lx_landing_vars.nonce);
      }
      formData.append('name', f.elements.name ? f.elements.name.value : '');
      formData.append('phone', f.elements.phone ? f.elements.phone.value : '');
      formData.append('address', f.elements.address ? f.elements.address.value : '');
      formData.append('combo', comboText);
      formData.append('giftwrap', (wrap && wrap.checked) ? 'Có' : 'Không');
      formData.append('card', f.elements.card ? f.elements.card.value : '');

      var ajaxUrl = (window.lx_landing_vars && window.lx_landing_vars.ajax_url) ? window.lx_landing_vars.ajax_url : '/wp-admin/admin-ajax.php';

      fetch(ajaxUrl, {
        method: 'POST',
        body: formData
      })
      .then(function(res){ return res.json(); })
      .then(function(json){
        var formBody = document.getElementById('ltgFormBody');
        var formOk = document.getElementById('ltgOk');
        if (formBody) formBody.style.display = 'none';
        if (formOk) {
          formOk.style.display = 'block';
          if (json && json.data && json.data.message) {
            var msgEl = formOk.querySelector('p');
            if (msgEl) msgEl.textContent = json.data.message;
          }
        }
      })
      .catch(function(err){
        console.error('Submit order error:', err);
        var formBody = document.getElementById('ltgFormBody');
        var formOk = document.getElementById('ltgOk');
        if (formBody) formBody.style.display = 'none';
        if (formOk) formOk.style.display = 'block';
      })
      .finally(function(){
        if (btn) {
          btn.disabled = false;
          btn.textContent = oldBtnText;
        }
      });
    });
  }

  /* Đếm ngược */
  var cd = document.getElementById('ltgCount');
  var topEl = document.getElementById('ltgTop');
  var fcd = document.getElementById('ltgFormCd');
  var pad = function(n){ return String(Math.floor(Math.max(0, n))).padStart(2, '0'); };

  function tick(){
    var now = new Date(), y = now.getFullYear();
    var end = new Date(y, 10, 20);
    if (now > end) end = new Date(y + 1, 10, 20);
    var d = Math.max(0, end - now) / 1000;

    if (cd) {
      var dEl = cd.querySelector('[data-d]'); if (dEl) dEl.textContent = pad(d / 86400);
      var hEl = cd.querySelector('[data-h]'); if (hEl) hEl.textContent = pad((d % 86400) / 3600);
      var mEl = cd.querySelector('[data-m]'); if (mEl) mEl.textContent = pad((d % 3600) / 60);
      var sEl = cd.querySelector('[data-s]'); if (sEl) sEl.textContent = pad(d % 60);
    }

    var eod = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1);
    var r = Math.max(0, eod - now) / 1000;

    if (topEl) {
      topEl.textContent = pad(r / 3600) + ':' + pad((r % 3600) / 60) + ':' + pad(r % 60);
    }
    if (fcd) {
      var fh = fcd.querySelector('[data-h]'); if (fh) fh.textContent = pad(r / 3600);
      var fm = fcd.querySelector('[data-m]'); if (fm) fm.textContent = pad((r % 3600) / 60);
      var fs = fcd.querySelector('[data-s]'); if (fs) fs.textContent = pad(r % 60);
    }
  }
  tick();
  setInterval(tick, 1000);

  /* Lightbox video / ảnh */
  var lb = document.getElementById('ltgLb');
  var lbBox = document.getElementById('ltgLbBox');

  function embed(u){
    var m;
    if (m = u.match(/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([\w-]{6,})/)) {
      return '<iframe src="https://www.youtube.com/embed/' + m[1] + '?autoplay=1&rel=0" allow="autoplay;encrypted-media;fullscreen" allowfullscreen></iframe>';
    }
    if (m = u.match(/tiktok\.com\/.*\/video\/(\d+)/)) {
      return '<iframe src="https://www.tiktok.com/embed/v2/' + m[1] + '" allow="autoplay;encrypted-media;fullscreen" allowfullscreen></iframe>';
    }
    if (/facebook\.com|fb\.watch/.test(u)) {
      return '<iframe src="https://www.facebook.com/plugins/video.php?href=' + encodeURIComponent(u) + '&show_text=false&autoplay=1" allow="autoplay;encrypted-media;fullscreen" allowfullscreen></iframe>';
    }
    if (/\.(mp4|webm)(\?|$)/i.test(u)) {
      return '<video src="' + u + '" controls autoplay playsinline></video>';
    }
    return '<iframe src="' + u + '" allowfullscreen></iframe>';
  }

  function openLb(html, cls){
    if (!lb || !lbBox) return;
    lbBox.className = 'ltg-lb-box ' + (cls || '');
    lbBox.innerHTML = html;
    lb.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  }

  function closeLb(){
    if (!lb || !lbBox) return;
    lb.classList.remove('is-open');
    lbBox.innerHTML = '';
    document.body.style.overflow = '';
  }

  root.querySelectorAll('[data-video]').forEach(function(el){
    function go(){
      var u = (el.dataset.video || '').trim();
      var v = el.dataset.vertical ? 'is-v' : '';
      openLb(u ? embed(u) : '<div class="ltg-lb-empty">🎬 Video đang được cập nhật.<br>Vui lòng quay lại sau hoặc gọi hotline 0962 131 515.</div>', v);
    }
    el.addEventListener('click', go);
    el.addEventListener('keydown', function(e){ if (e.key === 'Enter') go(); });
  });

  root.querySelectorAll('[data-img]').forEach(function(el){
    el.addEventListener('click', function(){
      openLb('<img src="' + el.dataset.img + '" alt="">', 'is-img');
    });
  });

  if (lb) {
    lb.addEventListener('click', function(e){
      if (e.target === lb || e.target.classList.contains('ltg-lb-x')) closeLb();
    });
  }
  document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeLb(); });

  /* Sticky CTA Bar */
  var st = document.getElementById('ltgSticky');
  var ord = document.getElementById('dat-hang');
  if (st && ord) {
    function stk(){
      var r = ord.getBoundingClientRect();
      var inForm = r.top < window.innerHeight && r.bottom > 0;
      st.classList.toggle('is-show', window.scrollY > 560 && !inForm);
    }
    window.addEventListener('scroll', stk, { passive: true });
    stk();
  }

  /* FX & Parallax */
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var prog = document.getElementById('ltgProg');
  var nav = root.querySelector('.ltg-nav');
  var deco = document.getElementById('ltgDeco');
  var ticking = false;

  function onScroll(){
    var h = document.documentElement;
    var max = h.scrollHeight - h.clientHeight;
    var y = window.scrollY;
    if (prog) prog.style.transform = 'scaleX(' + (max > 0 ? y / max : 0) + ')';
    if (nav) nav.classList.toggle('is-scrolled', y > 20);
    if (!reduce && deco && y < 1200) deco.style.transform = 'translateY(' + (y * 0.18) + 'px)';
    ticking = false;
  }
  window.addEventListener('scroll', function(){
    if (!ticking) {
      ticking = true;
      requestAnimationFrame(onScroll);
    }
  }, { passive: true });
  onScroll();

  /* Animations Stagger */
  root.querySelectorAll('.ltg-feat-img, .ltg-ing-photo, .ltg-vlong, .ltg-combo').forEach(function(el){ el.classList.add('ltg-z'); });
  root.querySelectorAll('.ltg-feat:not(.ltg-feat--rev) .ltg-feat-img + div, .ltg-story-imgs').forEach(function(el){ el.classList.add('ltg-l'); });
  root.querySelectorAll('.ltg-feat--rev .ltg-feat-img + div, .ltg-hero-img').forEach(function(el){ el.classList.add('ltg-r'); });

  ['.ltg-pain-grid','.ltg-pks','.ltg-sets','.ltg-rev-grid','.ltg-steps','.ltg-ing-grid','.ltg-flow','.ltg-shots','.ltg-gift-perks','.ltg-proof-grid','.ltg-ba','.ltg-stats','.ltg-trust .ltg-wrap'].forEach(function(sel){
    root.querySelectorAll(sel).forEach(function(g){
      var i = 0;
      Array.prototype.forEach.call(g.children, function(c){
        if (c.classList.contains('ltg-rv')) {
          c.style.transitionDelay = (i % 4) * 110 + 'ms';
          i++;
        }
      });
    });
  });

  /* Số đếm */
  if ('IntersectionObserver' in window) {
    var countEls = root.querySelectorAll('[data-count]');
    if (countEls.length) {
      var cio = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
          if (!e.isIntersecting) return;
          cio.unobserve(e.target);
          var el = e.target;
          var to = +el.dataset.count;
          var suf = el.dataset.suffix || '';
          var from = to > 1000 ? 1990 : 0;
          var t0 = null;
          if (reduce) { el.textContent = to + suf; return; }
          function step(ts){
            if (!t0) t0 = ts;
            var k = Math.min(1, (ts - t0) / 1400);
            var v = Math.round(from + (to - from) * (1 - Math.pow(1 - k, 3)));
            el.textContent = v + suf;
            if (k < 1) requestAnimationFrame(step);
          }
          requestAnimationFrame(step);
        });
      }, { threshold: 0.6 });
      countEls.forEach(function(el){ cio.observe(el); });
    }
  }

  /* Desktop mouse glow & 3D tilt */
  if (!reduce && window.matchMedia('(hover:hover) and (min-width:981px)').matches) {
    var hero = root.querySelector('.ltg-hero');
    if (hero) {
      hero.addEventListener('mousemove', function(e){
        var r = hero.getBoundingClientRect();
        hero.style.setProperty('--mx', (e.clientX - r.left) + 'px');
        hero.style.setProperty('--my', (e.clientY - r.top) + 'px');
      });
    }
    root.querySelectorAll('.ltg-hero-img, .ltg-feat-img, .ltg-combo-pair img, .ltg-set-img').forEach(function(el){
      el.classList.add('ltg-tilt');
      el.addEventListener('mousemove', function(e){
        var r = el.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - 0.5;
        var y = (e.clientY - r.top) / r.height - 0.5;
        el.style.transform = 'perspective(900px) rotateY(' + (x * 8) + 'deg) rotateX(' + (-y * 8) + 'deg)';
      });
      el.addEventListener('mouseleave', function(){ el.style.transform = ''; });
    });
  }
})();
