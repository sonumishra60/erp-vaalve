<?php

namespace App\Providers;

use App\Models\MasterData;
use App\Models\MasterMenu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class SidebarComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */ 
    public function boot(): void
    {
        View::composer('layouts.sidebar', function ($view) {
            if (Auth::check()){
            $check_menu=Auth::user();
            $sidebarMenu=[];
            if($check_menu && $check_menu->getrole && $check_menu->getrole->roleGroup){$roleId=$check_menu->getrole->roleGroup;}
            if($roleId==2){$menus = MasterData::where('status',1)->where('dataType',1)->get();}
            else{$menus = MasterData::where('status',1)->get();}
            
            $sidebar = MasterData::with('masterMenu')->where('status',1)->where('groupName',1)->get();
            foreach ($sidebar as $masterData) {
                $mainMenuItems = [];
                $mainMenu = MasterMenu::where('status',1)->where('masterDataId_fk',$masterData->masterDataId)->whereNull('parentId')->orderBy('displayOrder','ASC')->get();
                foreach ($mainMenu as $main_menu) {
                    if(($check_menu->menuaccessdata->contains('userMenuId_fk', $main_menu->masterMenuId) || getRoleGroupByRoleId(Auth::user()['roleId_fk'])==1)){
                    $subMenuItems = [];
                    $subMenus = MasterMenu::where('status', 1)->where('parentId', $main_menu->masterMenuId)->get();

                    foreach ($subMenus as $subMenu) {
                        $subMenuItems[] = [
                            'title' => $subMenu->name,
                            'url' => $subMenu->accessUrl,
                            'iconImage' => $subMenu->profileImages,
                        ];
                }
                $mainMenuItems[] = [
                    'title' => $main_menu->name,
                    'url' => $main_menu->accessUrl,
                    'subMenuItems' => $subMenuItems,
                    'iconImage' => $main_menu->profileImages,
                ];
            }
        }
    }
            $view->with(['primary_menu'=>$menus,'sidebar' => $mainMenuItems]);
            }
        });
    }
}