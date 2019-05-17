<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\Invitation;
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
     * Get all invitations.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = Invitation::latest()->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }

    /**
     * Show the invitation.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $entry = Invitation::findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Store the invitation.
     *
     * @param InvitationRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InvitationRequest $request, $id)
    {
        $entry = $id !== 'new'
            ? Invitation::findOrFail($id)
            : new Invitation();

        $entry->fill($request->validatedFields());
        $entry->save();

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Destroy the invitation.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $entry = Invitation::findOrFail($id);

        $entry->delete();
    }
}
