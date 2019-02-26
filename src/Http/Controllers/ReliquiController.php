<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\Reliqui;

class ReliquiController
{
    /**
     * Display the Reliqui view.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('reliqui::layout', [
            'reliquiScriptVariables' => Reliqui::scriptVariables(),
        ]);
    }
}
