<div id="appDialogOverlay" class="app-dialog-overlay" aria-hidden="true">
    <div class="app-dialog" role="dialog" aria-modal="true" aria-labelledby="appDialogTitle">
        <div class="app-dialog-header">
            <h3 id="appDialogTitle">Dialog</h3>
            <button type="button" class="app-dialog-close" id="appDialogClose" aria-label="Close dialog">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="app-dialog-body" id="appDialogBody"></div>
    </div>
</div>

<style>
    .app-dialog-overlay {
        position: fixed;
        inset: 0;
        background: rgba(10, 18, 41, 0.55);
        z-index: 1200;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .app-dialog-overlay.active {
        display: flex;
    }

    .app-dialog {
        width: min(760px, 100%);
        max-height: calc(100vh - 48px);
        overflow: hidden;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 24px 60px rgba(26, 35, 126, 0.22);
        border: 1px solid rgba(122, 134, 173, 0.25);
        display: flex;
        flex-direction: column;
    }

    .app-dialog-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 18px;
        border-bottom: 1px solid #edf1fb;
    }

    .app-dialog-header h3 {
        margin: 0;
        font-size: 18px;
        color: #1a237e;
    }

    .app-dialog-close {
        width: 34px;
        height: 34px;
        border: 1px solid #d8deef;
        border-radius: 8px;
        background: #fff;
        color: #7a86ad;
        cursor: pointer;
    }

    .app-dialog-close:hover {
        color: #1a237e;
        border-color: #1a237e;
    }

    .app-dialog-body {
        overflow: auto;
        padding: 16px 18px 18px;
        color: #1f2a44;
        font-size: 13px;
        line-height: 1.65;
    }

    .app-dialog-section {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #edf1fb;
    }

    .app-dialog-section:first-child {
        margin-top: 0;
        padding-top: 0;
        border-top: 0;
    }

    .app-dialog-section-title {
        margin-bottom: 8px;
        font-size: 12px;
        letter-spacing: 0.04em;
        font-weight: 700;
        color: #1a237e;
    }

    .app-dialog-row {
        margin-bottom: 4px;
        color: #26314d;
    }

    .app-dialog-row code {
        background: #f2f5ff;
        border: 1px solid #dde5ff;
        border-radius: 6px;
        padding: 1px 5px;
        color: #1a237e;
    }

    .app-dialog-pill {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 999px;
        background: #e8f1ff;
        color: #0f4aa2;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }
</style>

<script>
    (function () {
        const overlay = document.getElementById('appDialogOverlay');
        const titleEl = document.getElementById('appDialogTitle');
        const bodyEl = document.getElementById('appDialogBody');
        const closeBtn = document.getElementById('appDialogClose');

        if (!overlay || !titleEl || !bodyEl || !closeBtn) {
            return;
        }

        function closeDialog() {
            overlay.classList.remove('active');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        function openDialog(options) {
            const config = options || {};
            titleEl.textContent = config.title || 'Dialog';
            bodyEl.innerHTML = config.html || '';

            if (config.width) {
                overlay.querySelector('.app-dialog').style.width = config.width;
            } else {
                overlay.querySelector('.app-dialog').style.width = '';
            }

            overlay.classList.add('active');
            overlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        closeBtn.addEventListener('click', closeDialog);

        overlay.addEventListener('click', function (event) {
            if (event.target === overlay) {
                closeDialog();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && overlay.classList.contains('active')) {
                closeDialog();
            }
        });

        window.AppDialog = {
            open: openDialog,
            close: closeDialog
        };
    })();
</script>
