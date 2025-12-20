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
</script>
</body>
</html>
