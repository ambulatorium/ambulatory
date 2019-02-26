<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Illuminate\Support\Str;
use Reliqui\Ambulatory\ReliquiInvitation;
use Reliqui\Ambulatory\Http\Middleware\Admin;
use Reliqui\Ambulatory\Http\Requests\InvitationRequest;

class InvitationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(Admin::class);
    }

    /**
     * Get invitations.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = ReliquiInvitation::orderBy('created_at', 'DESC')->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }

    /**
     * Show invitation.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if ($id === 'new') {
            return response()->json([
                'entry' => ReliquiInvitation::make(['id' => Str::uuid()]),
            ]);
        }

        $entry = ReliquiInvitation::findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Store invitation.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InvitationRequest $request, $id)
    {
        $entry = $id !== 'new' ? ReliquiInvitation::findOrFail($id) : new ReliquiInvitation(['id' => request('id')]);

        $entry->fill($request->formInvitation());

        $entry->save();

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Destroy invitation.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $entry = ReliquiInvitation::findOrFail($id);

        $entry->delete();
    }
}