<?php 
namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterMenu;
use Closure;

class AuthPermisson
{
    public function handle($request, Closure $next)
    {
        $response = $next($request); 
        return $response;
        $route = $request->route();
        if(Auth::user() && Auth::user()->getrole && Auth::user()->getrole->roleGroup){$roleId=Auth::user()->getrole->roleGroup;}else{$roleId=0;}
        if($roleId==1){return $response;} else if($roleId==2){
            if(isValidOrNotForClient($route)){
                return $response;
            }else{
                return redirect('/dashboard');
            }
        }
        else{
            if(isValidOrNot($route)){
                return $response;
            }else{
                return redirect('/dashboard');
            }
        }
    }
}
?>