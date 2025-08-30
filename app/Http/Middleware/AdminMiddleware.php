<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu không đăng nhập và không phải admin thì không được phép truy cập
        if(!Auth::check() || !Auth::user()->isRoleAdmin() ) {
            return redirect()->route('login')->withErrors('Bạn không đủ quyền truy cập vào trang Admin');
        }
        return $next($request);
    }
}
