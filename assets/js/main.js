/**
 * Landing Page Tam Goi Gung Nghe May May - Core Interactions
 *
 * @package LXLanding
 */

// 1. FOUNDER VOICE AUDIO PLAYER
(function(){
  var player = document.getElementById('ltgVoicePlayer');
  if (!player) return;

  var audio = document.getElementById('ltgTypeVoice');
  var btn = document.getElementById('ltgVoiceBtn');
  var fill = document.getElementById('ltgVoiceFill');
  var curTime = document.getElementById('ltgVoiceCur');
  var durTime = document.getElementById('ltgVoiceDur');
  var bar = document.getElementById('ltgVoiceBar');
  var playIc = btn ? btn.querySelector('.ltg-voice-play-ic') : null;
  var pauseIc = btn ? btn.querySelector('.ltg-voice-pause-ic') : null;

  if (!audio || !btn) return;

  function fmtTime(sec){
    if (isNaN(sec) || sec < 0) return '00:00';
    var m = Math.floor(sec / 60);
    var s = Math.floor(sec % 60);
    return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
  }

  function setPlayingState(isPlaying){
    if (isPlaying) {
      player.classList.add('is-playing');
      if (playIc) playIc.style.display = 'none';
      if (pauseIc) pauseIc.style.display = 'block';
    } else {
      player.classList.remove('is-playing');
      if (playIc) playIc.style.display = 'block';
      if (pauseIc) pauseIc.style.display = 'none';
    }
  }

  // Update duration when metadata loads
  audio.addEventListener('loadedmetadata', function(){
    if (durTime && audio.duration) {
      durTime.textContent = fmtTime(audio.duration);
    }
  });

  // Track progress
  audio.addEventListener('timeupdate', function(){
    if (audio.duration) {
      var pct = (audio.currentTime / audio.duration) * 100;
      if (fill) fill.style.width = pct + '%';
      if (curTime) curTime.textContent = fmtTime(audio.currentTime);
      if (durTime && (durTime.textContent === '--:--' || durTime.textContent === '00:00')) {
        durTime.textContent = fmtTime(audio.duration);
      }
    }
  });

  // Toggle play/pause
  btn.addEventListener('click', function(e){
    e.preventDefault();
    if (audio.paused) {
      audio.play().then(function(){
        setPlayingState(true);
      }).catch(function(err){
        console.warn('Audio play notice:', err);
      });
    } else {
      audio.pause();
      setPlayingState(false);
    }
  });

  // Handle seek on bar click
  if (bar) {
    bar.addEventListener('click', function(e){
      var rect = bar.getBoundingClientRect();
      var clickX = e.clientX - rect.left;
      var ratio = Math.max(0, Math.min(1, clickX / rect.width));
      if (audio.duration) {
        audio.currentTime = ratio * audio.duration;
      }
    });
  }

  // Audio ended
  audio.addEventListener('ended', function(){
    setPlayingState(false);
    if (fill) fill.style.width = '0%';
    if (curTime) curTime.textContent = '00:00';
  });
})();

// 2. MAIN INTERACTIONS
(function(){
  var fmt = function(n){ return (n || 0).toLocaleString('vi-VN') + 'đ'; };
  var root = document.querySelector('.ltg') || document.body;

  /* Safe Element Reveal */
  function initReveal(){
    var rvs = document.querySelectorAll('.ltg-rv');
    if (!rvs.length) return;

    // Immediately reveal any element in or near the viewport
    function checkVisible(){
      var vh = window.innerHeight || document.documentElement.clientHeight;
      rvs.forEach(function(el){
        var r = el.getBoundingClientRect();
        if (r.top < vh + 120 && r.bottom > -80) {
          el.classList.add('is-in');
        }
      });
    }

    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
          if (e.isIntersecting) {
            e.target.classList.add('is-in');
            io.unobserve(e.target);
          }
        });
      }, { threshold: 0.05, rootMargin: '100px 0px 100px 0px' });

      rvs.forEach(function(el){ io.observe(el); });
    } else {
      rvs.forEach(function(el){ el.classList.add('is-in'); });
    }

    checkVisible();
    setTimeout(checkVisible, 300);
    setTimeout(function(){
      rvs.forEach(function(el){ el.classList.add('is-in'); });
    }, 2000);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReveal);
  } else {
    initReveal();
  }

  /* Dung tích sản phẩm nếu có */
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

  /* Tab Trước / Sau (ltg-ba3 & ltg-ba2) */
  var baTabs = root.querySelectorAll('.ltg-ba3-tab, .ltg-ba2-tab');
  var baPanels = root.querySelectorAll('.ltg-ba3-p, .ltg-ba2-p');
  baTabs.forEach(function(t){
    t.addEventListener('click', function(){
      var targetKey = t.dataset.ba;
      baTabs.forEach(function(x){ x.classList.toggle('is-on', x === t); });
      baPanels.forEach(function(p){
        p.classList.toggle('is-on', p.dataset.bap === targetKey);
      });
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
      if (r) {
        r.checked = true;
        syncCombo();
      }
    });
  });

  /* Nút "Chọn set này" ở phần quà 20/11 */
  root.querySelectorAll('[data-set]').forEach(function(a){
    a.addEventListener('click', function(){
      if (wrap) wrap.checked = true;
      if (msg) msg.style.display = 'block';
      var r = root.querySelector('.ltg-copt input[value="dac-biet"]') || root.querySelector('.ltg-copt input[value="ban-chay"]');
      if (r) {
        r.checked = true;
        syncCombo();
      }
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

      ['name', 'phone', 'address'].forEach(function(n){
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
        var cleanPhone = f.elements.phone.value.replace(/[\s.-]/g, '');
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
