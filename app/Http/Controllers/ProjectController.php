<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $steps = $this->generateAllSteps();
        
        $members = [
            [
                'id' => 1,
                'name' => 'Edo',
                'role' => 'Project Lead & Core Backend',
                'email' => 'pedoprimasaragi@gmail.com',
                'steps' => array_filter($steps, fn($s) => $s['step'] >= 1 && $s['step'] <= 200),
            ],
            [
                'id' => 2,
                'name' => 'Haidar',
                'role' => 'Database & Admin Panel',
                'email' => 'haiidarmirza8289@gmail.com',
                'steps' => array_filter($steps, fn($s) => $s['step'] >= 201 && $s['step'] <= 400),
            ],
            [
                'id' => 3,
                'name' => 'Dimas',
                'role' => 'Features & Customer Logic',
                'email' => 'dimasaryadesta2@gmail.com',
                'steps' => array_filter($steps, fn($s) => $s['step'] >= 401 && $s['step'] <= 600),
            ],
            [
                'id' => 4,
                'name' => 'Bernard',
                'role' => 'UI & Public Pages',
                'email' => 'bernardprawira54@gmail.com',
                'steps' => array_filter($steps, fn($s) => $s['step'] >= 601 && $s['step'] <= 800),
            ],
        ];

        return view('project.index', compact('members'));
    }

    public function getProgress()
    {
        $progress = DB::table('project_progress')->first();
        $updates = $this->getGitUpdates();
        
        if (!$progress) {
            return response()->json([
                'completed_steps' => [],
                'repo_submissions' => [],
                'updates' => $updates,
                'updated_at' => now()->toISOString()
            ]);
        }

        return response()->json([
            'completed_steps' => json_decode($progress->completed_steps, true) ?? [],
            'repo_submissions' => json_decode($progress->repo_submissions, true) ?? [],
            'updates' => $updates,
            'updated_at' => $progress->updated_at
        ]);
    }

    private function getGitUpdates(): array
    {
        $cacheKey = 'github_commits_cache';
        $cached = cache()->get($cacheKey);
        
        if ($cached !== null) {
            return $cached;
        }
        
        $updates = [];
        
        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'User-Agent' => 'Culinaire-Laravel-App',
                'Accept' => 'application/vnd.github.v3+json',
            ])->timeout(8)->get('https://api.github.com/repos/Qwerty1508/Website-Restaurant/commits', [
                'per_page' => 15
            ]);
            
            if ($response->successful()) {
                $commits = $response->json();
                $id = 1;
                
                foreach ($commits as $commit) {
                    $message = $commit['commit']['message'] ?? 'No message';
                    $firstLine = explode("\n", $message)[0];
                    $date = isset($commit['commit']['committer']['date']) 
                        ? date('Y-m-d', strtotime($commit['commit']['committer']['date'])) 
                        : date('Y-m-d');
                    $sha = substr($commit['sha'] ?? '', 0, 7);
                    
                    $updateType = 'commit';
                    if (str_starts_with($firstLine, 'feat:') || str_starts_with($firstLine, 'feat(')) $updateType = 'feature';
                    else if (str_starts_with($firstLine, 'fix:') || str_starts_with($firstLine, 'fix(')) $updateType = 'fix';
                    else if (str_starts_with($firstLine, 'style:')) $updateType = 'style';
                    else if (str_starts_with($firstLine, 'chore:')) $updateType = 'chore';
                    else if (str_starts_with($firstLine, 'docs:')) $updateType = 'docs';
                    
                    $updates[] = [
                        'id' => $id++,
                        'title' => $firstLine,
                        'description' => 'Commit ' . $sha . ' • ' . $date,
                        'file_path' => 'github.com/Qwerty1508/Website-Restaurant',
                        'update_type' => $updateType,
                        'update_date' => $date,
                    ];
                }
                
                cache()->put($cacheKey, $updates, now()->addMinutes(5));
                return $updates;
            }
        } catch (\Exception $e) {
        }
        
        try {
            $dbUpdates = DB::table('project_updates')
                ->orderBy('update_date', 'desc')
                ->orderBy('id', 'desc')
                ->limit(15)
                ->get();
            
            if ($dbUpdates->count() > 0) {
                $id = 1;
                foreach ($dbUpdates as $update) {
                    $updates[] = [
                        'id' => $id++,
                        'title' => $update->title,
                        'description' => $update->description,
                        'file_path' => $update->file_path,
                        'update_type' => $update->update_type,
                        'update_date' => $update->update_date,
                    ];
                }
                return $updates;
            }
        } catch (\Exception $e) {
        }
        
        return [
            ['id' => 1, 'title' => 'feat: GitHub API + Database Fallback', 'description' => 'Implementasi sistem hybrid untuk Code Updates', 'file_path' => 'app/Http/Controllers/ProjectController.php', 'update_type' => 'feature', 'update_date' => date('Y-m-d')],
            ['id' => 2, 'title' => 'fix: unlock Code Updates section', 'description' => 'Section Code Updates sekarang selalu terbuka', 'file_path' => 'resources/views/project/index.blade.php', 'update_type' => 'fix', 'update_date' => date('Y-m-d')],
        ];
    }

    public function saveProgress(Request $request)
    {
        $completedSteps = $request->input('completed_steps', []);
        $repoSubmissions = $request->input('repo_submissions', []);

        $exists = DB::table('project_progress')->exists();

        if ($exists) {
            DB::table('project_progress')->update([
                'completed_steps' => json_encode($completedSteps),
                'repo_submissions' => json_encode($repoSubmissions),
                'updated_at' => now()
            ]);
        } else {
            DB::table('project_progress')->insert([
                'completed_steps' => json_encode($completedSteps),
                'repo_submissions' => json_encode($repoSubmissions),
                'updated_at' => now()
            ]);
        }

        return response()->json(['success' => true, 'updated_at' => now()->toISOString()]);
    }

    public function getUpdates()
    {
        $updates = DB::table('project_updates')->orderBy('id', 'desc')->get();
        return response()->json(['updates' => $updates]);
    }

    private function generateAllSteps(): array
    {
        $steps = [];
        $stepNumber = 1;

        $edoFiles = [
            '.env.example',
            'composer.json',
            'package.json',
            'vite.config.js',
            'config/app.php',
            'config/database.php',
            'config/auth.php',
            'bootstrap/app.php',
            'app/Models/User.php',
            'app/Http/Controllers/Auth/AuthController.php',
            'app/Http/Controllers/Auth/GoogleController.php',
            'resources/views/layouts/guest.blade.php',
            'resources/views/auth/login.blade.php',
            'resources/views/auth/register.blade.php',
        ];
        $stepNumber = $this->processFilesIntoSteps($edoFiles, $steps, $stepNumber, 200);

        $haidarFiles = [
            'database/migrations/0001_01_01_000000_create_users_table.php',
            'database/migrations/0001_01_01_000001_create_cache_table.php',
            'database/migrations/0001_01_01_000002_create_jobs_table.php',
            'database/migrations/2025_12_16_035649_add_google_id_to_users_table.php',
            'database/migrations/2025_12_16_044126_add_is_admin_to_users_table.php',
            'database/migrations/2025_12_16_044137_create_menus_table.php',
            'database/migrations/2025_12_16_044139_create_activity_logs_table.php',
            'database/migrations/2025_12_16_050152_add_status_to_users_table.php',
            'database/migrations/2025_12_16_053030_create_reservations_table.php',
            'database/migrations/2025_12_17_151701_add_slug_to_menus_table.php',
            'database/migrations/2025_12_18_000001_create_orders_table.php',
            'app/Models/Menu.php',
            'app/Models/Reservation.php',
            'app/Models/Order.php',
            'resources/views/layouts/admin.blade.php',
            'resources/views/admin/dashboard.blade.php',
            'resources/views/admin/menus/index.blade.php',
            'resources/views/admin/menus/create.blade.php',
            'resources/views/admin/menus/edit.blade.php',
            'resources/views/admin/users/index.blade.php',
            'resources/views/admin/orders/index.blade.php',
            'resources/views/admin/orders/show.blade.php',
            'resources/views/admin/reservations/index.blade.php',
            'resources/views/admin/reservations/show.blade.php',
        ];
        $stepNumber = $this->processFilesIntoSteps($haidarFiles, $steps, $stepNumber, 400);

        $dimasFiles = [
            'app/Http/Controllers/ReservationController.php',
            'app/Http/Controllers/OrderController.php',
            'resources/views/reservation/create.blade.php',
            'resources/views/menu/index.blade.php',
            'resources/views/customer/dashboard.blade.php',
            'resources/views/customer/profile.blade.php',
            'resources/views/customer/orders/index.blade.php',
            'resources/views/customer/orders/create.blade.php',
            'resources/views/customer/orders/show.blade.php',
            'resources/views/customer/reservations/index.blade.php',
            'resources/views/customer/reservations/show.blade.php',
        ];
        $stepNumber = $this->processFilesIntoSteps($dimasFiles, $steps, $stepNumber, 600);

        $bernardFiles = [
            'resources/views/welcome.blade.php',
            'resources/views/about.blade.php',
            'resources/views/contact.blade.php',
            'resources/views/components/navbar.blade.php',
            'resources/views/components/footer.blade.php',
            'public/css/app.css',
            'public/js/cursor.js',
        ];
        $stepNumber = $this->processFilesIntoSteps($bernardFiles, $steps, $stepNumber, 800);

        return $steps;
    }

    private function processFilesIntoSteps(array $files, array &$steps, int $startStep, int $maxStep): int
    {
        $currentStep = $startStep;
        $targetSteps = $maxStep - $startStep + 1;
        
        $allFileContents = [];
        $totalLines = 0;
        
        foreach ($files as $filePath) {
            $absolutePath = base_path($filePath);
            if (File::exists($absolutePath)) {
                $content = File::get($absolutePath);
                $lines = explode("\n", $content);
                $allFileContents[$filePath] = $lines;
                $totalLines += count($lines);
            }
        }

        if ($totalLines === 0) {
            return $currentStep;
        }

        $linesPerStep = max(1, ceil($totalLines / $targetSteps));

        foreach ($allFileContents as $filePath => $lines) {
            $lineCount = count($lines);
            $currentLine = 0;

            while ($currentLine < $lineCount && $currentStep <= $maxStep) {
                $endLine = min($currentLine + $linesPerStep, $lineCount);
                $chunk = array_slice($lines, $currentLine, $endLine - $currentLine);
                $codeContent = implode("\n", $chunk);

                if (trim($codeContent) !== '') {
                    $steps[] = [
                        'step' => $currentStep,
                        'file' => $filePath,
                        'line_start' => $currentLine + 1,
                        'line_end' => $endLine,
                        'code' => $codeContent,
                        'action' => $currentLine === 0 ? 'Create file and add' : 'Continue adding',
                    ];
                    $currentStep++;
                }

                $currentLine = $endLine;
            }
        }

        while ($currentStep <= $maxStep) {
            $steps[] = [
                'step' => $currentStep,
                'file' => 'N/A',
                'line_start' => 0,
                'line_end' => 0,
                'code' => 'Step reserved for future expansion',
                'action' => 'Reserved',
            ];
            $currentStep++;
        }

        return $currentStep;
    }
}

