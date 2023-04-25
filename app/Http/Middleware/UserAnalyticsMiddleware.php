<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAnalyticsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // If the user is authenticated
        if(Auth::check()) {
            $user = auth()->user();
            $sessionId = session()->getId();
            $url = $request->fullUrl();

            /** Get the user's user agent (browser) */
            $userAgent = $request->header('User-Agent');

            $deviceTypeAndName = $this->getDeviceTypeAndName($userAgent);
            $device_type = $deviceTypeAndName[0];
            $device_name = $deviceTypeAndName[1];

            $browser_type = $this->getBrowserType($userAgent);
            $operating_system = $this->getOperatingSystemType($userAgent);

            // Get the user analytic record for the current session
            $product = Product::first();
            $userAnalytic = $user->analytics()
                ->where('user_id', $user->id)
                ->where('session_id', $sessionId)
                ->orderBy('created_at', 'desc')
                ->first();

                // If there is no user analytic record for the current session, create a new one
            if (!$userAnalytic) {
                $userAnalytic = $user->analytics()->create([
                    'user_id' => $user->id,
                    'ip_address' => $request->ip(),
                    'session_id' => $sessionId,
                    'start_time' => now(),
                    'end_time' => null,
                    'page_views' => 1,
                    'unique_page_views' => 1,
                    'visited_pages' => json_encode([$url]),
                    'unique_visited_pages' => json_encode([$url]),
                    'device_type' => $device_type,
                    'device_name' => $device_name,
                    'browser_type' => $browser_type,
                    'operating_system' => $operating_system,
                    'location' => null,
                ]);
            } else {
                // Increment the page view count and update the visited pages array
                $userAnalytic->page_views++;
                
                $visitedPages = json_decode($userAnalytic->visited_pages);
                $uniqueVisitedPages = json_decode($userAnalytic->unique_visited_pages);
                
                $visitedPages[] = $url;
                if(!in_array($url, $uniqueVisitedPages)) 
                {
                    $userAnalytic->unique_page_views++;
                    $uniqueVisitedPages[] = $url;
                }

                $userAnalytic->visited_pages = json_encode($visitedPages);
                $userAnalytic->unique_visited_pages = json_encode($uniqueVisitedPages);

                $userAnalytic->end_time = now();
            }

            // Update the user analytic record
            $userAnalytic->save();
        }

        return $response;
    }

    /**
     * Parse the User-Agent HTTP header to get the device type
     * Example: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36
     * 
     * @param string $userAgent
     * @return array $deviceTypeAndName
     */
    protected function getDeviceTypeAndName(string $userAgent)
    {
        if (preg_match('/\b(iPhone|iPad|iPod|Android|BlackBerry|IEMobile)\b/', $userAgent, $matches)) {
            $deviceTypeAndName[] = 'Mobile';
            $deviceTypeAndName[] = $matches[0];
        } elseif (preg_match('/\b(Windows Phone|Windows|Macintosh|Linux|Ubuntu)\b/', $userAgent, $matches)) {
            $deviceTypeAndName[] = 'Desktop';
            $deviceTypeAndName[] = $matches[0];
        } else {
            $deviceTypeAndName[] = 'Unknown';
            $deviceTypeAndName[] = 'Unknown';
        }
        return $deviceTypeAndName;
    }

    /**
     * Parse the User-Agent HTTP header to get the device type
     * Example: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36
     * 
     * @param string $userAgent
     * @return string $browserType
     */
    protected function getBrowserType(string $userAgent)
    {
        if (preg_match('/\b(Chrome)\b/', $userAgent)) {
            $browserType = 'Chrome';
        } elseif (preg_match('/\b(Safari)\b/', $userAgent)) {
            $browserType = 'Safari';
        } elseif (preg_match('/\b(Firefox)\b/', $userAgent)) {
            $browserType = 'Firefox';
        } elseif (preg_match('/\b(IE|MSIE|Trident)\b/', $userAgent)) {
            $browserType = 'Internet Explorer';
        } elseif (preg_match('/\b(Edge)\b/', $userAgent)) {
            $browserType = 'Edge';
        } elseif (preg_match('/\b(Opera)\b/', $userAgent)) {
            $browserType = 'Opera';
        }
        return $browserType;
    }

    /**
     * Parse the User-Agent HTTP header to get the device type
     * Example: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36
     * 
     * @param string $userAgent
     * @return string $osType
     */
    protected function getOperatingSystemType(string $userAgent)
    {
        if (preg_match('/\b(Windows NT 10.0)\b/', $userAgent)) {
            $osType = 'Windows 10';
        } elseif (preg_match('/\b(Windows NT 6.3)\b/', $userAgent)) {
            $osType = 'Windows 8.1';
        } elseif (preg_match('/\b(Windows NT 6.2)\b/', $userAgent)) {
            $osType = 'Windows 8';
        } elseif (preg_match('/\b(Windows NT 6.1)\b/', $userAgent)) {
            $osType = 'Windows 7';
        } elseif (preg_match('/\b(Windows NT 6.0)\b/', $userAgent)) {
            $osType = 'Windows Vista';
        } elseif (preg_match('/\b(Windows NT 5.1|Windows XP)\b/', $userAgent)) {
            $osType = 'Windows XP';
        } elseif (preg_match('/\b(Mac OS X)\b/', $userAgent)) {
            $osType = 'Mac OS X';
        } elseif (preg_match('/\b(Linux)\b/', $userAgent)) {
            $osType = 'Linux';
        }
        return $osType;
    }
}

