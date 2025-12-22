/**
 * CMS Editor Script (Parent)
 * Handles logic for the Admin Sidebar Editor
 */

document.addEventListener('DOMContentLoaded', function () {
    const iframe = document.getElementById('site-preview');
    const editorPanel = document.getElementById('editor-panel');
    const noSelectionState = document.querySelector('.no-selection-state');
    const editForm = document.getElementById('edit-form');
    const saveButton = document.getElementById('btn-save');
    const connectionStatus = document.getElementById('connection-status');
    const savingOverlay = document.querySelector('.saving-overlay');

    let currentElement = null;
    let hasUnsavedChanges = false;

    // Page Selection Logic
    const pageSelector = document.getElementById('page-selector');

    pageSelector.addEventListener('change', function () {
        const url = this.value;
        const currentUrl = new URL(url);
        currentUrl.searchParams.set('cms_mode', 'true');

        iframe.src = currentUrl.toString();

        // Reset Editor State
        noSelectionState.style.display = 'block';
        editForm.style.display = 'none';
        currentElement = null;
    });

    // Listen for messages from Iframe
    window.addEventListener('message', function (event) {
        // Security check (domain matching) - skipped for localhost flexibility but recommended for prod

        const data = event.data;

        if (data.type === 'cms_url_changed' || (data.type === 'cms_handshake' && data.url)) {
            const newUrl = data.url; // This comes from the iframe
            document.getElementById('current-url').textContent = newUrl;

            // Sync dropdown if possible
            const originBase = window.location.origin;
            // Create a relative path or full URL check
            // Our options values are full URLs: http://.../menu

            // Try to find matching option
            for (let i = 0; i < pageSelector.options.length; i++) {
                // Check if option value matches the new URL (ignoring query params)
                const optUrl = new URL(pageSelector.options[i].value);
                const navUrl = new URL(newUrl);

                if (optUrl.pathname === navUrl.pathname) {
                    pageSelector.selectedIndex = i;
                    break;
                }
            }
        }

        if (data.type === 'cms_handshake') {
            connectionStatus.textContent = 'Connected';
            connectionStatus.className = 'badge bg-success text-white';
            console.log('CMS Iframe Connected');
        }

        if (data.type === 'cms_element_selected') {
            handleElementSelection(data.payload);
        }

        if (data.type === 'cms_url_changed') {
            document.getElementById('current-url').textContent = data.url;
        }
    });

    /**
     * Handle Element Selection
     */
    function handleElementSelection(payload) {
        currentElement = payload;

        // Show Form
        noSelectionState.style.display = 'none';
        editForm.style.display = 'block';
        saveButton.disabled = false;

        // Populate Fields
        document.getElementById('field-key').value = payload.key;
        document.getElementById('field-key-display').value = payload.key;
        document.getElementById('field-type').value = payload.type;

        const inputContainer = document.getElementById('input-container');
        inputContainer.innerHTML = ''; // Clear previous inputs

        document.getElementById('image-upload-container').style.display = 'none';

        if (payload.type === 'image') {
            // Image handling
            document.getElementById('image-upload-container').style.display = 'block';

            const imgPreview = document.createElement('img');
            imgPreview.src = payload.content;
            imgPreview.className = 'img-thumbnail mb-2';
            imgPreview.style.maxHeight = '150px';
            inputContainer.appendChild(imgPreview);

            const label = document.createElement('label');
            label.textContent = 'Current Image URL';
            inputContainer.appendChild(label);

            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.value = payload.content;

            // On input change -> update iframe preview
            input.addEventListener('input', (e) => {
                updateIframeContent(payload.key, e.target.value);
                hasUnsavedChanges = true;
                updateSaveButtonState();
            });

            inputContainer.appendChild(input);

        } else if (payload.type === 'richtext') {
            // Textarea for rich/long text
            const label = document.createElement('label');
            label.textContent = 'Content';
            inputContainer.appendChild(label);

            const textarea = document.createElement('textarea');
            textarea.className = 'form-control';
            textarea.rows = 6;
            textarea.value = payload.content;

            textarea.addEventListener('input', (e) => {
                updateIframeContent(payload.key, e.target.value);
                hasUnsavedChanges = true;
                updateSaveButtonState();
            });

            inputContainer.appendChild(textarea);

        } else {
            // Standard Text Input
            const label = document.createElement('label');
            label.textContent = 'Content';
            inputContainer.appendChild(label);

            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.value = payload.content;

            input.addEventListener('input', (e) => {
                updateIframeContent(payload.key, e.target.value);
                hasUnsavedChanges = true;
                updateSaveButtonState();
            });

            inputContainer.appendChild(input);
        }
    }

    /**
     * Update Iframe Preview Real-time
     */
    function updateIframeContent(key, content) {
        iframe.contentWindow.postMessage({
            type: 'cms_update_preview',
            key: key,
            content: content
        }, '*');
    }

    /**
     * Handle Image Upload
     */
    document.getElementById('image-uploader').addEventListener('change', async function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        try {
            saveButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...';
            saveButton.disabled = true;

            const response = await fetch('/admin/developer/api/image', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                // Update input field and preview
                const inputs = document.querySelectorAll('#input-container input[type="text"]');
                if (inputs.length > 0) {
                    inputs[0].value = result.url;
                    // Trigger input event to update preview
                    inputs[0].dispatchEvent(new Event('input'));
                }

                // Update img preview
                const img = document.querySelector('#input-container img');
                if (img) img.src = result.url;

                alert('Image uploaded successfully! Saved to input.');
            } else {
                alert('Upload failed: ' + result.message);
            }
        } catch (error) {
            console.error('Error uploading:', error);
            alert('Upload error occurred.');
        } finally {
            saveButton.innerHTML = '<i class="bi bi-save me-2"></i>Simpan Perubahan';
            saveButton.disabled = false;
        }
    });

    /**
     * Save Changes to Database
     */
    saveButton.addEventListener('click', async function () {
        if (!currentElement) return;

        const key = document.getElementById('field-key').value;
        // Get value depending on type (text input or textarea)
        let content = '';
        const input = document.querySelector('#input-container input[type="text"]');
        const textarea = document.querySelector('#input-container textarea');

        if (input) content = input.value;
        else if (textarea) content = textarea.value;

        savingOverlay.classList.add('active');

        // Failsafe: Remove overlay after 10 seconds even if request hangs
        const failsafe = setTimeout(() => {
            savingOverlay.classList.remove('active');
            saveButton.disabled = false;
        }, 10000);

        try {
            const response = await fetch('/admin/developer/api/content', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest', // Force JSON response
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    key: key,
                    content: content
                })
            });

            clearTimeout(failsafe); // Clear failsafe on response

            const result = await response.json();

            if (result.success) {
                hasUnsavedChanges = false;
                updateSaveButtonState();

                // Flash visible success in iframe
                iframe.contentWindow.postMessage({
                    type: 'cms_save_success',
                    key: key
                }, '*');

            } else {
                alert('Failed to save changes: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Save error:', error);
            alert('Error saving changes. Check console for details.');
        } finally {
            clearTimeout(failsafe);
            setTimeout(() => {
                savingOverlay.classList.remove('active');
                saveButton.disabled = false;
            }, 500);
        }
    });

    function updateSaveButtonState() {
        saveButton.classList.toggle('btn-warning', hasUnsavedChanges);
        saveButton.classList.toggle('btn-primary', !hasUnsavedChanges);
        saveButton.innerHTML = hasUnsavedChanges
            ? '<i class="bi bi-save me-2"></i>Simpan Perubahan*'
            : '<i class="bi bi-check2 me-2"></i>Tersimpan';
    }
});
