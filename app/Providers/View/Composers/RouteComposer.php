<?php

namespace App\Providers\View\Composers;

use Illuminate\View\View;
use App\Models\menu;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RouteComposer
{
    public function compose(View $view)
    {
        // dd(Auth::user());
        // dd(session('role'));
        // if ( Auth::check() ) {
        //     $id = Auth::user()->id;
        //     if (Auth::user()->getUserPermission != null) {
        //         $userPermission = Auth::user()->getUserPermission->name_position;
        //         $authPosition = User::where('id', $id)->first()->getUserPermission->position_id;
        //         $routeName = menu::with(['getPermissionSubmenus' => function ($query) use ($authPosition) {
        //                 $query->where('menu_relations.position_id', $authPosition)
        //                 ->whereNotNull('submenu_id');
        //             }])
        //             ->with(['getMenuRelation' => function ($query) use ($authPosition) {
        //                 $query->where('menu_relations.position_id', $authPosition)
        //                 ->whereNotNull('menu_relations.submenu_id');
        //             }])
        //             ->whereHas('getMenuRelation', function ($query) use ($authPosition) {
        //                 $query->where('menu_relations.position_id', $authPosition);
        //             })
        //         ->get();
        
        //         $view->with([
        //             'routeName' => $routeName,
        //             'authPosition' => $authPosition,
        //             'userPermission' => $userPermission,
        //         ]);
        //     } else {
        //         $view->with([
        //             'routeName' => [],
        //             'authPosition' => [],
        //             'userPermission' => [],
        //         ]);
        //     }
        // } else {          
        //     $view->with([
        //         'routeName' => [],
        //         'authPosition' => [],
        //         'userPermission' => [],
        //     ]);
        // }
        // dd($userPermission);

        $routeName = [];
        $authPosition = null;
        $userPermission = null;

        if (Auth::check() && Auth::user()->getUserPermission != null) {
            $id = Auth::user()->id;
            $userPermission = optional(Auth::user()->getUserPermission)->name_position;
            $authPosition = Auth::user()->getUserPermission->position_id;

            $routeName = menu::with([
                'getPermissionSubmenus' => function ($query) use ($authPosition) {
                    $query->where('menu_relations.position_id', $authPosition)
                        ->whereNotNull('submenu_id');
                },
                'getMenuRelation' => function ($query) use ($authPosition) {
                    $query->where('menu_relations.position_id', $authPosition)
                        ->whereNotNull('menu_relations.submenu_id');
                }
            ])
            ->whereHas('getMenuRelation', function ($query) use ($authPosition) {
                $query->where('menu_relations.position_id', $authPosition);
            })
            ->get();
        }

        // dd($routeName);
        $view->with([
            'routeName' => $routeName,
            'authPosition' => $authPosition,
            'userPermission' => $userPermission,
        ]);
    }
}
