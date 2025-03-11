
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('custom-confirm');
    const confirmMessage = document.getElementById('confirm-message');
    const confirmYes = document.getElementById('confirm-yes');
    const confirmNo = document.getElementById('confirm-no');

    //invoke custom confirm dialog
    window.showConfirmation = function (message, onConfirm) {
        confirmMessage.textContent = message;

        //show dialog
        modal.style.display = 'flex';

        //yes
        confirmYes.onclick = function () {
            modal.style.display = 'none';
            if (typeof onConfirm === 'function') onConfirm();
        };

        //no
        confirmNo.onclick = function () {
            modal.style.display = 'none';
        };
    };
});
