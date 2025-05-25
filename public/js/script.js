const openBtns  = document.querySelectorAll('.delete-btn');
const closeBtns = document.querySelectorAll('.close-del-btn');

function showModal(modal) {
  modal.classList.remove('hidden');
}
function hideModal(modal) {
  modal.classList.add('hidden');
}

openBtns.forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    const modal = btn.closest('header').querySelector('.delete-modal');
    if (modal) showModal(modal);
  });
});

closeBtns.forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    const modal = btn.closest('.delete-modal');
    if (modal) hideModal(modal);
  });
});

document.querySelectorAll('.delete-modal').forEach(modal => {
  modal.addEventListener('click', e => {
    if (e.target === modal) hideModal(modal);
  });
});