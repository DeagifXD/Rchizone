document.addEventListener('DOMContentLoaded', function () {
    const coverModal = document.getElementById('coverModal');
    const modalImg = document.getElementById('modalImg');
    const modalClose = document.querySelector('.modal-close');

    document.addEventListener('click', function (e) {
        const target = e.target;

        if (target.dataset.preview) {
            openModal(target.dataset.preview);
            return;
        }

        if (target.tagName === 'IMG' && target.closest('.post_container')) {
            openModal(target.src);
            return;
        }
    });

    function openModal(src) {
        modalImg.src = src;
        coverModal.classList.add('show');
    }

    function closeModal() {
        coverModal.classList.remove('show');
    }

    modalClose.addEventListener('click', closeModal);

    coverModal.addEventListener('click', function (e) {
        if (e.target === coverModal) {
            closeModal();
        }
    });
});