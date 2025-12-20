<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Recreation Timeline | Culinaire</title>
    @if(file_exists(public_path('css/app.css')))
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
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
                        'dark-card': '#1e1e1e',
                    }
                }
            }
        }
    </script>
    <style>
        .code-scroll::-webkit-scrollbar { height: 6px; width: 6px; }
        .code-scroll::-webkit-scrollbar-track { background: #2d2d2d; }
        .code-scroll::-webkit-scrollbar-thumb { background: #555; border-radius: 3px; }
        .code-scroll::-webkit-scrollbar-thumb:hover { background: #777; }
        .step-content { max-height: 0; opacity: 0; overflow: hidden; transition: max-height 0.4s ease, opacity 0.3s ease; }
        .step-content.open { max-height: 500px; opacity: 1; overflow: visible; }
        .member-steps { max-height: 0; opacity: 0; overflow: hidden; transition: max-height 0.5s ease, opacity 0.4s ease; }
        .member-steps.open { max-height: none; opacity: 1; overflow: visible; }
        .step-item { border-left: 2px solid #333; }
        .step-item.completed { border-left-color: #10b981; }
        .step-item.current { border-left-color: #D4AF37; }
    </style>
</head>
<body class="bg-dark text-gray-200 font-sans antialiased min-h-screen">

<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-gold mb-3">Project Recreation Timeline</h1>
        <p class="text-gray-400 max-w-xl mx-auto">
            800 langkah pengerjaan proyek. Setiap anggota tim bertanggung jawab atas 200 langkah.
        </p>
        <div class="mt-4 flex justify-center gap-4 text-sm">
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-green-500 rounded-full"></span> Completed</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-gold rounded-full animate-pulse"></span> Current</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-gray-600 rounded-full"></span> Locked</span>
        </div>
    </div>

    <div class="space-y-6">
        @foreach($members as $member)
        <div class="bg-dark-lighter rounded-xl border border-gray-700 overflow-hidden" id="member-{{ $member['id'] }}">
            <div class="p-5 cursor-pointer hover:bg-dark-card transition-colors" onclick="toggleMember({{ $member['id'] }})">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gold/20 border-2 border-gold flex items-center justify-center text-gold font-bold text-lg">
                            {{ substr($member['name'], 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">{{ $member['name'] }}</h2>
                            <p class="text-sm text-gray-400">{{ $member['role'] }} &bull; {{ $member['email'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500">{{ count($member['steps']) }} steps</span>
                        <span class="member-progress text-sm font-mono text-gold" id="progress-{{ $member['id'] }}">0%</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform member-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="member-steps px-5 pb-5" id="steps-{{ $member['id'] }}">
                <div class="space-y-2 max-h-[70vh] overflow-y-auto code-scroll pr-2">
                    @foreach($member['steps'] as $step)
                    <div class="step-item pl-4 py-2 rounded-r bg-dark-card/50 hover:bg-dark-card transition-colors" 
                         id="step-{{ $step['step'] }}" data-step="{{ $step['step'] }}">
                        <div class="flex items-center justify-between cursor-pointer" onclick="toggleStep({{ $step['step'] }})">
                            <div class="flex items-center gap-3">
                                <span class="step-number w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-xs font-mono">
                                    {{ $step['step'] }}
                                </span>
                                <div>
                                    <span class="text-sm text-gray-300 font-medium">{{ $step['action'] }}</span>
                                    <span class="text-xs text-gray-500 block font-mono truncate max-w-xs">{{ $step['file'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-600">L{{ $step['line_start'] }}-{{ $step['line_end'] }}</span>
                                <button onclick="event.stopPropagation(); markComplete({{ $step['step'] }})" 
                                        class="mark-btn text-xs px-2 py-1 rounded bg-gray-700 hover:bg-green-600 transition-colors">
                                    ✓
                                </button>
                            </div>
                        </div>
                        <div class="step-content mt-2" id="content-{{ $step['step'] }}">
                            <div class="relative">
                                <pre class="bg-gray-900 rounded p-3 text-xs overflow-x-auto code-scroll"><code class="text-gray-300">{{ $step['code'] }}</code></pre>
                                <button onclick="copyCode({{ $step['step'] }})" 
                                        class="absolute top-2 right-2 text-xs bg-gray-700 hover:bg-gold hover:text-black px-2 py-1 rounded transition-colors">
                                    Copy
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- GitHub Submission Section -->
                <div class="mt-6 pt-4 border-t border-gray-700">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-300">📦 Submit Repository</h3>
                        <span class="submission-status text-xs px-2 py-1 rounded" id="status-{{ $member['id'] }}">Not Submitted</span>
                    </div>
                    <div class="flex gap-2">
                        <input type="text" 
                               id="repo-{{ $member['id'] }}" 
                               placeholder="https://github.com/username/repo"
                               class="flex-1 bg-gray-900 border border-gray-700 rounded px-3 py-2 text-sm text-white focus:border-gold focus:outline-none">
                        <button onclick="submitRepo({{ $member['id'] }})" 
                                class="bg-gold hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded text-sm transition-colors">
                            Submit
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Pastikan 100% langkah selesai sebelum submit.</p>
                    
                    <!-- Approval Section (Only visible to Edo) -->
                    @if(Auth::check() && Auth::user()->email === 'pedoprimasaragi@gmail.com')
                    <div class="mt-4 p-3 bg-gray-800/50 rounded border border-gray-700" id="approval-{{ $member['id'] }}">
                        <p class="text-xs text-gray-400 mb-2">🔒 Admin Review (Only Edo can see this)</p>
                        <div class="flex gap-2">
                            <button onclick="approveRepo({{ $member['id'] }})" 
                                    class="flex-1 bg-green-600 hover:bg-green-500 text-white text-xs px-3 py-2 rounded transition-colors">
                                ✓ Approve
                            </button>
                            <button onclick="rejectRepo({{ $member['id'] }})" 
                                    class="flex-1 bg-red-600 hover:bg-red-500 text-white text-xs px-3 py-2 rounded transition-colors">
                                ✗ Reject
                            </button>
                        </div>
                        <textarea id="feedback-{{ $member['id'] }}" 
                                  placeholder="Feedback (jika reject, jelaskan apa yang salah)"
                                  class="w-full mt-2 bg-gray-900 border border-gray-700 rounded p-2 text-xs text-white focus:border-gold focus:outline-none resize-none"
                                  rows="2"></textarea>
                    </div>
                    @endif
                    
                    <!-- Warning/Feedback Display -->
                    <div id="warning-{{ $member['id'] }}" class="hidden mt-3 p-3 bg-red-900/30 border border-red-700 rounded text-sm text-red-300">
                    </div>
                    <div id="success-{{ $member['id'] }}" class="hidden mt-3 p-3 bg-green-900/30 border border-green-700 rounded text-sm text-green-300">
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8 text-center">
        <button onclick="resetProgress()" class="text-xs text-red-500 hover:text-red-400 underline opacity-50 hover:opacity-100">
            Reset All Progress
        </button>
    </div>
</div>

<script src="{{ asset('js/cursor.js') }}"></script>
<script>
    const completedSteps = new Set(JSON.parse(localStorage.getItem('project_steps_v2') || '[]'));

    document.addEventListener('DOMContentLoaded', () => {
        loadProgress();
    });

    function toggleMember(id) {
        const stepsContainer = document.getElementById(`steps-${id}`);
        const arrow = document.querySelector(`#member-${id} .member-arrow`);
        stepsContainer.classList.toggle('open');
        arrow.classList.toggle('rotate-180');
    }

    function toggleStep(stepNum) {
        const content = document.getElementById(`content-${stepNum}`);
        content.classList.toggle('open');
    }

    function copyCode(stepNum) {
        const codeEl = document.querySelector(`#content-${stepNum} code`);
        navigator.clipboard.writeText(codeEl.textContent).then(() => {
            const btn = document.querySelector(`#content-${stepNum} button`);
            btn.textContent = 'Copied!';
            setTimeout(() => btn.textContent = 'Copy', 1500);
        });
    }

    function markComplete(stepNum) {
        completedSteps.add(stepNum);
        saveProgress();
        updateStepUI(stepNum);
        updateAllProgress();
    }

    function updateStepUI(stepNum) {
        const stepEl = document.getElementById(`step-${stepNum}`);
        if (completedSteps.has(stepNum)) {
            stepEl.classList.add('completed');
            stepEl.querySelector('.step-number').classList.add('bg-green-600');
            stepEl.querySelector('.step-number').classList.remove('bg-gray-700');
        }
    }

    function loadProgress() {
        completedSteps.forEach(stepNum => updateStepUI(stepNum));
        updateAllProgress();
    }

    function updateAllProgress() {
        [1, 2, 3, 4].forEach(memberId => {
            const start = (memberId - 1) * 200 + 1;
            const end = memberId * 200;
            let completed = 0;
            for (let i = start; i <= end; i++) {
                if (completedSteps.has(i)) completed++;
            }
            const percent = Math.round((completed / 200) * 100);
            document.getElementById(`progress-${memberId}`).textContent = `${percent}%`;
        });
    }

    function saveProgress() {
        localStorage.setItem('project_steps_v2', JSON.stringify([...completedSteps]));
    }

    function resetProgress() {
        if (confirm('Reset all progress?')) {
            localStorage.removeItem('project_steps_v2');
            location.reload();
        }
    }

    // ========== REPO SUBMISSION & APPROVAL ==========
    const repoSubmissions = JSON.parse(localStorage.getItem('repo_submissions') || '{}');
    
    function loadSubmissions() {
        [1, 2, 3, 4].forEach(id => {
            const data = repoSubmissions[id];
            if (data) {
                const input = document.getElementById(`repo-${id}`);
                const status = document.getElementById(`status-${id}`);
                input.value = data.url || '';
                
                if (data.status === 'approved') {
                    status.textContent = '✓ Approved';
                    status.className = 'submission-status text-xs px-2 py-1 rounded bg-green-600 text-white';
                    showSuccess(id, 'Repository approved! Great work.');
                } else if (data.status === 'rejected') {
                    status.textContent = '✗ Rejected';
                    status.className = 'submission-status text-xs px-2 py-1 rounded bg-red-600 text-white';
                    showWarning(id, data.feedback || 'Please check your code and resubmit.');
                } else if (data.status === 'submitted') {
                    status.textContent = '⏳ Pending Review';
                    status.className = 'submission-status text-xs px-2 py-1 rounded bg-yellow-600 text-black';
                }
            }
        });
    }

    function submitRepo(memberId) {
        const input = document.getElementById(`repo-${memberId}`);
        const url = input.value.trim();
        const status = document.getElementById(`status-${memberId}`);
        
        // Validate URL
        if (!url.includes('github.com') || url.length < 20) {
            showWarning(memberId, 'Please enter a valid GitHub repository URL.');
            return;
        }
        
        // Check progress
        const start = (memberId - 1) * 200 + 1;
        const end = memberId * 200;
        let completed = 0;
        for (let i = start; i <= end; i++) {
            if (completedSteps.has(i)) completed++;
        }
        
        if (completed < 200) {
            showWarning(memberId, `Please complete all 200 steps first. Currently: ${completed}/200`);
            return;
        }
        
        // Save submission
        repoSubmissions[memberId] = { url, status: 'submitted', feedback: '' };
        localStorage.setItem('repo_submissions', JSON.stringify(repoSubmissions));
        
        status.textContent = '⏳ Pending Review';
        status.className = 'submission-status text-xs px-2 py-1 rounded bg-yellow-600 text-black';
        hideWarning(memberId);
        alert('Repository submitted! Waiting for admin review.');
    }

    function approveRepo(memberId) {
        repoSubmissions[memberId] = { 
            ...repoSubmissions[memberId], 
            status: 'approved',
            feedback: ''
        };
        localStorage.setItem('repo_submissions', JSON.stringify(repoSubmissions));
        
        const status = document.getElementById(`status-${memberId}`);
        status.textContent = '✓ Approved';
        status.className = 'submission-status text-xs px-2 py-1 rounded bg-green-600 text-white';
        hideWarning(memberId);
        showSuccess(memberId, 'Repository approved!');
    }

    function rejectRepo(memberId) {
        const feedback = document.getElementById(`feedback-${memberId}`).value || 'Please fix the issues and resubmit.';
        
        repoSubmissions[memberId] = { 
            ...repoSubmissions[memberId], 
            status: 'rejected',
            feedback: feedback
        };
        localStorage.setItem('repo_submissions', JSON.stringify(repoSubmissions));
        
        const status = document.getElementById(`status-${memberId}`);
        status.textContent = '✗ Rejected';
        status.className = 'submission-status text-xs px-2 py-1 rounded bg-red-600 text-white';
        showWarning(memberId, feedback);
    }

    function showWarning(memberId, message) {
        const el = document.getElementById(`warning-${memberId}`);
        el.textContent = '⚠️ ' + message;
        el.classList.remove('hidden');
        document.getElementById(`success-${memberId}`).classList.add('hidden');
    }

    function hideWarning(memberId) {
        document.getElementById(`warning-${memberId}`).classList.add('hidden');
    }

    function showSuccess(memberId, message) {
        const el = document.getElementById(`success-${memberId}`);
        el.textContent = '✓ ' + message;
        el.classList.remove('hidden');
        document.getElementById(`warning-${memberId}`).classList.add('hidden');
    }

    // Load submissions on page load
    document.addEventListener('DOMContentLoaded', () => {
        loadProgress();
        loadSubmissions();
    });
</script>
</body>
</html>
