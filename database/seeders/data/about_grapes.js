(function () {
  if (window.__execAboutBoot) return;
  window.__execAboutBoot = true;

  var root = document.getElementById("wsi-about-cms");
  if (!root) return;

  if (!("IntersectionObserver" in window)) {
    root.querySelectorAll(".exec-reveal").forEach(function (el) {
      el.classList.add("is-in");
    });
    return;
  }

  document.documentElement.classList.add("exec-anim-armed");
  var io = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-in");
          io.unobserve(entry.target);
        }
      });
    },
    { rootMargin: "0px 0px -8% 0px", threshold: 0.08 }
  );
  root.querySelectorAll(".exec-reveal").forEach(function (el) {
    io.observe(el);
  });
})();
