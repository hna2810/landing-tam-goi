/**
 * Landing Page Tam Goi Gung Nghe May May - Core Interactions
 *
 * @package LXLanding
 */

// 1. FOUNDER VOICE & SYNCHRONIZED TYPEWRITER / HANDWRITING REVEAL (51s)
(function(){
  try {
    var box = document.getElementById('ltgType');
    var outB = document.getElementById('ltgTypeBody');
    var outH = document.getElementById('ltgTypeHl');
    var ghostB = document.getElementById('ltgGhostBody');
    var ghostH = document.getElementById('ltgGhostHl');
    var voice = document.getElementById('ltgTypeVoice');
    var vCtrl = document.getElementById('ltgVoiceCtrl');
    var vBtn = document.getElementById('ltgVoiceBtn');
    var vLabel = document.getElementById('ltgVoiceLabel');
    var vPulse = document.getElementById('ltgVoicePulse');
    var icPlay = vBtn ? vBtn.querySelector('.ltg-ic-play') : null;
    var icPause = vBtn ? vBtn.querySelector('.ltg-ic-pause') : null;

    if (!box || !outB) return;

    var DURATION = 51; // 51 seconds total duration
    var running = false;
    var started = false;
    var isPlaying = false;
    var primed = false;
    var rafId = null;
    var t0 = 0;
    var useVoice = !!(voice && voice.src);

    // Split text into Vietnamese grapheme clusters (preserving accents & combined letters)
    function splitGraphemes(str) {
      if (!str) return [];
      str = str.replace(/[ \t\r]+/g, ' ').replace(/ *\n */g, '\n').replace(/\n{3,}/g, '\n\n').trim();
      if (typeof Intl !== 'undefined' && Intl.Segmenter) {
        var seg = new Intl.Segmenter('vi', { granularity: 'grapheme' });
        return Array.from(seg.segment(str), function(x){ return x.segment; });
      }
      return Array.from(str);
    }

    var cb = ghostB ? splitGraphemes(ghostB.textContent) : [];
    var ch = ghostH ? splitGraphemes(ghostH.textContent) : [];
    var NB = cb.length;
    var NH = ch.length;
    var N = NB + NH;

    if (N === 0) return;

    // Create elegant blinking caret / pen cursor
    var caret = document.createElement('span');
    caret.className = 'ltg-type-caret';
    caret.setAttribute('aria-hidden', 'true');

    var lastRendered = -1;

    function render(elapsedSec) {
      var totalDur = DURATION;
      if (useVoice && voice && voice.duration && !isNaN(voice.duration) && voice.duration > 5) {
        totalDur = voice.duration;
      }

      var progress = Math.min(1, Math.max(0, elapsedSec / totalDur));
      var k = Math.min(N, Math.floor(progress * N));

      if (k === lastRendered) return;
      lastRendered = k;

      if (k <= NB) {
        outB.textContent = cb.slice(0, k).join('');
        if (outH) outH.textContent = '';
        outB.appendChild(caret);
      } else {
        outB.textContent = cb.join('');
        if (outH) {
          outH.textContent = ch.slice(0, k - NB).join('');
          outH.appendChild(caret);
        }
      }
    }

    function updateControlUI(playing, labelText) {
      isPlaying = playing;
      if (!vBtn) return;
      vBtn.classList.toggle('is-playing', playing);
      if (icPlay) icPlay.style.display = playing ? 'none' : 'inline-block';
      if (icPause) icPause.style.display = playing ? 'inline-block' : 'none';
      if (vPulse) vPulse.style.display = playing ? 'none' : 'block';
      if (vLabel && labelText) vLabel.textContent = labelText;
    }

    function onComplete() {
      running = false;
      isPlaying = false;
      updateControlUI(false, 'Lắng nghe lại tâm sự Chị Mai (51s)');
      var totalDur = (useVoice && voice && voice.duration) ? voice.duration : DURATION;
      render(totalDur);
      if (caret.parentNode) {
        caret.parentNode.removeChild(caret);
      }
      box.classList.remove('is-typing');
      box.classList.add('is-done');
    }

    function tick() {
      if (!running) return;

      var elapsed = 0;
      if (useVoice && voice && !voice.paused && voice.currentTime > 0) {
        elapsed = voice.currentTime;
      } else {
        elapsed = (performance.now() - t0) / 1000;
      }

      render(elapsed);

      var totalDur = (useVoice && voice && voice.duration) ? voice.duration : DURATION;
      var isEnded = (useVoice && voice && voice.ended) || (elapsed >= totalDur);

      if (!isEnded) {
        rafId = requestAnimationFrame(tick);
      } else {
        onComplete();
      }
    }

    function playVoice() {
      started = true;
      running = true;
      box.classList.remove('is-done');
      box.classList.add('is-typing');

      if (useVoice && voice) {
        try {
          var p = voice.play();
          if (p !== undefined) {
            p.then(function(){
              updateControlUI(true, 'Đang phát tâm sự Chị Mai...');
              if (rafId) cancelAnimationFrame(rafId);
              rafId = requestAnimationFrame(tick);
            }).catch(function(err){
              console.warn('Mobile autoplay policy prevented sound:', err);
              // Show prompt so user can tap to listen
              updateControlUI(false, '▶ Chạm để nghe Chị Mai tâm sự (51s)');
              // Fallback timer if user prefers reading silently
              t0 = performance.now();
              if (rafId) cancelAnimationFrame(rafId);
              rafId = requestAnimationFrame(tick);
            });
            return;
          }
        } catch (e) {
          console.warn('Audio play error:', e);
        }
      }

      t0 = performance.now();
      if (rafId) cancelAnimationFrame(rafId);
      rafId = requestAnimationFrame(tick);
    }

    function pauseVoice() {
      if (useVoice && voice && !voice.paused) {
        voice.pause();
      }
      running = false;
      updateControlUI(false, '▶ Tiếp tục nghe tâm sự (51s)');
      if (rafId) cancelAnimationFrame(rafId);
    }

    function togglePlayback() {
      if (useVoice && voice) {
        if (voice.paused) {
          playVoice();
        } else {
          pauseVoice();
        }
      } else {
        if (!running) {
          playVoice();
        } else {
          pauseVoice();
        }
      }
    }

    // Toggle button click
    if (vBtn) {
      vBtn.addEventListener('click', function(e){
        e.stopPropagation();
        togglePlayback();
      });
    }

    // Box click triggers or toggles playback
    box.addEventListener('click', function(){
      togglePlayback();
    });

    if (useVoice && voice) {
      voice.addEventListener('ended', onComplete);
      voice.addEventListener('pause', function(){
        if (!voice.ended) {
          updateControlUI(false, '▶ Tiếp tục nghe tâm sự (51s)');
        }
      });
      voice.addEventListener('play', function(){
        updateControlUI(true, 'Đang phát tâm sự Chị Mai...');
      });
    }

    // Global unlock on first touch anywhere (enables audio on iOS & Android)
    function primeAudio() {
      if (!primed && voice) {
        primed = true;
        try {
          voice.load();
        } catch(e){}
      }
      document.removeEventListener('touchend', primeAudio);
      document.removeEventListener('click', primeAudio);
    }
    document.addEventListener('touchend', primeAudio, { passive: true });
    document.addEventListener('click', primeAudio, { passive: true });

    // Check if section is in viewport
    function isSectionInView() {
      var r = box.getBoundingClientRect();
      var vh = window.innerHeight || document.documentElement.clientHeight;
      return (r.top < vh * 0.85 && r.bottom > 60);
    }

    // Mobile scroll gesture trigger: when user swipes down into the section,
    // the touchend event is recognized as a user gesture on iOS Safari & Chrome!
    function onTouchEndScroll() {
      if (!started && isSectionInView()) {
        playVoice();
        window.removeEventListener('touchend', onTouchEndScroll);
      }
    }
    window.addEventListener('touchend', onTouchEndScroll, { passive: true });

    // Desktop IntersectionObserver auto-trigger
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function(entries){
        if (entries[0].isIntersecting && !started) {
          playVoice();
          io.disconnect();
        }
      }, {
        threshold: 0.2,
        rootMargin: '0px 0px -40px 0px'
      });
      io.observe(box);
    } else {
      playVoice();
    }
  } catch (err) {
    console.warn('Typewriter init error:', err);
  }
})();

