<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class DropdownMenuLayout extends Component
{
    public $listMenu;
    public function __construct($parent)
    {
        $result = (isset($parent) && !empty($parent) ? DB::select("SELECT * FROM list_menus lsmenu WHERE lsmenu.id_parent = $parent ORDER BY lsmenu.name ASC") : []);
        $this->listMenu = $result;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.partials.CustomizeDropdownMenuLayout');
    }
}
