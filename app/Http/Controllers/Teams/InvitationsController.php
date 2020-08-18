<?php

namespace App\Http\Controllers\Teams;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\InvitationInterface;

class InvitationsController extends Controller
{
    protected $invitations;

    public function __construct(InvitationInterface $invitations)
    {
        $this->invitations = $invitations;
    }

    public function invite(Request $request, $id)
    {
        //
    }

    public function resend(Request $request, $id)
    {
        //
    }

    public function respond($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
