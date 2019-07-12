<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\Invitation;
use Ambulatory\Http\Middleware\Admin;
use Ambulatory\Http\Requests\InvitationRequest;

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
     * Display a listing of the invitations.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $invitations = Invitation::latest()->paginate(25);

        return response()->json([
            'entries' => $invitations,
        ]);
    }

    /**
     * Store a newly created invitation in storage.
     *
     * @param  InvitationRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InvitationRequest $request)
    {
        $invitation = Invitation::create($request->validatedFields());

        return response()->json([
            'entry' => $invitation,
        ]);
    }

    /**
     * Display the specified invitation.
     *
     * @param  Invitation  $invitation
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Invitation $invitation)
    {
        return response()->json([
            'entry' => $invitation,
        ]);
    }

    /**
     * Update the specified invitation in storage.
     *
     * @param  InvitationRequest  $request
     * @param  Invitation  $invitation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InvitationRequest $request, Invitation $invitation)
    {
        $invitation->update($request->validatedFields());

        return response()->json([
            'entry' => $invitation,
        ]);
    }

    /**
     * Remove the specified invitation from storage.
     *
     * @param  Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invitation $invitation)
    {
        $invitation->delete();
    }
}
