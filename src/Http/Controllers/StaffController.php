<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\ReliquiUsers;
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
        $entries = ReliquiUsers::whereNotIn('type', [ReliquiUsers::DEFAULT])->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }
}
