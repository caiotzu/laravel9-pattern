<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Authenticate {
  public function handle($request, Closure $next) {
    $rolePath = $request->route()->action['prefix'];

    if(in_array($rolePath, ['/admin'])) {
      if(Auth::guard('admin')->check()) {
        return $next($request);
      } else {
        return redirect('admin');
      }
    } else {
      if(Auth::guard('web')->check()) {
        return $next($request);
      } else {
        return redirect('login');
      }
    }
  }
}
