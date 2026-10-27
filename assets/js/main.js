
  (function(){
    var DURATION=51; /* giây – gõ hết đoạn chính + câu chốt trong đúng 51 giây */
    var box=document.getElementById('ltgType'),outB=document.getElementById('ltgTypeBody'),outH=document.getElementById('ltgTypeHl'),
        voice=document.getElementById('ltgTypeVoice'),ghosts=box.querySelectorAll('.ltg-type-ghost');
    /* tách theo ký tự hiển thị (giữ nguyên dấu tiếng Việt) */
    function split(s){s=s.replace(/[ \t\r]+/g,' ').replace(/ *\n */g,'\n').replace(/\n{3,}/g,'\n\n').trim();return window.Intl&&Intl.Segmenter?Array.from(new Intl.Segmenter('vi',{granularity:'grapheme'}).segment(s),function(x){return x.segment}):Array.from(s)}
    var cb=split(ghosts[0].textContent),ch=split(ghosts[1].textContent),NB=cb.length,N=NB+ch.length;
    var caret=document.createElement('span');caret.className='ltg-type-caret';caret.setAttribute('aria-hidden','true');
    var t0=0,raf=0,shown=-1,running=false,useVoice=false;
    function render(el){
      var k=Math.min(N,Math.floor(el/DURATION*N));if(k===shown)return;shown=k;
      outB.textContent=cb.slice(0,Math.min(k,NB)).join('');
      outH.textContent=ch.slice(0,Math.max(0,k-NB)).join('');
      (k<NB?outB:outH).appendChild(caret);
    }
    function frame(){
      var el=useVoice?voice.currentTime:(performance.now()-t0)/1000;
      render(el);
      if(el<DURATION&&!(useVoice&&voice.ended)){raf=requestAnimationFrame(frame)}else{render(DURATION);running=false;box.classList.add('is-done')}
    }
    function start(){
      cancelAnimationFrame(raf);shown=-1;running=true;box.classList.remove('is-done');box.classList.add('is-typing');
      useVoice=!!voice.getAttribute('src');
      if(useVoice){voice.currentTime=0;var pr=voice.play();if(pr&&pr.catch)pr.catch(function(){useVoice=false;t0=performance.now()})}
      t0=performance.now();raf=requestAnimationFrame(frame);
    }
    /* bấm vào khung để phát lại (kèm voice nếu có) */
    box.addEventListener('click',function(){if(!running)start()});
    if('IntersectionObserver' in window){
      var io=new IntersectionObserver(function(es){if(es[0].isIntersecting&&!running&&shown<0){start();io.disconnect()}},{threshold:.4});io.observe(box);
    }else start();
  })();
  


