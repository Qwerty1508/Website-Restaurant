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
        
        $maintenanceStartTime = null;
        if ($isMaintenanceMode) {
            $startSetting = CmsSetting::where('key', 'maintenance_start_time')->first();
            $maintenanceStartTime = $startSetting ? $startSetting->value : null;
        }
        
        return view('maintenance_control', compact('isMaintenanceMode', 'maintenanceStartTime'));
    }

    public function toggle(Request $request)
    {
        $setting = CmsSetting::firstOrCreate(
            ['key' => 'maintenance_mode'],
            ['value' => 'false', 'type' => 'boolean']
        );

        $newValue = $setting->value === 'true' ? 'false' : 'true';
        $setting->value = $newValue;
        $setting->save();

        // Track start time when turning ON
        if ($newValue === 'true') {
            CmsSetting::updateOrCreate(
                ['key' => 'maintenance_start_time'],
                ['value' => now()->toISOString(), 'type' => 'string']
            );
        } else {
            // Clear start time when turning OFF
            CmsSetting::where('key', 'maintenance_start_time')->delete();
        }

        return redirect('/maintenance')->with('success', 'Maintenance mode ' . ($newValue === 'true' ? 'activated' : 'deactivated'));
    }
}
