<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;

use Illuminate\Support\Facades\DB;

use App\Traits\Tools;

class InputAddressLayout extends Component
{
    use Tools;

    public $section, $get;
    public $listProvinsi;
    public function __construct($section = null, $get = null)
    {
        $this->section = $section;
        $this->get = $get;

        if ($section = "ssr-dropdown") {
            if ($get == 'provinsi') {
                $qry = "SELECT prov.id, prov.name FROM provinsi prov ORDER BY prov.name ASC";
                $this->listProvinsi = DB::select("$qry");
            }
        }
    }

    public function render(): View
    {
        return view('components.partials.InputAddressLayout');
    }
}
