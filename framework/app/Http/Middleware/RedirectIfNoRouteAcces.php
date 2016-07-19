<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AppMenu;
use Sentinel, Carbon\Carbon;

class RedirectIfNoRouteAcces
{
    public function __construct(AppMenu $appmenu) {
        $this->appmenu = $appmenu;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $usrLogIn = Sentinel::getUser();
        $hasAcces=0;
        if($usrLogIn) {
            $grpId= $usrLogIn->getRoles()[0]->id;

            $hasAcces = $this->appmenu->join('appmenu_role', 'appmenu.menu_id','=','appmenu_role.appmenu_id')
                    ->whereRoleId($grpId)
                    ->where(function($qNull) {
                        $qNull->whereNotNull('menu_alias');
                        $qNull->orWhereNotNull('menu_url');
                    })
                    ->where(function($qWhere) {
                        $qWhere->whereMenuAlias(\Route::currentRouteName());
                        $qWhere->orWhere('menu_url',\Route::current()->getUri());
                    })
                    ->count();
        }

        if($hasAcces < 1){
            return \Redirect::to('dashboard')->with('errorMessage', 'You dont have access this page!');
        }

        return $next($request);
    }
}
