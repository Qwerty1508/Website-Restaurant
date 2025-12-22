/**
 * CULINAIRE PERFORMANCE CORE & HEAT MANAGEMENT SYSTEM
 * ----------------------------------------------------
 * "INVISIBLE COOLING" MODE
 * 
 * Strategy:
 * 1. VISUALS: UNTOUCHED. Animations & Videos run at MAXIMUM quality/speed.
 * 2. COOLING: Achieved by aggressively throttling BACKGROUND tasks only.
 * 
 * This ensures the device feels fast and premium, while the "heavy lifting" 
 * of downloading future assets happens slowly and efficiently in the background,
 * preventing CPU spikes (Heat).
 */

window.CulinaireOptimizer = (function () {
    // Configuration
    const CONFIG = {
        batchSize: 1, // Ultra-conservative: Only 1 fetch at a time (Keeps CPU cool)
        idleTimeout: 3000,
        enableVisuals: true // STRICTLY TRUE: Do not touch animations
    };

    // State
    let loadQueue = [];
    let isProcessingQueue = false;

    // --- 1. INVISIBLE COOLING ENFORCEMENT ---
    function enforceCoolingMode() {
        console.log("❄️ BACKGROUND COOLING SYSTEM ACTIVE. Visuals: MAX.");

        // We do NOT add the 'drying/static' CSS classes.
        // We do NOT pause videos.

        // Instead, we just ensure the background process knows to take it easy.
        document.body.classList.add('background-cooling-active');
    }

    // --- 2. SMART PRELOADER (ULTRA-EFFICIENT) ---
    function queueAsset(url) {
        loadQueue.push(url);
        processQueue();
    }

    function processQueue() {
        if (isProcessingQueue || loadQueue.length === 0) return;

        // Check if user is interacting (scroll/mouse)
        // If they are, WAIT. Don't use CPU for downloads while user is animating stuff.
        if (navigator.scheduling && navigator.scheduling.isInputPending && navigator.scheduling.isInputPending()) {
            setTimeout(processQueue, 1000);
            return;
        }

        if ('requestIdleCallback' in window) {
            // Wait for a long idle period
            requestIdleCallback(downloadNextBatch, { timeout: 4000 });
        } else {
            setTimeout(downloadNextBatch, 2500);
        }
    }

    function downloadNextBatch() {
        isProcessingQueue = true;

        // Download ONE item at a time to minimize network thread usage
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
            // Long rest between tasks to let CPU cool down
            setTimeout(() => {
                if (loadQueue.length > 0) processQueue();
            }, 1500); // 1.5s cool-down period between downloads
        });
    }

    // --- 3. INITIALIZATION ---
    function init() {
        enforceCoolingMode();
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
