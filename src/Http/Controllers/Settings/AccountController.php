<?php

namespace Reliqui\Ambulatory\Http\Controllers\Settings;

use Reliqui\Ambulatory\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AccountController
{
    /**
     * Show the user account.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $entry = User::findOrFail($id);

        return response()->json([
            'entry' => $entry->only('id', 'name', 'email', 'avatar'),
        ]);
    }

    /**
     * Update the user account.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $data = [
            'avatar' => request('avatar'),
            'name' => request('name'),
            'email' => request('email'),
        ];

        validator($data, [
            'name' => 'required|string|min:3',
            'email' => 'required|email|'.Rule::unique(config('ambulatory.database_connection').'.ambulatory_users', 'email')->ignore(request('id')),
        ])->validate();

        $entry = User::findOrFail($id);

        if (request('password')) {
            $entry->password = Hash::make(request('password'));
        }

        $entry->fill($data);
        $entry->save();

        return response()->json([
            'entry' => $entry->fresh(),
        ]);
    }
}