// 2. MAIN INTERACTIONS
(function(){
  try {
    var fmt = function(n){ return (n || 0).toLocaleString('vi-VN') + 'đ'; };
    var root = document.querySelector('.ltg') || document.body;

    /* Safe Element Reveal */
    function initReveal(){
      var rvs = document.querySelectorAll('.ltg-rv');
      if (!rvs.length) return;

      // Reveal all elements immediately so nothing stays hidden
      rvs.forEach(function(el){ el.classList.add('is-in'); });
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initReveal);
    } else {
      initReveal();
    }

    /* Dung tích sản phẩm nếu có */
    try {
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
    } catch(e){}

    /* Tab Trước / Sau (ltg-ba3 & ltg-ba2) */
    try {
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
    } catch(e){}

    /* Chọn combo đặt hàng */
    try {
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
    } catch(e){}

    /* Form Đặt Hàng AJAX */
    try {
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
    } catch(e){}

    /* Đếm ngược */
    try {
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
    } catch(e){}

    /* Lightbox video / ảnh */
    try {
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
    } catch(e){}

    /* Sticky CTA Bar */
    try {
      var st = document.getElementById('ltgSticky');
      var ord = document.getElementById('dat-hang');
      if (st && ord) {
        function stk(){
          var r = ord.getBoundingClientRect();
          var inForm = r.top < window.innerHeight && r.bottom > 0;
          st.classList.toggle('is-show', window.scrollY > 400 && !inForm);
        }
        window.addEventListener('scroll', stk, { passive: true });
        stk();
      }
    } catch(e){}

    /* FX & Parallax */
    try {
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
    } catch(e){}

  } catch (err) {
    console.warn('Landing script notice:', err);
  }
})();
