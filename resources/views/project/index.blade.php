<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Recreation Timeline | Culinaire</title>
    @if(file_exists(public_path('css/app.css')))
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
    <!-- Tailwind CDN for guarantee if local build fails -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#D4AF37',
                        'gold-light': '#F4DF87',
                        dark: '#1a1a1a',
                        'dark-lighter': '#2a2a2a',
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom Scrollbar for Code Blocks */
        .code-scroll::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }
        .code-scroll::-webkit-scrollbar-track {
            background: #2d2d2d;
        }
        .code-scroll::-webkit-scrollbar-thumb {
            background: #555;
            border-radius: 4px;
        }
        .code-scroll::-webkit-scrollbar-thumb:hover {
            background: #777;
        }
        .step-content {
            transition: max-height 0.5s ease-out, opacity 0.5s ease-out;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        .step-content.active {
            max-height: 5000px; /* Arbitrary large number */
            opacity: 1;
            overflow: visible;
        }
    </style>
</head>
<body class="bg-dark text-gray-200 font-sans antialiased min-h-screen">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gold mb-4">Project Recreation Timeline</h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Panduan langkah demi langkah untuk menyusun ulang kode proyek secara kolaboratif.
                Ikuti urutan pengerjaan untuk Edo, Haidar, Dimas, dan Bernard.
            </p>
        </div>

        <div class="space-y-8 relative">
            <!-- Vertical Line -->
            <div class="absolute left-4 md:left-8 top-0 bottom-0 w-0.5 bg-gray-700 z-0"></div>

            @foreach($steps as $index => $step)
                <div class="relative z-10 step-container" id="step-{{ $step['id'] }}" data-step="{{ $step['id'] }}">
                    <!-- Header -->
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex-shrink-0 w-8 h-8 md:w-16 md:h-16 rounded-full bg-dark-lighter border-2 border-gray-600 flex items-center justify-center text-xl font-bold text-gray-500 status-icon shadow-lg">
                            {{ $step['id'] }}
                        </div>
                        <div class="bg-dark-lighter p-6 rounded-xl border border-gray-700 shadow-xl flex-1 cursor-pointer hover:border-gold transition-colors duration-300 step-header" onclick="toggleStep({{ $step['id'] }})">
                            <div class="flex flex-col md:flex-row md:items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold text-white">{{ $step['user'] }} <span class="text-gold text-sm ml-2 px-2 py-0.5 border border-gold rounded-full">{{ $step['role'] }}</span></h2>
                                    <p class="text-gray-400 mt-1">{{ $step['description'] }}</p>
                                </div>
                                <div class="mt-4 md:mt-0 flex items-center gap-2">
                                    <span class="status-text text-sm font-semibold uppercase tracking-wider text-gray-500">Locked</span>
                                    <svg class="w-6 h-6 text-gray-500 transform transition-transform duration-300 arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="step-content pl-12 md:pl-20 pr-2">
                        <div class="bg-dark-lighter rounded-xl border border-gray-700 p-6 shadow-xl">
                            <div class="mb-6 bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded text-blue-200">
                                <strong>Instructions:</strong> Copy the code for each file below and create them in your new repository. Ensure you maintain the correct folder structure.
                            </div>

                            <div class="space-y-6">
                                @foreach($step['file_contents'] as $fileCtx)
                                    <div class="file-block bg-black rounded-lg border border-gray-800 overflow-hidden">
                                        <div class="bg-gray-800 px-4 py-2 flex items-center justify-between">
                                            <span class="font-mono text-sm text-green-400">{{ $fileCtx['path'] }}</span>
                                            <button onclick="copyCode(this)" class="text-xs bg-gray-700 hover:bg-gold hover:text-black text-white px-3 py-1 rounded transition-colors">
                                                Copy Code
                                            </button>
                                        </div>
                                        <div class="relative">
                                            <textarea class="w-full h-48 bg-gray-900 text-gray-300 font-mono text-sm p-4 focus:outline-none resize-y code-scroll" readonly>{{ $fileCtx['content'] }}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Verification Section -->
                            <div class="mt-8 pt-8 border-t border-gray-700">
                                <label class="block text-sm font-medium text-gray-300 mb-2">Repository Link Verification</label>
                                <div class="flex gap-4">
                                    <input type="text" id="repo-url-{{ $step['id'] }}" placeholder="https://github.com/myteam/project-repo" class="flex-1 bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-gold focus:border-transparent outline-none">
                                    <button onclick="verifyStep({{ $step['id'] }})" class="bg-gold hover:bg-yellow-500 text-black font-bold py-2 px-6 rounded-lg transition-colors shadow-lg shadow-gold/20">
                                        Verify & Next
                                    </button>
                                </div>
                                <p id="error-msg-{{ $step['id'] }}" class="text-red-500 text-sm mt-2 hidden">Please enter a valid GitHub URL to proceed.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-12 text-center pb-12">
            <button onclick="resetProgress()" class="text-xs text-red-500 hover:text-red-400 underline opacity-50 hover:opacity-100">Reset Local Progress</button>
        </div>
    </div>

    <script>
        // Initialize State
        document.addEventListener('DOMContentLoaded', () => {
            loadProgress();
        });

        function toggleStep(id) {
            const container = document.getElementById(`step-${id}`);
            const content = container.querySelector('.step-content');
            const arrow = container.querySelector('.arrow-icon');
            
            // Only toggle if not locked (checked via class logic, but simplified here since we control visibility)
            if (!container.classList.contains('locked')) {
                content.classList.toggle('active');
                arrow.classList.toggle('rotate-180');
            }
        }

        function copyCode(btn) {
            const container = btn.closest('.file-block');
            const textarea = container.querySelector('textarea');
            textarea.select();
            document.execCommand('copy');
            
            const originalText = btn.innerText;
            btn.innerText = 'Copied!';
            btn.classList.add('bg-green-500', 'text-white');
            setTimeout(() => {
                btn.innerText = originalText;
                btn.classList.remove('bg-green-500', 'text-white');
            }, 2000);
        }

        function verifyStep(id) {
            const input = document.getElementById(`repo-url-${id}`);
            const errorMsg = document.getElementById(`error-msg-${id}`);
            const url = input.value.trim();
            
            // Simple validation
            if (url.includes('github.com') && url.length > 15) {
                errorMsg.classList.add('hidden');
                completeStep(id);
            } else {
                errorMsg.classList.remove('hidden');
            }
        }

        function completeStep(id) {
            // Save to local storage
            let progress = JSON.parse(localStorage.getItem('project_timeline_progress') || '[]');
            if (!progress.includes(id)) {
                progress.push(id);
                localStorage.setItem('project_timeline_progress', JSON.stringify(progress));
            }

            // UI Updates
            updateStepUI(id, 'completed');
            
            // Unlock next step
            const nextId = id + 1;
            const nextContainer = document.getElementById(`step-${nextId}`);
            if (nextContainer) {
                updateStepUI(nextId, 'active');
                // Open the next step automatically
                const nextContent = nextContainer.querySelector('.step-content');
                const nextArrow = nextContainer.querySelector('.arrow-icon');
                nextContent.classList.add('active');
                nextArrow.classList.add('rotate-180');
                
                // Close current
                const currentContainer = document.getElementById(`step-${id}`);
                currentContainer.querySelector('.step-content').classList.remove('active');
            } else {
                alert("Congratulations! All phases completed.");
            }
        }

        function loadProgress() {
            let progress = JSON.parse(localStorage.getItem('project_timeline_progress') || '[]');
            
            // Step 1 is always active if not done
            updateStepUI(1, 'active');

            progress.forEach(completedId => {
                updateStepUI(completedId, 'completed');
                // Unlock the next one
                updateStepUI(completedId + 1, 'active');
            });
        }

        function updateStepUI(id, status) {
            const container = document.getElementById(`step-${id}`);
            if (!container) return;

            const icon = container.querySelector('.status-icon');
            const statusText = container.querySelector('.status-text');
            const header = container.querySelector('.step-header');

            container.classList.remove('locked', 'active', 'completed');
            container.classList.add(status);

            if (status === 'completed') {
                icon.innerHTML = '✓';
                icon.className = 'flex-shrink-0 w-8 h-8 md:w-16 md:h-16 rounded-full bg-green-500 border-2 border-green-400 flex items-center justify-center text-xl font-bold text-black status-icon shadow-lg shadow-green-500/30';
                statusText.innerText = 'Completed';
                statusText.className = 'status-text text-sm font-semibold uppercase tracking-wider text-green-400';
                header.classList.remove('opacity-50', 'pointer-events-none');
            } else if (status === 'active') {
                icon.innerHTML = id;
                icon.className = 'flex-shrink-0 w-8 h-8 md:w-16 md:h-16 rounded-full bg-gold border-2 border-yellow-300 flex items-center justify-center text-xl font-bold text-black status-icon shadow-lg shadow-gold/30 animate-pulse';
                statusText.innerText = 'In Progress';
                statusText.className = 'status-text text-sm font-semibold uppercase tracking-wider text-gold';
                header.classList.remove('opacity-50', 'pointer-events-none');
            } else {
                // Locked (Default)
                icon.className = 'flex-shrink-0 w-8 h-8 md:w-16 md:h-16 rounded-full bg-dark-lighter border-2 border-gray-600 flex items-center justify-center text-xl font-bold text-gray-600 status-icon shadow-lg';
                statusText.innerText = 'Locked';
                statusText.className = 'status-text text-sm font-semibold uppercase tracking-wider text-gray-600';
                header.classList.add('opacity-50', 'pointer-events-none');
                container.classList.add('locked');
            }
        }

        function resetProgress() {
            if(confirm('Are you sure you want to reset all progress?')) {
                localStorage.removeItem('project_timeline_progress');
                location.reload();
            }
        }
    </script>
</body>
</html>
