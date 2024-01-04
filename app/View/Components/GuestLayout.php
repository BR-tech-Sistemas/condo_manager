<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GuestLayout extends Component
{
    public string $appName;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->appName = 'Sistema de gerenciamento de Condomínios';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.guest');
    }
}
