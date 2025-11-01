document.addEventListener('DOMContentLoaded', () => {
  const btn = document.querySelector('.btn-danger');
  btn.addEventListener('click', () => {
    btn.classList.add('active');
    setTimeout(() => btn.classList.remove('active'), 300);
  });
});
