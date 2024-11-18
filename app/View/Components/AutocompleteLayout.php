<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;

use Illuminate\Support\Facades\DB;

class AutocompleteLayout extends Component
{
    public $section, $get;
    public $listProvinsi, $listGoldar, $listGender, $listUnit;
    public function __construct($section = null, $get = null)
    {
        $this->section = $section;
        $this->get = $get;

        if ($section = "ssr-dropdown" && $get == 'provinsi') {
            $qry = "SELECT prov.id, prov.name FROM provinsi prov ORDER BY prov.name ASC";
            $this->listProvinsi = DB::select("$qry");
        }

        if ($section = "ssr-dropdown" && $get == 'golongan_darah') {
            $qry = "SELECT goldar.id, goldar.name FROM golongan_darah goldar ORDER BY goldar.name ASC";
            $this->listGoldar = DB::select("$qry");
        }

        if ($section = "ssr-dropdown" && $get == 'gender') {
            $qry = "SELECT gndr.id, gndr.name FROM gender gndr ORDER BY gndr.name ASC";
            $this->listGender = DB::select("$qry");
        }

        if ($section = "ssr-dropdown" && $get == 'unit') {
            $qry = "SELECT unt.id, unt.name FROM unit unt ORDER BY unt.name ASC";
            $this->listUnit = DB::select("$qry");
        }
    }

    public function render(): View
    {
        return view('components.partials.TextAutocomplete');
    }
}
