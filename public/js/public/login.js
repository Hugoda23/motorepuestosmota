document.addEventListener('DOMContentLoaded', () => {
  const mapa = document.querySelector('.map-wrapper');
  const observer = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) mapa.classList.add('animate__zoomIn');
      });
    },
    { threshold: 0.3 }
  );
  if (mapa) observer.observe(mapa);
});
