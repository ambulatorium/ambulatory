<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\User;
use Ambulatory\Http\Middleware\Admin;
use Ambulatory\Http\Resources\UserResource;

class StaffController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(Admin::class);
    }

    /**
     * Display a listing of the staff.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $staff = User::whereNotIn('type', [User::PATIENT])->latest()->paginate(25);

        return UserResource::collection($staff);
    }
}
