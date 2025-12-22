window.CulinaireOptimizer = (function () {
    const CONFIG = {
        fpsThreshold: 30,
        coolingModeEnabled: false,
        batchSize: 3,
        idleTimeout: 2000
    };
    let lastTime = performance.now();
    let frames = 0;
    let loadQueue = [];
    let isProcessingQueue = false;
    function monitorTemperature() {
        const time = performance.now();
        frames++;
        if (time >= lastTime + 1000) {
            const fps = Math.round((frames * 1000) / (time - lastTime));
            if (fps < CONFIG.fpsThreshold && !CONFIG.coolingModeEnabled) {
                activateCoolingMode(fps);
            } else if (fps > 55 && CONFIG.coolingModeEnabled) {
                deactivateCoolingMode();
            }
            frames = 0;
            lastTime = time;
        }
        requestAnimationFrame(monitorTemperature);
    }
    function activateCoolingMode(currentFps) {
        if (!CONFIG.coolingModeEnabled) {
            CONFIG.coolingModeEnabled = true;
        }
    }
    function deactivateCoolingMode() {
        if (CONFIG.coolingModeEnabled) {
            CONFIG.coolingModeEnabled = false;
        }
    }
    function queueAsset(url) {
        loadQueue.push(url);
        processQueue();
    }
    function processQueue() {
        if (isProcessingQueue || loadQueue.length === 0) return;
        if (CONFIG.coolingModeEnabled) {
            setTimeout(processQueue, 5000);
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
            if (loadQueue.length > 0) {
                processQueue();
            }
        });
    }
    function init() {
        monitorTemperature();
    }
    return {
        init,
        preload: queueAsset
    };
})();
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', window.CulinaireOptimizer.init);
} else {
    window.CulinaireOptimizer.init();
}