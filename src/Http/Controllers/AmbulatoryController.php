<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\Ambulatory;

class AmbulatoryController
{
    /**
     * Display the Ambulatory dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('ambulatory::layouts.dashboard', [
            'ambulatoryScriptVariables' => Ambulatory::scriptVariables(),
        ]);
    }
}
