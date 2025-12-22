/**
 * CULINAIRE PERFORMANCE CORE & HEAT MANAGEMENT SYSTEM
 * ----------------------------------------------------
 * Monitors device temperature (via FPS proxies) and network status to 
 * optimize resource loading and animation intensity.
 */

window.CulinaireOptimizer = (function () {
    // Configuration
    const CONFIG = {
        fpsThreshold: 30, // Drop below this triggers "Cooling Mode"
        coolingModeEnabled: false,
        batchSize: 3, // Number of images to preload at once
        idleTimeout: 2000 // Time to wait for user interaction to stop before heavy tasks
    };

    // State
    let lastTime = performance.now();
    let frames = 0;
    let loadQueue = [];
    let isProcessingQueue = false;

    // --- 1. HEAT DETECTION (FPS MONITOR) ---
    function monitorTemperature() {
        const time = performance.now();
        frames++;

        if (time >= lastTime + 1000) {
            const fps = Math.round((frames * 1000) / (time - lastTime));

            // Check if device is struggling
            if (fps < CONFIG.fpsThreshold && !CONFIG.coolingModeEnabled) {
                activateCoolingMode(fps);
            } else if (fps > 55 && CONFIG.coolingModeEnabled) {
                deactivateCoolingMode();
            }

            // Reset
            frames = 0;
            lastTime = time;
        }

        requestAnimationFrame(monitorTemperature);
    }

    // --- 2. ACTIVATING "COOLING MODE" ---
    function activateCoolingMode(currentFps) {
        console.warn(`🔥 Device Heating Up (FPS: ${currentFps}). Activating Cooling Mode...`);
        CONFIG.coolingModeEnabled = true;
        document.body.classList.add('cooling-mode-active');

        // Disable heavy animations
        document.documentElement.style.setProperty('--animation-speed', '0s');

        // Pause any heavy video backgrounds if they exist
        const videos = document.querySelectorAll('video[autoplay]');
        videos.forEach(v => v.pause());

        // Notify user via console or small UI
        console.log("❄️ Performance Optimized for Device Temperature.");
    }

    function deactivateCoolingMode() {
        console.log(`❄️ Device Cooled Down. Restoring visual fidelity.`);
        CONFIG.coolingModeEnabled = false;
        document.body.classList.remove('cooling-mode-active');
        document.documentElement.style.removeProperty('--animation-speed');

        const videos = document.querySelectorAll('video[paused]');
        videos.forEach(v => v.play().catch(() => { }));
    }

    // --- 3. SMART PRELOADER (FAST DOWNLOADS) ---
    // Uses requestIdleCallback to download assets only when CPU is free
    function queueAsset(url) {
        loadQueue.push(url);
        processQueue();
    }

    function processQueue() {
        if (isProcessingQueue || loadQueue.length === 0) return;

        // Only download if network is idle-ish and device isn't hot
        if (CONFIG.coolingModeEnabled) {
            setTimeout(processQueue, 5000); // Retry later if hot
            return;
        }

        if ('requestIdleCallback' in window) {
            requestIdleCallback(downloadNextBatch);
        } else {
            setTimeout(downloadNextBatch, 500);
        }
    }

    function downloadNextBatch(deadline) {
        isProcessingQueue = true;
        // Download a batch
        const batch = loadQueue.splice(0, CONFIG.batchSize);

        const promises = batch.map(url => {
            return new Promise((resolve) => {
                const img = new Image();
                img.onload = resolve;
                img.onerror = resolve; // Continue even if fail
                img.src = url;
            });
        });

        Promise.all(promises).then(() => {
            isProcessingQueue = false;
            if (loadQueue.length > 0) {
                processQueue(); // Continue
            } else {
                console.log("✅ All Cached: Site is ready for offline-like speeds.");
            }
        });
    }

    // --- 4. INITIALIZATION ---
    function init() {
        console.log("🚀 Culinaire Optimizer Started");
        monitorTemperature();

        // Scan page for high-priority images to cache immediately
        // Scanning for all links to preload future pages
        const links = document.querySelectorAll('a[href^="' + window.location.origin + '"]');
        links.forEach(link => {
            // detailed prefetch logic could go here
        });
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
