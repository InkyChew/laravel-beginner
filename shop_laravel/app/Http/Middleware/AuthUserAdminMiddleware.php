<?php

namespace App\Http\Middleware;

use App\Shop\Entity\User;
use Closure;

class AuthUserAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $is_allow_access = false;
        $user_id = session()->get('user_id');

        if(!is_null($user_id)){
            $User = User::findOrFail($user_id);
            if($User->type == 'A'){
                $is_allow_access = true;
            }
        }

        if(!$is_allow_access){
            return redirect()->to('/');
        }

        return $next($request);
    }
}