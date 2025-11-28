<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckOrganizerStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user->role === 'organizer' && $user->organizer_status !== 'berhasil') {
            return redirect()->route('organizer.pending');
        }

        return $next($request);
    }
}