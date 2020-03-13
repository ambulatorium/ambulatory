<?php

namespace Ambulatory\Http\Controllers\Settings;

use Ambulatory\Http\Requests\AccountRequest;
use Ambulatory\Http\Resources\UserResource;

class AccountController
{
    /**
     * Show the user account.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return new UserResource(auth('ambulatory')->user());
    }

    /**
     * Update the user account.
     *
     * @param  AccountRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function update(AccountRequest $request)
    {
        auth('ambulatory')->user()->update($request->validated());

        return new UserResource(auth('ambulatory')->user());
    }
}
