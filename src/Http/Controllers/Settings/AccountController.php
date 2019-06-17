<?php

namespace Reliqui\Ambulatory\Http\Controllers\Settings;

use Reliqui\Ambulatory\Http\Requests\AccountRequest;

class AccountController
{
    /**
     * Show the user account.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if ($id !== auth('ambulatory')->id()) {
            return abort(404);
        }

        return response()->json([
            'entry' => auth('ambulatory')->user()->only('id', 'name', 'email', 'avatar'),
        ]);
    }

    /**
     * Update the user account.
     *
     * @param  AccountRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AccountRequest $request, $id)
    {
        if ($id !== auth('ambulatory')->id()) {
            return abort(404);
        }

        $user = auth('ambulatory')->user();

        $user->update($request->validated());

        return response()->json([
            'entry' => $user->fresh(),
        ]);
    }
}
