<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Recreation Timeline | Culinaire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @if(file_exists(public_path('css/app.css')))
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
    <style>
        :root {
            --gold: #D4AF37;
            --gold-light: #E8C864;
            --gold-dark: #B8942F;
            --dark-bg: #0a0a0f;
            --dark-surface: #12121a;
            --dark-card: #1a1a25;
            --dark-border: #2a2a35;
            --text-primary: #f5f5f7;
            --text-secondary: #a0a0b0;
            --text-muted: #606070;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }
        
        .bg-gradient-hero {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #0f0f18 50%, var(--dark-bg) 100%);
        }
        
        .gold-gradient {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 50%, var(--gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glass-card {
            background: rgba(26, 26, 37, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.05);
        }
        
        .glass-card:hover {
            border-color: rgba(212, 175, 55, 0.3);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 60px rgba(212, 175, 55, 0.1);
        }
        
        .glow-gold {
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.3), 0 0 40px rgba(212, 175, 55, 0.1);
        }
        
        .btn-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%);
            color: #0a0a0f;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }
        
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
        }
        
        .btn-ghost {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--dark-border);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-ghost:hover {
            background: rgba(212, 175, 55, 0.1);
            border-color: var(--gold);
            color: var(--gold);
        }
        
        .code-scroll::-webkit-scrollbar {
            height: 4px;
            width: 4px;
        }
        
        .code-scroll::-webkit-scrollbar-track {
            background: var(--dark-surface);
            border-radius: 2px;
        }
        
        .code-scroll::-webkit-scrollbar-thumb {
            background: var(--gold-dark);
            border-radius: 2px;
        }
        
        .member-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .member-card:hover {
            transform: translateY(-4px);
        }
        
        .avatar-ring {
            background: conic-gradient(from 0deg, var(--gold), var(--gold-light), var(--gold));
            padding: 3px;
            border-radius: 50%;
        }
        
        .avatar-inner {
            background: var(--dark-surface);
            border-radius: 50%;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--gold);
        }
        
        .step-content {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
        }
        
        .step-content.open {
            max-height: 600px;
            opacity: 1;
            overflow: visible;
        }
        
        .member-steps {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.6s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease;
        }
        
        .member-steps.open {
            max-height: none;
            opacity: 1;
            overflow: visible;
        }
        
        .step-item {
            border-left: 2px solid var(--dark-border);
            transition: all 0.3s ease;
        }
        
        .step-item.completed {
            border-left-color: #10b981;
        }
        
        .step-item.completed .step-number {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
        }
        
        .step-item.current {
            border-left-color: var(--gold);
        }
        
        .step-number {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--dark-border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
            font-family: 'JetBrains Mono', monospace;
            transition: all 0.3s ease;
        }
        
        .progress-ring {
            width: 48px;
            height: 48px;
            position: relative;
        }
        
        .progress-ring svg {
            transform: rotate(-90deg);
        }
        
        .progress-ring circle {
            fill: none;
            stroke-width: 3;
        }
        
        .progress-ring .bg {
            stroke: var(--dark-border);
        }
        
        .progress-ring .progress {
            stroke: var(--gold);
            stroke-linecap: round;
            transition: stroke-dashoffset 0.5s ease;
        }
        
        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.625rem;
            font-weight: 600;
            color: var(--gold);
        }
        
        .code-block {
            background: #0d0d14;
            border-radius: 12px;
            border: 1px solid rgba(212, 175, 55, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .code-block::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.3), transparent);
        }
        
        .code-block pre {
            padding: 1rem;
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            font-size: 0.8rem;
            line-height: 1.6;
            overflow-x: auto;
            color: #c9d1d9;
        }
        
        .input-luxury {
            background: rgba(18, 18, 26, 0.8);
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            font-size: 0.875rem;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .input-luxury:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }
        
        .input-luxury::placeholder {
            color: var(--text-muted);
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-pending {
            background: rgba(234, 179, 8, 0.15);
            color: #eab308;
            border: 1px solid rgba(234, 179, 8, 0.3);
        }
        
        .badge-approved {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        .badge-rejected {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        .badge-default {
            background: rgba(100, 100, 120, 0.15);
            color: var(--text-secondary);
            border: 1px solid var(--dark-border);
        }
        
        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--gold);
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite ease-in-out;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.1; }
            90% { opacity: 0.1; }
            100% { transform: translateY(-100px) rotate(720deg); opacity: 0; }
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }
        
        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        
        .arrow-icon {
            transition: transform 0.3s ease;
        }
        
        .arrow-icon.rotated {
            transform: rotate(180deg);
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--dark-border), transparent);
            margin: 1.5rem 0;
        }
    </style>
