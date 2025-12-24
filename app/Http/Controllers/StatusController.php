<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CmsSetting;

class StatusController extends Controller
{
    public function index()
    {
        $maintenanceMode = CmsSetting::where('key', 'maintenance_mode')->first();
        $isMaintenanceMode = $maintenanceMode && $maintenanceMode->value === 'true';
        
        return view('maintenance_control', compact('isMaintenanceMode'));
    }

    public function toggle(Request $request)
    {
        $setting = CmsSetting::firstOrCreate(
            ['key' => 'maintenance_mode'],
            ['value' => 'false', 'type' => 'boolean']
        );

        $setting->value = $setting->value === 'true' ? 'false' : 'true';
        $setting->save();

        return redirect('/maintenance')->with('success', 'Maintenance mode ' . ($setting->value === 'true' ? 'activated' : 'deactivated'));
    }
}
