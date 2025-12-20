<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReservationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        $query = DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->select('reservations.*', 'users.name as user_name', 'users.email as user_email')
            ->orderBy('reservations.created_at', 'desc');

        if ($filter === 'pending') {
            $query->where('reservations.status', 'pending');
        } elseif ($filter === 'accepted') {
            $query->where('reservations.status', 'accepted');
        } elseif ($filter === 'rejected') {
            $query->where('reservations.status', 'rejected');
        } elseif ($filter === 'today') {
            $query->whereDate('reservations.date', today());
        }

        $reservations = $query->paginate(20);

        $pendingCount = DB::table('reservations')->where('status', 'pending')->count();
        $acceptedCount = DB::table('reservations')->where('status', 'accepted')->count();
        $rejectedCount = DB::table('reservations')->where('status', 'rejected')->count();
        $todayCount = DB::table('reservations')->whereDate('date', today())->count();

        return view('admin.reservations.index', compact(
            'reservations', 'filter', 'pendingCount', 'acceptedCount', 'rejectedCount', 'todayCount'
        ));
    }

    public function show($id)
    {
        $reservation = DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->select('reservations.*', 'users.name as user_name', 'users.email as user_email')
            ->where('reservations.id', $id)
            ->first();

        if (!$reservation) {
            abort(404);
        }

        return view('admin.reservations.show', compact('reservation'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $reservation = DB::table('reservations')->where('id', $id)->first();
        
        if (!$reservation) {
            abort(404);
        }

        DB::table('reservations')->where('id', $id)->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'updated_at' => now(),
        ]);

        $statusLabels = [
            'pending' => 'Pending',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
        ];

        return redirect('/admin/reservations')->with('success', "Status reservasi #{$id} berhasil diubah menjadi {$statusLabels[$request->status]}.");
    }
}
