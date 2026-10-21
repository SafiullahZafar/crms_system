<?php

namespace App\Http\Middleware;

use App\Models\ModuleSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class EnsureModuleEnabled
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $audience = $request->routeIs('demo.*') ? 'demo' : 'admin';
        $enabledModules = ModuleSetting::enabledFor($audience);

        if ($audience === 'admin' && $request->user()?->isSuperAdmin()) {
            $enabledModules = array_fill_keys(array_keys(ModuleSetting::MODULES), true);
        }

        View::share('enabledModules', $enabledModules);

        if (! ($enabledModules[$module] ?? false)) {
            if ($audience === 'admin' && $module === 'dashboard' && $request->user()?->isAdmin()) {
                $landingModule = array_search(true, $enabledModules, true);

                if (is_string($landingModule) && $landingModule !== 'dashboard') {
                    return redirect()->route($landingModule);
                }
            }

            abort(404);
        }

        return $next($request);
    }
}
