<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        $query = User::where('is_admin', false)->orderBy('created_at', 'desc');
        
        if ($filter === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($filter === '30days') {
            $query->where('created_at', '>=', now()->subDays(30));
        }
        
        $users = $query->paginate(20);
        
        $todayCount = User::where('is_admin', false)->whereDate('created_at', today())->count();
        $last30DaysCount = User::where('is_admin', false)->where('created_at', '>=', now()->subDays(30))->count();
        $totalCount = User::where('is_admin', false)->count();

        return view('admin.users.index', compact('users', 'filter', 'todayCount', 'last30DaysCount', 'totalCount'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,suspended,blocked',
        ]);

        $user = User::where('is_admin', false)->findOrFail($id);
        $user->update(['status' => $request->status]);

        $statusLabels = [
            'active' => 'Active',
            'suspended' => 'Suspended',
            'blocked' => 'Blocked',
        ];

        return redirect('/admin/users')->with('success', "Status user {$user->name} berhasil diubah menjadi {$statusLabels[$request->status]}.");
    }
}
