<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\Ambulatory;

class AmbulatoryController
{
    /**
     * Display the Ambulatory view.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('ambulatory::layout', [
            'ambulatoryScriptVariables' => Ambulatory::scriptVariables(),
        ]);
    }
}
