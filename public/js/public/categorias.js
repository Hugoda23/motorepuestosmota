document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.main-cat').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.subcats').forEach(el => el.classList.add('d-none'));
      const target = document.querySelector(btn.dataset.target);
      if (target) target.classList.remove('d-none');
    });
  });
});
