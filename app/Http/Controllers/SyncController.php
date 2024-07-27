<?php

// app/Http/Controllers/SyncController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SyncController extends Controller
{
    public function syncData()
    {
        // Increase max execution time for long-running operations
        ini_set('max_execution_time', 300); // 300 seconds = 5 minutes, adjust as necessary

        try {
            Artisan::call('sync:data');
            return redirect()->back()->with('success', 'Data synchronization completed.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data synchronization failed: ' . $e->getMessage());
        }
    }
}