</head>
<body class="bg-gradient-hero">

<div class="floating-particles">
    <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
    <div class="particle" style="left: 20%; animation-delay: 2s;"></div>
    <div class="particle" style="left: 30%; animation-delay: 4s;"></div>
    <div class="particle" style="left: 40%; animation-delay: 6s;"></div>
    <div class="particle" style="left: 50%; animation-delay: 8s;"></div>
    <div class="particle" style="left: 60%; animation-delay: 10s;"></div>
    <div class="particle" style="left: 70%; animation-delay: 12s;"></div>
    <div class="particle" style="left: 80%; animation-delay: 14s;"></div>
    <div class="particle" style="left: 90%; animation-delay: 16s;"></div>
</div>

<div style="max-width: 1100px; margin: 0 auto; padding: 3rem 1.5rem; position: relative; z-index: 1;">
    
    <header style="text-align: center; margin-bottom: 4rem;" class="fade-in">
        <p style="color: var(--gold); font-size: 0.75rem; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 1rem;">
            Culinaire Development
        </p>
        <h1 class="font-serif gold-gradient" style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 700; margin-bottom: 1rem;">
            Project Recreation Timeline
        </h1>
        <p style="color: var(--text-secondary); max-width: 500px; margin: 0 auto 2rem; font-size: 0.95rem;">
            800 langkah pengerjaan proyek. Setiap anggota tim bertanggung jawab atas 200 langkah.
        </p>
        
        <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
            <div class="legend-item">
                <div class="legend-dot" style="background: #10b981;"></div>
                <span>Completed</span>
            </div>
            <div class="legend-item">
                <div class="legend-dot" style="background: var(--gold); animation: pulse 2s infinite;"></div>
                <span>Current</span>
            </div>
            <div class="legend-item">
                <div class="legend-dot" style="background: var(--dark-border);"></div>
                <span>Locked</span>
            </div>
        </div>
    </header>

    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        @foreach($members as $index => $member)
        <div class="glass-card member-card fade-in" style="border-radius: 16px; overflow: hidden; animation-delay: {{ $index * 0.1 }}s;" id="member-{{ $member['id'] }}">
            
            <div style="padding: 1.5rem; cursor: pointer;" onclick="toggleMember({{ $member['id'] }})">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div class="avatar-ring">
                            <div class="avatar-inner">{{ substr($member['name'], 0, 1) }}</div>
                        </div>
                        <div>
                            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">
                                {{ $member['name'] }}
                            </h2>
                            <p style="font-size: 0.8rem; color: var(--text-muted);">
                                {{ $member['role'] }} • {{ $member['email'] }}
                            </p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 1.5rem;">
                        <div style="text-align: right;">
                            <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.25rem;">Steps</p>
                            <p style="font-size: 0.875rem; color: var(--text-secondary);">{{ count($member['steps']) }}</p>
                        </div>
                        <div class="progress-ring" id="ring-{{ $member['id'] }}">
                            <svg viewBox="0 0 48 48">
                                <circle class="bg" cx="24" cy="24" r="20"></circle>
                                <circle class="progress" cx="24" cy="24" r="20" stroke-dasharray="125.6" stroke-dashoffset="125.6"></circle>
                            </svg>
                            <span class="progress-text" id="progress-{{ $member['id'] }}">0%</span>
                        </div>
                        <svg class="arrow-icon" id="arrow-{{ $member['id'] }}" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                            <path d="M6 9l6 6 6-6"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="member-steps" id="steps-{{ $member['id'] }}" style="padding: 0 1.5rem 1.5rem;">
                <div class="section-divider"></div>
                
                <div style="max-height: 60vh; overflow-y: auto; padding-right: 0.5rem;" class="code-scroll">
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        @foreach($member['steps'] as $step)
                        <div class="step-item" style="padding: 0.75rem 1rem; border-radius: 0 8px 8px 0; background: rgba(18, 18, 26, 0.5); transition: all 0.3s ease;" 
                             id="step-{{ $step['step'] }}" data-step="{{ $step['step'] }}">
                            
                            <div style="display: flex; align-items: center; justify-content: space-between; cursor: pointer;" onclick="toggleStep({{ $step['step'] }})">
                                <div style="display: flex; align-items: center; gap: 0.75rem; flex: 1; min-width: 0;">
                                    <div class="step-number">{{ $step['step'] }}</div>
                                    <div style="flex: 1; min-width: 0;">
                                        <p style="font-size: 0.875rem; font-weight: 500; color: var(--text-primary); margin-bottom: 0.125rem;">
                                            {{ $step['action'] }}
                                        </p>
                                        <p style="font-size: 0.75rem; color: var(--text-muted); font-family: monospace; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $step['file'] }}
                                        </p>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0;">
                                    <span style="font-size: 0.7rem; color: var(--text-muted); font-family: monospace;">
                                        L{{ $step['line_start'] }}-{{ $step['line_end'] }}
                                    </span>
                                    <button onclick="event.stopPropagation(); markComplete({{ $step['step'] }})" 
                                            class="mark-btn btn-ghost" style="padding: 0.375rem 0.625rem; font-size: 0.75rem;">
                                        ✓
                                    </button>
                                </div>
                            </div>
                            
                            <div class="step-content" id="content-{{ $step['step'] }}" style="margin-top: 0.75rem;">
                                <div class="code-block">
                                    <pre class="code-scroll"><code>{{ $step['code'] }}</code></pre>
                                    <button onclick="copyCode({{ $step['step'] }})" 
                                            style="position: absolute; top: 0.5rem; right: 0.5rem; background: var(--dark-border); color: var(--text-secondary); border: none; padding: 0.375rem 0.75rem; border-radius: 6px; font-size: 0.7rem; cursor: pointer; transition: all 0.3s ease;"
                                            onmouseover="this.style.background='var(--gold)'; this.style.color='#0a0a0f';"
                                            onmouseout="this.style.background='var(--dark-border)'; this.style.color='var(--text-secondary)';">
                                        Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="section-divider" style="margin-top: 2rem;"></div>
                
                <div style="background: rgba(18, 18, 26, 0.5); border-radius: 12px; padding: 1.25rem; border: 1px solid var(--dark-border);">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                        <h3 style="font-size: 0.9rem; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-size: 1.1rem;">📦</span> Submit Repository
                        </h3>
                        <span class="badge badge-default" id="status-{{ $member['id'] }}">Not Submitted</span>
                    </div>
                    
                    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                        <input type="text" 
                               id="repo-{{ $member['id'] }}" 
                               placeholder="https://github.com/username/repo"
                               class="input-luxury"
                               style="flex: 1; min-width: 200px;">
                        <button onclick="submitRepo({{ $member['id'] }})" class="btn-gold">
                            Submit
                        </button>
                    </div>
                    
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.75rem;">
                        Pastikan 100% langkah selesai sebelum submit.
                    </p>
                    
                    @if(Auth::check() && Auth::user()->email === 'pedoprimasaragi@gmail.com')
                    <div style="margin-top: 1rem; padding: 1rem; background: rgba(212, 175, 55, 0.05); border-radius: 8px; border: 1px solid rgba(212, 175, 55, 0.2);" id="approval-{{ $member['id'] }}">
                        <p style="font-size: 0.75rem; color: var(--gold); margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span>🔒</span> Admin Review
                        </p>
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <button onclick="approveRepo({{ $member['id'] }})" 
                                    style="flex: 1; background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 0.5rem; border-radius: 6px; cursor: pointer; font-size: 0.8rem; transition: all 0.3s ease;"
                                    onmouseover="this.style.background='#10b981'; this.style.color='#0a0a0f';"
                                    onmouseout="this.style.background='rgba(16, 185, 129, 0.2)'; this.style.color='#10b981';">
                                ✓ Approve
                            </button>
                            <button onclick="rejectRepo({{ $member['id'] }})" 
                                    style="flex: 1; background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; padding: 0.5rem; border-radius: 6px; cursor: pointer; font-size: 0.8rem; transition: all 0.3s ease;"
                                    onmouseover="this.style.background='#ef4444'; this.style.color='#0a0a0f';"
                                    onmouseout="this.style.background='rgba(239, 68, 68, 0.2)'; this.style.color='#ef4444';">
                                ✗ Reject
                            </button>
                        </div>
                        <textarea id="feedback-{{ $member['id'] }}" 
                                  placeholder="Feedback (jika reject, jelaskan yang perlu diperbaiki)"
                                  class="input-luxury"
                                  style="resize: none; height: 60px;"></textarea>
                    </div>
                    @endif
                    
                    <div id="warning-{{ $member['id'] }}" style="display: none; margin-top: 0.75rem; padding: 0.75rem 1rem; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; font-size: 0.8rem; color: #f87171;"></div>
                    <div id="success-{{ $member['id'] }}" style="display: none; margin-top: 0.75rem; padding: 0.75rem 1rem; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 8px; font-size: 0.8rem; color: #34d399;"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <footer style="margin-top: 4rem; text-align: center; padding-bottom: 2rem;">
        <button onclick="resetProgress()" style="background: transparent; border: none; color: var(--text-muted); font-size: 0.75rem; cursor: pointer; opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#ef4444';" onmouseout="this.style.opacity='0.5'; this.style.color='var(--text-muted)';">
            Reset All Progress
        </button>
    </footer>
