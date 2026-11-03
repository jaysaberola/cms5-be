(function () {
  if (window.__execTplBoot) return;
  window.__execTplBoot = true;

  function qs(sel, root) {
    return (root || document).querySelector(sel);
  }
  function qsa(sel, root) {
    return Array.from((root || document).querySelectorAll(sel));
  }

  function initApproachTabs(root) {
    var tabs = qsa('[data-exec-approach-tab]', root);
    if (!tabs.length) return;
    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        tabs.forEach(function (t) { t.classList.remove('is-active'); });
        tab.classList.add('is-active');
      });
    });
    tabs[0].classList.add('is-active');
  }

  function initServiceTabs(root) {
    var pills = qsa('[data-exec-service-tab]', root);
    var panels = qsa('[data-exec-service-panel]', root);
    if (!pills.length || !panels.length) return;
    function show(id) {
      pills.forEach(function (p) {
        p.classList.toggle('is-active', p.getAttribute('data-exec-service-tab') === id);
      });
      panels.forEach(function (panel) {
        panel.classList.toggle('is-active', panel.getAttribute('data-exec-service-panel') === id);
      });
    }
    pills.forEach(function (pill) {
      pill.addEventListener('click', function () {
        show(pill.getAttribute('data-exec-service-tab'));
      });
    });
    show(pills[0].getAttribute('data-exec-service-tab'));
  }

  function initCarousel(root) {
    var track = qs('[data-exec-carousel-track]', root);
    var slides = qsa('[data-exec-carousel-slide]', root);
    var prev = qs('[data-exec-carousel-prev]', root);
    var next = qs('[data-exec-carousel-next]', root);
    if (!track || slides.length < 2) return;
    var index = 0;
    function go(i) {
      index = (i + slides.length) % slides.length;
      track.style.transform = 'translateX(' + (-index * 100) + '%)';
    }
    if (prev) prev.addEventListener('click', function () { go(index - 1); });
    if (next) next.addEventListener('click', function () { go(index + 1); });
    var timer = setInterval(function () { go(index + 1); }, 7000);
    root.addEventListener('mouseenter', function () { clearInterval(timer); });
  }

  function initReveal(root) {
    var nodes = qsa('.exec-reveal', root);
    if (!nodes.length) return;
    if (!('IntersectionObserver' in window)) {
      nodes.forEach(function (n) { n.classList.add('is-in'); });
      return;
    }
    var io = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        e.target.classList.add('is-in');
        obs.unobserve(e.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
    nodes.forEach(function (n) { io.observe(n); });
  }

  function boot() {
    var root = qs('#wsi-home-cms') || document;
    initApproachTabs(root);
    initServiceTabs(root);
    initCarousel(root);
    initReveal(root);
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
  else boot();
})();
