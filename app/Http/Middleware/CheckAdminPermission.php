<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminPermission
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next, $permission) {
    $path = $request->route()->uri;
    $permissions = Session::has('userPermission') ? Session::get('userPermission') : [];

    if(!in_array($permission, $permissions)) {
      return redirect()->route('admin.home.index')->withErrors('No momento, você não tem permissão para acessar esta rota ('.$path.')');
    }

    return $next($request);
  }
}
