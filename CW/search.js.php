<?php header("Content-Type: application/javascript"); ?>
function toggleSearch() {
  const input = document.getElementById('searchInput');
  input.classList.toggle('hidden');
  if (!input.classList.contains('hidden')) {
    input.focus();
  }
}

function smartFilter() {
  const input = document.getElementById('searchInput');
  const filter = input.value.toLowerCase();

  if (document.querySelector('.question-card')) {
    document.querySelectorAll('.question-card').forEach(box => {
      const text = box.textContent.toLowerCase();
      box.style.display = text.includes(filter) ? '' : 'none';
    });
  } else if (document.querySelector('.user-card')) {
    document.querySelectorAll('.user-card').forEach(box => {
      const text = box.textContent.toLowerCase();
      box.style.display = text.includes(filter) ? '' : 'none';
    });
  } else if (document.querySelector('.module-box')) {
    document.querySelectorAll('.module-box').forEach(box => {
      const text = box.textContent.toLowerCase();
      box.style.display = text.includes(filter) ? '' : 'none';
    });
  }
}
