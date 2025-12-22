/**
 * CULINAIRE PERFORMANCE CORE & HEAT MANAGEMENT SYSTEM
 * ----------------------------------------------------
 * PERMANENT COOLING MODE ENABLED
 * 
 * As requested, this script now forces the site into "Cooling Mode" permanently.
 * - Animations Checked & Disabled.
 * - Videos Paused by default.
 * - Background downloads throttled.
 * 
 * This ensures maximum lightness and minimum temperature for all devices.
 */

window.CulinaireOptimizer = (function () {
    // Configuration
    const CONFIG = {
        batchSize: 2, // Conservative batch size
        idleTimeout: 1000
    };

    // State
    let loadQueue = [];
    let isProcessingQueue = false;

    // --- 1. PERMANENT COOLING ENFORCEMENT ---
    function enforceCoolingMode() {
        console.log("❄️ PERMANENT COOLING MODE ACTIVED.");
        document.body.classList.add('cooling-mode-active');

        // 1. Force Disable Animations via CSS Variable Injection
        // This is cleaner than !important on every element
        document.documentElement.style.setProperty('--animation-speed', '0s');

        // 2. Inject global style to kill all movement if CSS vars aren't enough
        const style = document.createElement('style');
        style.id = 'cooling-mode-styles';
        style.textContent = `
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
            video {
                display: none !important; /* Optional: Hide videos or just pause? Pause is safer for layout. */
            }
            .video-bg-container video {
                display: none !important; /* Hide heavy backgrounds */
            }
        `;
        document.head.appendChild(style);

        // 3. Pause all videos
        pauseAllVideos();
    }

    function pauseAllVideos() {
        const videos = document.querySelectorAll('video');
        videos.forEach(v => {
            v.pause();
            v.removeAttribute('autoplay');
        });
    }

    // --- 2. SMART PRELOADER (THROTTLED) ---
    function queueAsset(url) {
        loadQueue.push(url);
        processQueue();
    }

    function processQueue() {
        if (isProcessingQueue || loadQueue.length === 0) return;

        // Always throttle
        if ('requestIdleCallback' in window) {
            requestIdleCallback(downloadNextBatch, { timeout: 2000 });
        } else {
            setTimeout(downloadNextBatch, 2000);
        }
    }

    function downloadNextBatch() {
        isProcessingQueue = true;
        const batch = loadQueue.splice(0, CONFIG.batchSize);

        const promises = batch.map(url => {
            return new Promise((resolve) => {
                const img = new Image();
                img.onload = resolve;
                img.onerror = resolve;
                img.src = url;
            });
        });

        Promise.all(promises).then(() => {
            isProcessingQueue = false;
            // Add slight delay between batches to let CPU rest
            setTimeout(() => {
                if (loadQueue.length > 0) processQueue();
            }, 1000);
        });
    }

    // --- 3. INITIALIZATION ---
    function init() {
        enforceCoolingMode();

        // Watch for new videos added to DOM (e.g. via navigation) and kill them
        const observer = new MutationObserver((mutations) => {
            pauseAllVideos();
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }

    return {
        init,
        preload: queueAsset
    };

})();

// Auto-start
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', window.CulinaireOptimizer.init);
} else {
    window.CulinaireOptimizer.init();
}
