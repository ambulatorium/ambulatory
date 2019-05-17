<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\User;
use Reliqui\Ambulatory\Http\Middleware\Admin;

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
     * Get staff.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = User::whereNotIn('type', [User::PATIENT])->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }
}
