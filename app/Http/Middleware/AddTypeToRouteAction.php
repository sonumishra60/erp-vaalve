<?php 
namespace App\Http\Middleware;

use Closure;

class AddTypeToRouteAction
{
    public function handle($request, Closure $next, $type)
    {
        $response = $next($request);
        $route = $request->route();
        if ($route->hasParameter('type')) {
            $type = $route->parameter('type');
            $route->setAction(array_merge($route->getAction(), ['type' => $type]));
        }
        return $response;
    }
}
?>