</div>

<script src="{{ asset('js/cursor.js') }}"></script>
<script>
    const completedSteps = new Set(JSON.parse(localStorage.getItem('project_steps_v2') || '[]'));

    document.addEventListener('DOMContentLoaded', () => {
        loadProgress();
        loadSubmissions();
    });

    function toggleMember(id) {
        const stepsContainer = document.getElementById(`steps-${id}`);
        const arrow = document.getElementById(`arrow-${id}`);
        stepsContainer.classList.toggle('open');
        arrow.classList.toggle('rotated');
    }

    function toggleStep(stepNum) {
        const content = document.getElementById(`content-${stepNum}`);
        content.classList.toggle('open');
    }

    function copyCode(stepNum) {
        const codeEl = document.querySelector(`#content-${stepNum} code`);
        navigator.clipboard.writeText(codeEl.textContent).then(() => {
            const btn = document.querySelector(`#content-${stepNum} button`);
            const originalText = btn.textContent;
            btn.textContent = 'Copied!';
            btn.style.background = 'var(--gold)';
            btn.style.color = '#0a0a0f';
            setTimeout(() => {
                btn.textContent = originalText;
                btn.style.background = 'var(--dark-border)';
                btn.style.color = 'var(--text-secondary)';
            }, 1500);
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
        if (stepEl && completedSteps.has(stepNum)) {
            stepEl.classList.add('completed');
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
            const progressText = document.getElementById(`progress-${memberId}`);
            if (progressText) progressText.textContent = `${percent}%`;
            
            const progressCircle = document.querySelector(`#ring-${memberId} .progress`);
            if (progressCircle) {
                const circumference = 125.6;
                const offset = circumference - (percent / 100) * circumference;
                progressCircle.style.strokeDashoffset = offset;
            }
        });
    }

    function saveProgress() {
        localStorage.setItem('project_steps_v2', JSON.stringify([...completedSteps]));
    }

    function resetProgress() {
        if (confirm('Reset all progress? This cannot be undone.')) {
            localStorage.removeItem('project_steps_v2');
            location.reload();
        }
    }

    const repoSubmissions = JSON.parse(localStorage.getItem('repo_submissions') || '{}');
    
    function loadSubmissions() {
        [1, 2, 3, 4].forEach(id => {
            const data = repoSubmissions[id];
            if (data) {
                const input = document.getElementById(`repo-${id}`);
                const status = document.getElementById(`status-${id}`);
                if (input) input.value = data.url || '';
                
                if (status) {
                    if (data.status === 'approved') {
                        status.textContent = '✓ Approved';
                        status.className = 'badge badge-approved';
                        showSuccess(id, 'Repository approved! Great work.');
                    } else if (data.status === 'rejected') {
                        status.textContent = '✗ Rejected';
                        status.className = 'badge badge-rejected';
                        showWarning(id, data.feedback || 'Please check your code and resubmit.');
                    } else if (data.status === 'submitted') {
                        status.textContent = '⏳ Pending';
                        status.className = 'badge badge-pending';
                    }
                }
            }
        });
    }

    function submitRepo(memberId) {
        const input = document.getElementById(`repo-${memberId}`);
        const url = input.value.trim();
        const status = document.getElementById(`status-${memberId}`);
        
        if (!url.includes('github.com') || url.length < 20) {
            showWarning(memberId, 'Please enter a valid GitHub repository URL.');
            return;
        }
        
        const start = (memberId - 1) * 200 + 1;
        const end = memberId * 200;
        let completed = 0;
        for (let i = start; i <= end; i++) {
            if (completedSteps.has(i)) completed++;
        }
        
        if (completed < 200) {
            showWarning(memberId, `Complete all 200 steps first. Currently: ${completed}/200`);
            return;
        }
        
        repoSubmissions[memberId] = { url, status: 'submitted', feedback: '' };
        localStorage.setItem('repo_submissions', JSON.stringify(repoSubmissions));
        
        status.textContent = '⏳ Pending';
        status.className = 'badge badge-pending';
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
        status.className = 'badge badge-approved';
        hideWarning(memberId);
        showSuccess(memberId, 'Repository approved!');
    }

    function rejectRepo(memberId) {
        const feedbackEl = document.getElementById(`feedback-${memberId}`);
        const feedback = feedbackEl ? feedbackEl.value : 'Please fix the issues and resubmit.';
        
        repoSubmissions[memberId] = { 
            ...repoSubmissions[memberId], 
            status: 'rejected',
            feedback: feedback || 'Please fix the issues and resubmit.'
        };
        localStorage.setItem('repo_submissions', JSON.stringify(repoSubmissions));
        
        const status = document.getElementById(`status-${memberId}`);
        status.textContent = '✗ Rejected';
        status.className = 'badge badge-rejected';
        showWarning(memberId, feedback || 'Please fix the issues and resubmit.');
    }

    function showWarning(memberId, message) {
        const el = document.getElementById(`warning-${memberId}`);
        if (el) {
            el.innerHTML = '⚠️ ' + message;
            el.style.display = 'block';
        }
        const successEl = document.getElementById(`success-${memberId}`);
        if (successEl) successEl.style.display = 'none';
    }

    function hideWarning(memberId) {
        const el = document.getElementById(`warning-${memberId}`);
        if (el) el.style.display = 'none';
    }

    function showSuccess(memberId, message) {
        const el = document.getElementById(`success-${memberId}`);
        if (el) {
            el.innerHTML = '✓ ' + message;
            el.style.display = 'block';
        }
        const warningEl = document.getElementById(`warning-${memberId}`);
        if (warningEl) warningEl.style.display = 'none';
    }
</script>
</body>
</html>
