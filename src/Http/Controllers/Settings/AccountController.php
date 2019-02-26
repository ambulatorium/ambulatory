<?php

namespace Reliqui\Ambulatory\Http\Controllers\Settings;

use Illuminate\Validation\Rule;
use Reliqui\Ambulatory\ReliquiUsers;
use Illuminate\Support\Facades\Hash;

class AccountController
{
    /**
     * Show account.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $entry = ReliquiUsers::findOrFail($id);

        return response()->json([
            'entry' => $entry->only('id', 'name', 'email', 'avatar'),
        ]);
    }

    /**
     * Update account.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $data = [
            'avatar' => request('avatar'),
            'name'   => request('name'),
            'email'  => request('email')
        ];

        validator($data, [
            'name'  => 'required|string|min:3',
            'email' => 'required|email|'.Rule::unique(config('reliqui.database_connection').'.reliqui_users', 'email')->ignore(request('id')),
        ])->validate();

        $entry = ReliquiUsers::findOrFail($id);

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
