<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTVUEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // This middleware can be used during registration
        // to ensure only @st.tvu.edu.vn emails are accepted
        
        if ($request->isMethod('post') && $request->has('email')) {
            $email = $request->input('email');
            
            if (!str_ends_with($email, '@st.tvu.edu.vn')) {
                return back()->withErrors([
                    'email' => 'Chỉ chấp nhận email sinh viên có đuôi @st.tvu.edu.vn'
                ])->withInput();
            }
        }

        return $next($request);
    }
}
