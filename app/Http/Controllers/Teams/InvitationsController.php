<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use App\Mail\SendInvitationToJoinTeam;
use App\Models\Team;
use App\Repositories\Contracts\InvitationInterface;
use App\Repositories\Contracts\TeamInterface;
use App\Repositories\Contracts\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvitationsController extends Controller
{
    protected $invitations, $team, $user;

    public function __construct(InvitationInterface $invitations, TeamInterface $team, UserInterface $user)
    {
        $this->invitations = $invitations;
        $this->team = $team;
        $this->user = $user;
    }

    public function invite(Request $request, $teamId)
    {
        $team = $this->team->find($teamId);

        $this->validate($request, [
            'email' => ['required', 'email'],
        ]);

        $user = auth()->user();

        // check if user owns team
        if (!$user->isOwnerOfTeam($team)) {
            return response()->json([
                'message' => 'You have no permission to perform this action!',
            ], 401);
        }

        // check if email has pending invitation
        if ($team->hasPendingInvite($request->email)) {
            return response()->json([
                'message' => 'This email has a pending invite!',
            ], 422);
        }

        // get recipient
        $recipient = $this->user->findByEmail($request->email);

        // if recipient deos not exist and send invitation
        if (!$recipient) {
            $this->createInvitation(false, $team, $request->email);
            
            return response()->json([
                'mesage' => 'Invitation sent to user!',
            ]);
        }

        // check if user is already a team member
        if ($team->hasUser($recipient)) {
            return response()->json([
                'mesage' => 'This user is already a team member!',
            ], 422);
        }

        // send the invitation
        $this->createInvitation(true, $team, $request->email);

        return response()->json([
            'mesage' => 'Invitation sent to user!',
        ]);

    }

    public function resend($id)
    {
        $invitation = $this->invitations->find($id);

        // check if user owns team
        if (!$user->isOwnerOfTeam($invitation->team)) {
            return response()->json([
                'message' => 'You have no permission to perform this action!',
            ], 401);
        }

        $email = $invitation->recipient_email;
        $recipient = $this->user->findByEmail($email);

        Mail::to($email)
            ->send(new SendInvitationToJoinTeam($invitation, !is_null($recipient)));

        return response()->json([
            'message' => 'Invitation resent!'
        ]);
    }

    public function respond(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    protected function createInvitation(bool $user_exists, Team $team, string $email)
    {
        $invitation = $this->invitations->create([
            'team_id' => $team->id,
            'sender_id' => auth()->id(),
            'recipient_email' => $email,
            'token' => md5(uniqid(microtime())),
        ]);

        Mail::to($email)
            ->send(new SendInvitationToJoinTeam($invitation, $user_exists));
    }

}
