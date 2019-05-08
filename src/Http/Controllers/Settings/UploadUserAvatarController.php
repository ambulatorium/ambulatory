<?php

namespace Reliqui\Ambulatory\Http\Controllers\Settings;

class UploadUserAvatarController
{
    /**
     * Upload a new image.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $path = str_replace('public/', 'storage/',
            request()->image->store('/public/ambulatory/images', config('ambulatory.storage_disk'))
        );

        return response()->json([
            'url' => '/'.$path,
        ]);
    }
}
