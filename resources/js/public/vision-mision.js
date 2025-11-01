// Podrías usar animaciones personalizadas o efectos scroll
document.addEventListener('scroll', () => {
  const cards = document.querySelectorAll('#vision-mision .card');
  cards.forEach(card => {
    const rect = card.getBoundingClientRect();
    if (rect.top < window.innerHeight - 100) {
      card.classList.add('animate__fadeInUp');
    }
  });
});
