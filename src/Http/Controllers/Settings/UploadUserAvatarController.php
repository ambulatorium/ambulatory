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
            request()->image->store('/public/reliqui/images', config('reliqui.storage_disk'))
        );

        return response()->json([
            'url' => '/'.$path,
        ]);
    }
}
