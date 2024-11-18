<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class DateTimePickerLayout extends Component
{
    public $section;
    public function __construct($section)
    {
        $this->section = $section;
    }

    public function render(): View
    {
        return view('components.partials.TextDateTimePicker');
    }
}
