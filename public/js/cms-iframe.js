/**
 * CMS Iframe Script (Child)
 * Injected into the public site when cms_mode=true
 */

console.log('CMS Iframe Script Loaded');

(function () {
    // Notify Parent we are ready
    window.parent.postMessage({ type: 'cms_handshake' }, '*');

    // Notify Parent about URL changes
    window.parent.postMessage({ type: 'cms_url_changed', url: window.location.href }, '*');

    // Add Styles for Editable Elements
    const style = document.createElement('style');
    style.textContent = `
        [data-cms-key] {
            cursor: pointer !important;
            transition: outline 0.2s ease;
            position: relative;
        }
        [data-cms-key]:hover {
            outline: 2px solid #0d6efd;
            z-index: 1000;
        }
        [data-cms-key]::after {
            content: 'EDIT';
            position: absolute;
            top: -20px;
            left: 0;
            background: #0d6efd;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
            z-index: 1001;
        }
        [data-cms-key]:hover::after {
            opacity: 1;
        }
        /* Flash animation for save success */
        @keyframes cms-flash-success {
            0% { background-color: rgba(25, 135, 84, 0.5); }
            100% { background-color: transparent; }
        }
        .cms-save-success {
            animation: cms-flash-success 1s ease-out;
        }
    `;
    document.head.appendChild(style);

    // Click Handler interrogation
    document.addEventListener('click', function (e) {
        // Find nearest editable element
        const target = e.target.closest('[data-cms-key]');

        if (target) {
            e.preventDefault();
            e.stopPropagation();

            // Send details to parent
            const key = target.getAttribute('data-cms-key');
            const type = target.getAttribute('data-cms-type') || 'text';
            let content = '';

            if (type === 'image') {
                content = target.getAttribute('src');
            } else {
                content = target.innerHTML; // Or innerText depending on need
            }

            window.parent.postMessage({
                type: 'cms_element_selected',
                payload: {
                    key: key,
                    type: type,
                    content: content
                }
            }, '*');

            // Visual feedback
            document.querySelectorAll('[data-cms-key]').forEach(el => el.style.outline = '');
            target.style.outline = '4px solid #0d6efd';
        }
    }, true); // Capture phase

    // Message Listener from Parent
    window.addEventListener('message', function (event) {
        const data = event.data;

        if (data.type === 'cms_update_preview') {
            const elements = document.querySelectorAll(`[data-cms-key="${data.key}"]`);
            elements.forEach(el => {
                const type = el.getAttribute('data-cms-type');
                if (type === 'image') {
                    el.src = data.content;
                } else {
                    el.innerHTML = data.content;
                }
            });
        }

        if (data.type === 'cms_save_success') {
            const elements = document.querySelectorAll(`[data-cms-key="${data.key}"]`);
            elements.forEach(el => {
                el.classList.add('cms-save-success');
                setTimeout(() => el.classList.remove('cms-save-success'), 1000);
            });
        }
    });

    // Helper: Persist cms_mode on navigation
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('a').forEach(link => {
            // Only internal links
            if (link.host === window.location.host) {
                try {
                    const url = new URL(link.href);
                    url.searchParams.set('cms_mode', 'true');
                    link.href = url.toString();
                } catch (e) {
                    // Ignore invalid URLs
                }
            }
        });
    });

})();
