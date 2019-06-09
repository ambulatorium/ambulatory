<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\Availability;
use Reliqui\Ambulatory\Http\Middleware\VerifiedDoctor;
use Reliqui\Ambulatory\Http\Requests\AvailabilityRequest;

class AvailabilityController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(VerifiedDoctor::class);
    }

    /**
     * Update the specified availability in storage.
     *
     * @param  Availability  $availability
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AvailabilityRequest $request, Availability $availability)
    {
        $this->authorize('manage', $availability);

        $availability->update($request->validated());

        return response()->json([
            'entry' => $availability,
        ]);
    }
}
