<?php

namespace Ambulatory\Tests\Feature;

use Ambulatory\User;
use Ambulatory\Invitation;
use Ambulatory\Tests\TestCase;
use Ambulatory\Mail\CredentialEmail;
use Ambulatory\Mail\InvitationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageInvitationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_admin_can_manage_the_invitations()
    {
        $invitation = factory(Invitation::class)->create();

        tap($this->signInAsDoctor(), function () use ($invitation) {
            $this->getJson(route('ambulatory.invitations'))->assertStatus(403);
            $this->postJson(route('ambulatory.invitations.store'), [])->assertStatus(403);
            $this->getJson(route('ambulatory.invitations.show', $invitation->id))->assertStatus(403);
            $this->patchJson(route('ambulatory.invitations.update', $invitation->id), [])->assertStatus(403);
            $this->deleteJson(route('ambulatory.invitations.destroy', $invitation->id), [])->assertStatus(403);
        });

        tap($this->signInAsPatient(), function () use ($invitation) {
            $this->getJson(route('ambulatory.invitations'))->assertStatus(403);
            $this->postJson(route('ambulatory.invitations.store'), [])->assertStatus(403);
            $this->getJson(route('ambulatory.invitations.show', $invitation->id))->assertStatus(403);
            $this->patchJson(route('ambulatory.invitations.update', $invitation->id), [])->assertStatus(403);
            $this->deleteJson(route('ambulatory.invitations.destroy', $invitation->id), [])->assertStatus(403);
        });
    }

    /** @test */
    public function admin_can_get_all_the_listing_of_invitations()
    {
        $this->signInAsAdmin();

        $invitation = factory(Invitation::class)->create();

        $this->getJson(route('ambulatory.invitations'))
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'id' => $invitation->id,
                    ],
                ],
                'links' => [],
                'meta' => [],
            ])
            ->assertJsonCount(3); //data,links,meta
    }

    /** @test */
    public function invitation_user_role_is_required()
    {
        $this->signInAsAdmin();

        $invitation = factory(Invitation::class)->raw(['role' => '']);

        $this->postJson(route('ambulatory.invitations.store'), $invitation)
            ->assertStatus(422)
            ->assertJsonValidationErrors('role')
            ->assertExactJson([
                'errors' => [
                    'role' => ['The role field is required.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }

    /** @test */
    public function invitation_email_is_required()
    {
        $this->signInAsAdmin();

        $invitation = factory(Invitation::class)->raw(['email' => '']);

        $this->postJson(route('ambulatory.invitations.store'), $invitation)
            ->assertStatus(422)
            ->assertJsonValidationErrors('email')
            ->assertExactJson([
                'errors' => [
                    'email' => ['The email field is required.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }

    /** @test */
    public function admin_can_create_the_invitation()
    {
        Mail::fake();

        $this->signInAsAdmin();

        $attributes = factory(Invitation::class)->raw();

        $this->postJson(route('ambulatory.invitations.store'), $attributes)
            ->assertStatus(201)
            ->assertJson([
                'email' => $attributes['email'],
                'role' => $attributes['role'],
            ]);

        $this->assertDatabaseHas('ambulatory_invitations', ['email' => $attributes['email']]);

        Mail::assertSent(InvitationEmail::class, function ($mail) use ($attributes) {
            return $mail->hasTo($attributes['email']);
        });
    }

    /** @test */
    public function admin_cannot_create_the_invitation_when_the_email_is_already_exists()
    {
        Mail::fake();

        $this->signInAsAdmin();

        $user = factory(User::class)->create();

        tap(factory(Invitation::class)->raw(['email' => $user->email]), function ($attributes) {
            $this->postJson(route('ambulatory.invitations.store'), $attributes)
                ->assertStatus(422)
                ->assertExactJson([
                    'errors' => [
                        'email' => ['The email has already been taken.'],
                    ],
                    'message' => 'The given data was invalid.',
                ]);
        });

        Mail::assertNothingSent();
    }

    /** @test */
    public function admin_can_get_details_of_the_invitation()
    {
        $this->signInAsAdmin();

        $invitation = factory(Invitation::class)->create();

        $this->getJson(route('ambulatory.invitations.show', $invitation->id))
            ->assertOk()
            ->assertJson([
                'id' => $invitation->id,
                'email' => $invitation->email,
                'role' => $invitation->role,
            ])
            ->assertJsonMissing([
                'token' => $invitation->token,
            ]);
    }

    /** @test */
    public function admin_can_update_the_existing_invitation()
    {
        $this->signInAsAdmin();

        $invitation = factory(Invitation::class)->create();

        $newAttributes = factory(Invitation::class)->raw([
            'email' => 'janedoe@example.com',
        ]);

        Mail::fake();

        $this->patchJson(route('ambulatory.invitations.update', $invitation->id), $newAttributes)
            ->assertOk()
            ->assertJson([
                'email' => $newAttributes['email'],
            ])
            ->assertSessionDoesntHaveErrors();

        $this->assertNotSame($invitation->token, $newAttributes['token']);
        $this->assertNotSame($invitation->email, $newAttributes['email']);

        Mail::assertSent(InvitationEmail::class, function ($mail) use ($newAttributes) {
            return $mail->hasTo($newAttributes['email']);
        });

        Mail::assertNotSent(InvitationEmail::class, function ($mail) use ($invitation) {
            return $mail->hasTo($invitation->email);
        });
    }

    /** @test */
    public function admin_can_delete_the_existing_invitation()
    {
        $this->signInAsAdmin();

        $invitation = factory(Invitation::class)->create();

        $this->assertDatabaseHas('ambulatory_invitations', $invitation->toArray());

        $this->deleteJson(route('ambulatory.invitations.destroy', $invitation->id))
            ->assertStatus(204);

        $this->assertDatabaseMissing('ambulatory_invitations', $invitation->toArray());
    }

    /** @test */
    public function guest_cannot_confirm_their_invitation_with_a_invalid_token()
    {
        Mail::fake();

        $this->get(route('ambulatory.accept.invitation', 'invalid-token'))
            ->assertStatus(404)
            ->assertSessionMissing('invitationAccepted', false);

        Mail::assertNotSent(CredentialEmail::class);
    }

    /** @test */
    public function guest_can_confirm_their_invitation_with_a_valid_token()
    {
        Mail::fake();

        $invitation = factory(Invitation::class)->create();

        $this->get(route('ambulatory.accept.invitation', $invitation->token))
            ->assertRedirect(route('ambulatory.login'))
            ->assertSessionHas('invitationAccepted', true);

        $this->assertDatabaseHas('ambulatory_users', ['email' => $invitation->email]);
        $this->assertDatabaseMissing('ambulatory_invitations', $invitation->toArray());

        Mail::assertSent(CredentialEmail::class, function ($mail) use ($invitation) {
            return $mail->hasTo($invitation->email);
        });
    }
}
