<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminActivityController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        $query = DB::table('activity_logs')
            ->leftJoin('users', 'activity_logs.user_id', '=', 'users.id')
            ->select('activity_logs.*', 'users.name as user_name', 'users.email as user_email')
            ->orderBy('activity_logs.created_at', 'desc');
        
        if ($filter === 'today') {
            $query->whereDate('activity_logs.created_at', today());
        } elseif ($filter === '30days') {
            $query->where('activity_logs.created_at', '>=', now()->subDays(30));
        }
        
        $activities = $query->paginate(30);
        
        $todayCount = DB::table('activity_logs')->whereDate('created_at', today())->count();
        $last30DaysCount = DB::table('activity_logs')->where('created_at', '>=', now()->subDays(30))->count();
        $totalCount = DB::table('activity_logs')->count();

        return view('admin.activities.index', compact('activities', 'filter', 'todayCount', 'last30DaysCount', 'totalCount'));
    }
}
