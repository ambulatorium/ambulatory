<?php

namespace Reliqui\Ambulatory\Http\Controllers\Settings;

use Illuminate\Validation\Rule;

class AccountController
{
    /**
     * Show the user account.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $entry = auth('ambulatory')->user()->only('id', 'name', 'email', 'avatar');

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Update the user account.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $data = [
            'avatar' => request('avatar'),
            'name' => request('name'),
            'email' => request('email'),
        ];

        validator($data, [
            'name' => 'required|string|min:3',
            'email' => 'required|email|'.Rule::unique(config('ambulatory.database_connection').'.reliqui_users', 'email')->ignore(request('id')),
        ])->validate();

        $user = auth('ambulatory')->user();

        $user->update($data);

        return response()->json([
            'entry' => $user->fresh(),
        ]);
    }
}
