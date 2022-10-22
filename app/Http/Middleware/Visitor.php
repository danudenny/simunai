<?php

namespace App\Http\Middleware;

use App\Visitor as AppVisitor;
use Closure;
use Illuminate\Http\Request;

class Visitor
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
        $ip = $request->ip();
        if (AppVisitor::where('date', today())->where('ip', $ip)->count() < 1)
        {
            AppVisitor::create([
                'date' => today(),
                'ip' => $ip,
            ]);
        }
        return $next($request);
    }
}
