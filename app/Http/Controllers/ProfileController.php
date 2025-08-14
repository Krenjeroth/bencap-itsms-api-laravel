<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function updateStatus(Request $request) {
          $profile = $request->user()->profile;

    if ($profile) {
        $profile->update([
            'status' => Profile::STATUS_ONLINE,
            'last_seen_at' => Carbon::now(),
        ]);
    }

    return response()->json(['message' => 'Heartbeat updated']);
    }
}
