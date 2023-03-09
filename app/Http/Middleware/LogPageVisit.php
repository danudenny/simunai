<?php

namespace App\Http\Middleware;

use App\PageVisitor;
use Closure;

class LogPageVisit
{
   public function handle($request, Closure $next)
    {
        $lastVisitor = PageVisitor::latest()->first();
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        // Only insert data if IP address or user agent is different
        if (!$lastVisitor || $lastVisitor->ip_address !== $ipAddress || $lastVisitor->user_agent !== $userAgent) {
            $pageVisitor = new PageVisitor();
            $pageVisitor->ip_address = $ipAddress;
            $pageVisitor->user_agent = $userAgent;
            $pageVisitor->visited_at = now();
            $pageVisitor->save();
        }

        return $next($request);
    }
}
