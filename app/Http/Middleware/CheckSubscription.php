<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            
            $subscription = Subscription::where('member_id', $user->id)
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->first();

            if (!$subscription) {
            
                return response()->json(['error' => 'Subscription expired or not found. Please renew your subscription.'], 403);
            }
        }

        return $next($request);
    }
}
