
const CloudinaryUploader = {
    cloudName: 'dh9ysyfit',
    uploadPreset: 'culinaire_uploads',


    async compressImage(file, options = {}) {
        const {
            maxWidth = 1200,
            maxHeight = 1200,
            quality = 0.85,
            type = 'image/jpeg'
        } = options;

        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    let { width, height } = img;

                    if (width > maxWidth) {
                        height = (height * maxWidth) / width;
                        width = maxWidth;
                    }
                    if (height > maxHeight) {
                        width = (width * maxHeight) / height;
                        height = maxHeight;
                    }

                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;

                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob(
                        (blob) => {
                            if (blob) {
                                console.log(`Compressed: ${(file.size / 1024).toFixed(1)}KB → ${(blob.size / 1024).toFixed(1)}KB`);
                                resolve(blob);
                            } else {
                                reject(new Error('Canvas toBlob failed'));
                            }
                        },
                        type,
                        quality
                    );
                };
                img.onerror = () => reject(new Error('Image load failed'));
                img.src = e.target.result;
            };
            reader.onerror = () => reject(new Error('FileReader failed'));
            reader.readAsDataURL(file);
        });
    },


    async upload(file, options = {}) {
        const {
            folder = 'uploads',
            onProgress = () => { },
            compress = true,
            compressionOptions = {}
        } = options;

        let uploadFile = file;
        if (compress && file.type && file.type.startsWith('image/')) {
            try {
                uploadFile = await this.compressImage(file, compressionOptions);
            } catch (err) {
                console.warn('Compression failed, uploading original:', err);
            }
        }

        return new Promise((resolve, reject) => {
            const formData = new FormData();
            formData.append('file', uploadFile);
            formData.append('upload_preset', this.uploadPreset);
            formData.append('folder', folder);

            const xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    onProgress(percent, e.loaded, e.total);
                }
            });

            xhr.addEventListener('load', () => {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        resolve(response);
                    } catch (e) {
                        reject(new Error('Failed to parse response'));
                    }
                } else {
                    let errorMsg = 'Upload failed';
                    try {
                        const errResponse = JSON.parse(xhr.responseText);
                        errorMsg = errResponse.error?.message || errorMsg;
                    } catch (e) { }
                    reject(new Error(errorMsg));
                }
            });

            xhr.addEventListener('error', () => {
                reject(new Error('Network error during upload'));
            });

            xhr.addEventListener('abort', () => {
                reject(new Error('Upload cancelled'));
            });

            xhr.open('POST', `https://api.cloudinary.com/v1_1/${this.cloudName}/image/upload`);
            xhr.send(formData);
        });
    },


    createProgressBar(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return null;

        container.innerHTML = `
            <div class="upload-progress-wrapper" style="display: none;">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-cloud-arrow-up text-primary me-2"></i>
                    <span class="upload-status small">Mempersiapkan upload...</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                         role="progressbar" 
                         style="width: 0%" 
                         aria-valuenow="0" 
                         aria-valuemin="0" 
                         aria-valuemax="100"></div>
                </div>
                <small class="upload-size text-muted mt-1 d-block"></small>
            </div>
        `;

        const wrapper = container.querySelector('.upload-progress-wrapper');
        const bar = container.querySelector('.progress-bar');
        const status = container.querySelector('.upload-status');
        const sizeInfo = container.querySelector('.upload-size');

        return {
            show() {
                wrapper.style.display = 'block';
            },
            hide() {
                wrapper.style.display = 'none';
            },
            update(percent, loaded, total) {
                bar.style.width = `${percent}%`;
                bar.setAttribute('aria-valuenow', percent);
                status.textContent = percent < 100 ? `Mengupload... ${percent}%` : 'Memproses...';
                if (loaded && total) {
                    sizeInfo.textContent = `${(loaded / 1024 / 1024).toFixed(2)} MB / ${(total / 1024 / 1024).toFixed(2)} MB`;
                }
            },
            success(message = 'Upload berhasil!') {
                bar.classList.remove('progress-bar-striped', 'progress-bar-animated', 'bg-primary');
                bar.classList.add('bg-success');
                bar.style.width = '100%';
                status.innerHTML = `<i class="bi bi-check-circle text-success me-1"></i>${message}`;
            },
            error(message = 'Upload gagal') {
                bar.classList.remove('progress-bar-striped', 'progress-bar-animated', 'bg-primary');
                bar.classList.add('bg-danger');
                status.innerHTML = `<i class="bi bi-x-circle text-danger me-1"></i>${message}`;
            },
            reset() {
                bar.classList.add('progress-bar-striped', 'progress-bar-animated', 'bg-primary');
                bar.classList.remove('bg-success', 'bg-danger');
                bar.style.width = '0%';
                bar.setAttribute('aria-valuenow', 0);
                status.textContent = 'Mempersiapkan upload...';
                sizeInfo.textContent = '';
            }
        };
    }
};

if (typeof module !== 'undefined' && module.exports) {
    module.exports = CloudinaryUploader;
}
