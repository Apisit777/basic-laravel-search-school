<?php

namespace App\Providers\View\Composers;

use Illuminate\View\View;
use App\Models\menu;
use Illuminate\Support\Facades\Auth;

class RouteComposer
{
    public function compose(View $view)
    {
        $authPosition = Auth::user()->getUserPermission->position_id;
        $routeName = menu::with(['getPermissionSubmenus' => function ($query) use ($authPosition) {
                $query->where('menu_relations.position_id', $authPosition)
                ->whereNotNull('submenu_id');
            }])
            ->with(['getMenuRelation' => function ($query) use ($authPosition) {
                $query->where('menu_relations.position_id', $authPosition)
                ->whereNotNull('menu_relations.submenu_id');
            }])
            ->whereHas('getMenuRelation', function ($query) use ($authPosition) {
                $query->where('menu_relations.position_id', $authPosition);
            })
        ->get();

        $view->with([
            'routeName' => $routeName,
        ]);
    }

    private function getCssClass(string $routeName): string 
    {

        $activeRoutes = match ($routeName) {

        };

        return in_array(request()->route()->getName(), $activeRoutes) ? 'rounded-sm bg-primary-100 dark:bg-[#014a77] duration-500' : '';
    }
}
