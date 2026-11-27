/* ============================================================
   ChordVerse — Interaksi Frontend
   Bagian: UI/UX, Layout & Responsive Design (Alfian)
   ------------------------------------------------------------
   Berisi interaksi kecil yang dipakai bersama oleh semua
   halaman: bayangan header, toast, copy chord, toggle password,
   pratinjau gambar, dan penutup pesan.
   ============================================================ */
(function () {
    'use strict';

    /* ---------- Header: bayangan saat digulir ---------- */
    function initHeader() {
        var header = document.getElementById('cvHeader');
        if (!header) {
            return;
        }

        var update = function () {
            header.classList.toggle('is-scrolled', window.scrollY > 8);
        };

        update();
        window.addEventListener('scroll', update, { passive: true });
    }

    /* ---------- Toast ---------- */
    var toastEl = null;
    var toastTimer = null;

    function showToast(message, type) {
        if (!toastEl) {
            toastEl = document.createElement('div');
            toastEl.className = 'cv-toast';
            toastEl.setAttribute('role', 'status');
            toastEl.setAttribute('aria-live', 'polite');
            toastEl.innerHTML =
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" ' +
                'stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' +
                '<path d="m5 13 4 4L19 7"/></svg><span></span>';
            document.body.appendChild(toastEl);
        }

        toastEl.classList.toggle('is-error', type === 'error');
        toastEl.lastElementChild.textContent = message;
        toastEl.classList.add('is-visible');

        window.clearTimeout(toastTimer);
        toastTimer = window.setTimeout(function () {
            toastEl.classList.remove('is-visible');
        }, 2600);
    }

    /* ---------- Copy chord ---------- */
    function fallbackCopy(text) {
        var area = document.createElement('textarea');
        area.value = text;
        area.setAttribute('readonly', '');
        area.style.position = 'fixed';
        area.style.top = '-1000px';
        document.body.appendChild(area);
        area.select();

        var copied = false;
        try {
            copied = document.execCommand('copy');
        } catch (error) {
            copied = false;
        }

        document.body.removeChild(area);
        return copied;
    }

    function copyText(text) {
        return new Promise(function (resolve, reject) {
            // navigator.clipboard hanya aktif pada HTTPS atau localhost,
            // sedangkan chordverse.test berjalan di HTTP biasa.
            if (window.isSecureContext && navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(resolve).catch(function () {
                    fallbackCopy(text) ? resolve() : reject();
                });
                return;
            }

            fallbackCopy(text) ? resolve() : reject();
        });
    }

    function copyChord() {
        var source = document.getElementById('chordText');
        if (!source) {
            return;
        }

        var button = document.getElementById('copyBtn');
        var label = button ? button.querySelector('[data-copy-label]') : null;
        var originalLabel = label ? label.textContent : 'Copy Chord';

        copyText(source.innerText).then(function () {
            if (button) {
                button.classList.add('is-copied');
                if (label) {
                    label.textContent = 'Tersalin!';
                } else {
                    button.innerText = 'Tersalin!';
                }
            }

            showToast('Chord berhasil disalin.');

            window.setTimeout(function () {
                if (!button) {
                    return;
                }
                button.classList.remove('is-copied');
                if (label) {
                    label.textContent = originalLabel;
                } else {
                    button.innerText = originalLabel;
                }
            }, 2000);
        }).catch(function () {
            showToast('Chord gagal disalin. Blok teks chord lalu salin manual.', 'error');
        });
    }

    window.copyChord = copyChord;

    /* ---------- Toggle password ---------- */
    function initPasswordToggles() {
        document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
            button.addEventListener('click', function () {
                var target = document.getElementById(button.getAttribute('data-toggle-password'));
                if (!target) {
                    return;
                }

                var show = target.type === 'password';
                target.type = show ? 'text' : 'password';
                button.setAttribute('aria-pressed', show ? 'true' : 'false');
                button.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
            });
        });
    }

    /* ---------- Pratinjau gambar sebelum upload ---------- */
    function initImagePreviews() {
        document.querySelectorAll('[data-preview-target]').forEach(function (input) {
            input.addEventListener('change', function () {
                var image = document.querySelector(input.getAttribute('data-preview-target'));
                if (!image || !input.files || !input.files[0]) {
                    return;
                }

                var objectUrl = URL.createObjectURL(input.files[0]);
                image.src = objectUrl;
                image.addEventListener('load', function () {
                    URL.revokeObjectURL(objectUrl);
                }, { once: true });
            });
        });
    }

    /* ---------- Tutup pesan ---------- */
    function initAlertDismiss() {
        document.querySelectorAll('[data-dismiss-alert]').forEach(function (button) {
            button.addEventListener('click', function () {
                var alert = button.closest('.cv-alert');
                if (alert) {
                    alert.remove();
                }
            });
        });
    }

    /* ---------- Inisialisasi ---------- */
    function init() {
        initHeader();
        initPasswordToggles();
        initImagePreviews();
        initAlertDismiss();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
