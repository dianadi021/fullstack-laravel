<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class HeaderMainMenuLayout extends Component
{
    public $listMenu;
    public function __construct()
    {
        $qry = "SELECT * FROM list_menus lsmenu ORDER BY lsmenu.name ASC";
        $this->listMenu = DB::select("$qry");
    }

    public function render(): View
    {
        return view('components.partials.HeaderMainMenuLayout');
    }
}
