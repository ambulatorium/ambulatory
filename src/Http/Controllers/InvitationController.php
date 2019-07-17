<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\Invitation;
use Ambulatory\Http\Middleware\Admin;
use Ambulatory\Http\Requests\InvitationRequest;
use Ambulatory\Http\Resources\InvitationResource;

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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $invitations = Invitation::latest()->paginate(25);

        return InvitationResource::collection($invitations);
    }

    /**
     * Store a newly created invitation in storage.
     *
     * @param  InvitationRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function store(InvitationRequest $request)
    {
        $invitation = Invitation::create($request->validatedFields());

        return new InvitationResource($invitation);
    }

    /**
     * Display the specified invitation.
     *
     * @param  Invitation  $invitation
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function show(Invitation $invitation)
    {
        return new InvitationResource($invitation);
    }

    /**
     * Update the specified invitation in storage.
     *
     * @param  InvitationRequest  $request
     * @param  Invitation  $invitation
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function update(InvitationRequest $request, Invitation $invitation)
    {
        $invitation->update($request->validatedFields());

        return new InvitationResource($invitation);
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

        return response()->json(null, 204);
    }
}
