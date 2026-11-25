// 1) Stop double clicks: once a form is submitted, lock its buttons.
document.querySelectorAll('form[data-once]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
        if (form.dataset.sent === '1') {
            e.preventDefault();          // second click / Enter key: ignore
            return;
        }
        form.dataset.sent = '1';

        form.querySelectorAll('button[type=submit]').forEach(function (btn) {
            // disable in the next tick so the button's own value is still submitted
            setTimeout(function () {
                btn.disabled = true;
                if (btn.dataset.loading) { btn.textContent = btn.dataset.loading; }
            }, 0);
        });
    });
});

// 2) Browser "Back" restores the page from cache: unlock the forms again
//    and reload protected pages so a logged-out user can't see old data.
window.addEventListener('pageshow', function (e) {
    if (!e.persisted) { return; }

    if (document.body.hasAttribute('data-protected')) {
        window.location.reload();
        return;
    }
    document.querySelectorAll('form[data-once]').forEach(function (form) {
        form.dataset.sent = '0';
    });
    document.querySelectorAll('button[type=submit]').forEach(function (btn) {
        if (!document.getElementById('lock-notice')) { btn.disabled = false; }
    });
});

// 3) Login lock countdown: re-enable the button when the lock is over.
(function () {
    var box = document.getElementById('lock-notice');
    if (!box) { return; }

    var left = parseInt(box.dataset.seconds, 10);
    var timer = document.getElementById('lock-timer');
    var btn = document.getElementById('login-btn');

    var tick = setInterval(function () {
        left -= 1;
        if (left <= 0) {
            clearInterval(tick);
            box.remove();
            if (btn) { btn.disabled = false; }
            return;
        }
        timer.textContent = left;
    }, 1000);
})();
