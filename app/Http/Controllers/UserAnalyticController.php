<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAnalyticController extends Controller
{
    public function index(Request $request)
    {
        $this->saveData($request);

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function saveData($request)
    {
        $ip_address = $request->ip();
        $session_id = session()->getId();
        $start_time = now();

        /** Get the user's user agent (browser) */
        $userAgent = $request->header('User-Agent');
        $deviceType = $this->getDeviceType($userAgent);
        $browserType = $this->getBrowserType($userAgent);
        $operatingSystem = $this->getOperatingSystem($userAgent);

        
    }
}