(function(){
  var fmt=function(n){return n.toLocaleString('vi-VN')+'đ'};
  var root=document.querySelector('.ltg');
  function getRow(k){return root.querySelector('[data-row="'+k+'"]')}
  function setChk(k,v){getRow(k).querySelector('input[type=checkbox]').checked=v}

  /* Chọn dung tích */
  root.querySelectorAll('[data-card]').forEach(function(card){
    card.querySelectorAll('.ltg-size').forEach(function(b,i){
      b.addEventListener('click',function(){
        card.querySelectorAll('.ltg-size').forEach(function(x){x.classList.remove('is-on')});
        b.classList.add('is-on');
        card.querySelector('[data-out]').firstChild.nodeValue=fmt(+b.dataset.price);
        card.dataset.idx=i;
      });
    });
  });

  /* Tab Trước/Sau */
  root.querySelectorAll('.ltg-ba2-tab').forEach(function(t){t.addEventListener('click',function(){
    root.querySelectorAll('.ltg-ba2-tab').forEach(function(x){x.classList.toggle('is-on',x===t)});
    root.querySelectorAll('.ltg-ba2-p').forEach(function(p){p.classList.toggle('is-on',p.dataset.bap===t.dataset.ba)});
  })});

  /* Chọn combo */
  var copts=root.querySelectorAll('.ltg-copt input[type=radio]'),cbox=document.getElementById('ltgCombo');
  var wrap=document.getElementById('ltgWrap'),msg=document.getElementById('ltgMsg');
  function syncC(){root.querySelectorAll('.ltg-copt input').forEach(function(r){r.closest('.ltg-copt').classList.toggle('is-on',r.checked)});cbox.classList.remove('is-err')}
  root.querySelectorAll('.ltg-copt input').forEach(function(r){r.addEventListener('change',syncC)});
  root.querySelectorAll('[data-combo]').forEach(function(a){a.addEventListener('click',function(){
    var r=root.querySelector('.ltg-copt input[value="'+a.dataset.combo+'"]');if(r){r.checked=true;syncC()}
  })});
  /* Nút "Chọn set này" ở phần quà 20/11 */
  root.querySelectorAll('[data-set]').forEach(function(a){a.addEventListener('click',function(){
    wrap.checked=true;msg.style.display='block';
  })});
  wrap.addEventListener('change',function(){msg.style.display=this.checked?'block':'none'});

  document.getElementById('ltgForm').addEventListener('submit',function(e){
    e.preventDefault();
    var f=this,ok=true,c=root.querySelector('.ltg-copt input[type=radio]:checked');
    ['name','phone','address'].forEach(function(n){var el=f.elements[n];if(!el.value.trim()){el.style.borderColor='#b8412b';ok=false}else el.style.borderColor=''});
    if(!/^0\d{9}$/.test(f.elements.phone.value.replace(/[\s.]/g,''))){f.elements.phone.style.borderColor='#b8412b';ok=false}
    if(!c){cbox.classList.add('is-err');ok=false}
    if(!ok)return;
    var data={name:f.elements.name.value,phone:f.elements.phone.value,address:f.elements.address.value,
      combo:c.closest('.ltg-copt').textContent.trim(),giftwrap:wrap.checked?'Có':'Không',card:f.elements.card.value};
    /* TODO: gửi data về Google Sheet / CRM, VD:
       fetch('https://script.google.com/macros/s/XXXX/exec',{method:'POST',mode:'no-cors',body:JSON.stringify(data)}); */
    console.log('Đơn hàng:',data);
    document.getElementById('ltgFormBody').style.display='none';
    document.getElementById('ltgOk').style.display='block';
  });

  /* Đếm ngược: 20/11 (phần quà) + cuối ngày (topbar, form) */
  var cd=document.getElementById('ltgCount'),top=document.getElementById('ltgTop'),fcd=document.getElementById('ltgFormCd');
  var p=function(n){return String(Math.floor(n)).padStart(2,'0')};
  function tick(){
    var now=new Date(),y=now.getFullYear(),end=new Date(y,10,20);
    if(now>end)end=new Date(y+1,10,20);
    var d=Math.max(0,end-now)/1000;
    cd.querySelector('[data-d]').textContent=p(d/86400);
    cd.querySelector('[data-h]').textContent=p(d%86400/3600);
    cd.querySelector('[data-m]').textContent=p(d%3600/60);
    cd.querySelector('[data-s]').textContent=p(d%60);
    var eod=new Date(now.getFullYear(),now.getMonth(),now.getDate()+1),r=(eod-now)/1000;
    top.textContent=p(r/3600)+':'+p(r%3600/60)+':'+p(r%60);
    fcd.querySelector('[data-h]').textContent=p(r/3600);
    fcd.querySelector('[data-m]').textContent=p(r%3600/60);
    fcd.querySelector('[data-s]').textContent=p(r%60);
  }
  tick();setInterval(tick,1000);

  /* Lightbox video / ảnh */
  var lb=document.getElementById('ltgLb'),box=document.getElementById('ltgLbBox');
  function embed(u){
    var m;
    if(m=u.match(/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([\w-]{6,})/))return '<iframe src="https://www.youtube.com/embed/'+m[1]+'?autoplay=1&rel=0" allow="autoplay;encrypted-media;fullscreen" allowfullscreen></iframe>';
    if(m=u.match(/tiktok\.com\/.*\/video\/(\d+)/))return '<iframe src="https://www.tiktok.com/embed/v2/'+m[1]+'" allow="autoplay;encrypted-media;fullscreen" allowfullscreen></iframe>';
    if(/facebook\.com|fb\.watch/.test(u))return '<iframe src="https://www.facebook.com/plugins/video.php?href='+encodeURIComponent(u)+'&show_text=false&autoplay=1" allow="autoplay;encrypted-media;fullscreen" allowfullscreen></iframe>';
    if(/\.(mp4|webm)(\?|$)/i.test(u))return '<video src="'+u+'" controls autoplay playsinline></video>';
    return '<iframe src="'+u+'" allowfullscreen></iframe>';
  }
  function openLb(html,cls){box.className='ltg-lb-box '+(cls||'');box.innerHTML=html;lb.classList.add('is-open');document.body.style.overflow='hidden'}
  function closeLb(){lb.classList.remove('is-open');box.innerHTML='';document.body.style.overflow=''}
  root.querySelectorAll('[data-video]').forEach(function(el){
    function go(){
      var u=el.dataset.video.trim(),v=el.dataset.vertical?'is-v':'';
      openLb(u?embed(u):'<div class="ltg-lb-empty">🎬 Video đang được cập nhật.<br>Vui lòng quay lại sau hoặc gọi hotline 0962 131 515.</div>',v);
    }
    el.addEventListener('click',go);
    el.addEventListener('keydown',function(e){if(e.key==='Enter')go()});
  });
  root.querySelectorAll('[data-img]').forEach(function(el){
    el.addEventListener('click',function(){openLb('<img src="'+el.dataset.img+'" alt="">','is-img')});
  });
  lb.addEventListener('click',function(e){if(e.target===lb||e.target.classList.contains('ltg-lb-x'))closeLb()});
  document.addEventListener('keydown',function(e){if(e.key==='Escape')closeLb()});

  var st=document.getElementById('ltgSticky'),ord=document.getElementById('dat-hang');
  function stk(){var r=ord.getBoundingClientRect(),inForm=r.top<window.innerHeight&&r.bottom>0;st.classList.toggle('is-show',window.scrollY>560&&!inForm)}
  window.addEventListener('scroll',stk,{passive:true});stk();


  /* ===== FX ===== */
  var reduce=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var prog=document.getElementById('ltgProg'),nav=root.querySelector('.ltg-nav'),deco=document.getElementById('ltgDeco'),ticking=false;
  function onScroll(){
    var h=document.documentElement,max=h.scrollHeight-h.clientHeight,y=window.scrollY;
    prog.style.transform='scaleX('+(max>0?y/max:0)+')';
    nav.classList.toggle('is-scrolled',y>20);
    if(!reduce&&deco&&y<1200)deco.style.transform='translateY('+(y*0.18)+'px)';
    ticking=false;
  }
  window.addEventListener('scroll',function(){if(!ticking){ticking=true;requestAnimationFrame(onScroll)}},{passive:true});onScroll();

  /* Reveal variants + stagger */
  root.querySelectorAll('.ltg-feat-img,.ltg-ing-photo,.ltg-vlong,.ltg-combo').forEach(function(el){el.classList.add('ltg-z')});
  root.querySelectorAll('.ltg-feat:not(.ltg-feat--rev) .ltg-feat-img + div,.ltg-story-imgs').forEach(function(el){el.classList.add('ltg-l')});
  root.querySelectorAll('.ltg-feat--rev .ltg-feat-img + div,.ltg-hero-img').forEach(function(el){el.classList.add('ltg-r')});
  ['.ltg-pain-grid','.ltg-pks','.ltg-sets','.ltg-rev-grid','.ltg-steps','.ltg-ing-grid','.ltg-flow','.ltg-shots','.ltg-gift-perks','.ltg-proof-grid','.ltg-ba','.ltg-stats','.ltg-trust .ltg-wrap'].forEach(function(sel){
    root.querySelectorAll(sel).forEach(function(g){
      var i=0;Array.prototype.forEach.call(g.children,function(c){if(c.classList.contains('ltg-rv')){c.style.transitionDelay=(i%4)*110+'ms';i++}});
    });
  });

  /* Counters */
  var cio='IntersectionObserver' in window?new IntersectionObserver(function(es){es.forEach(function(e){
    if(!e.isIntersecting)return;cio.unobserve(e.target);
    var el=e.target,to=+el.dataset.count,suf=el.dataset.suffix||'',from=to>1000?1990:0,t0=null;
    if(reduce){return}
    function step(ts){if(!t0)t0=ts;var k=Math.min(1,(ts-t0)/1400),v=Math.round(from+(to-from)*(1-Math.pow(1-k,3)));el.textContent=v+suf;if(k<1)requestAnimationFrame(step)}
    requestAnimationFrame(step);
  })},{threshold:.6}):null;
  if(cio)root.querySelectorAll('[data-count]').forEach(function(el){cio.observe(el)});

  /* Desktop: mouse glow + 3D tilt */
  if(!reduce&&window.matchMedia('(hover:hover) and (min-width:981px)').matches){
    var hero=root.querySelector('.ltg-hero');
    hero.addEventListener('mousemove',function(e){var r=hero.getBoundingClientRect();hero.style.setProperty('--mx',(e.clientX-r.left)+'px');hero.style.setProperty('--my',(e.clientY-r.top)+'px')});
    root.querySelectorAll('.ltg-hero-img,.ltg-feat-img,.ltg-combo-pair img,.ltg-set-img').forEach(function(el){
      el.classList.add('ltg-tilt');
      el.addEventListener('mousemove',function(e){var r=el.getBoundingClientRect(),x=(e.clientX-r.left)/r.width-.5,y=(e.clientY-r.top)/r.height-.5;el.style.transform='perspective(900px) rotateY('+(x*8)+'deg) rotateX('+(-y*8)+'deg)'});
      el.addEventListener('mouseleave',function(){el.style.transform=''});
    });
  }

  if('IntersectionObserver' in window){
    var io=new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting){e.target.classList.add('is-in');io.unobserve(e.target)}})},{threshold:.1});
    root.querySelectorAll('.ltg-rv').forEach(function(el){io.observe(el)});
  }else root.querySelectorAll('.ltg-rv').forEach(function(el){el.classList.add('is-in')});
})();
