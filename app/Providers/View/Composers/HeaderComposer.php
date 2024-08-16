<?php

namespace App\Providers\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class HeaderComposer
{
    public function compose(View $view)
    {
        $navLinks = collect(
            [
                'title' => 'Home',
                'icon' => 'Home',
                'routeName' => 'home',
                'cssClass' => $this->getCssClass('home')
            ]
        );

        $view->with([
            'navLinks' => $navLinks,
        ]);
    }

    private function getCssClass(string $routeName): string 
    {
        $activeRoutes = match ($routeName) {
            'home' => ['home'],
            default => []
        };

        return in_array(request()->route()->getName(), $activeRoutes) ? 'rounded-sm bg-primary-100 dark:bg-[#014a77] duration-500' : '';
    }
}
