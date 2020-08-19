<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Repositories\Contracts\InvitationInterface;
use App\Repositories\Contracts\TeamInterface;
use App\Repositories\Contracts\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamsController extends Controller
{
    protected $teams, $users, $invitations;

    public function __construct(TeamInterface $teams, UserInterface $users, InvitationInterface $invitations)
    {
        $this->teams = $teams;
        $this->users = $users;
        $this->invitations = $invitations;
    }

    /**
     * Get list of all teams (ex for search)
     *
     * @return void
     */
    public function index(Request $request)
    {

    }

    /**
     * Save team to database
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:80', 'unique:teams,name'],
        ]);

        $team = $this->teams->create([
            'owner_id' => auth()->id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return new TeamResource($team);
    }

    /**
     * Update team
     */
    public function update(Request $request, $id)
    {
        $team = $this->teams->find($id);
        $this->authorize('update', $team);

        $this->validate($request, [
            'name' => ['required', 'string', 'max:80', 'unique:teams,name,' . $id],
        ]);

        $team = $this->teams->update($id, [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return new TeamResource($team);
    }

    /**
     * Find a team by its ID
     */
    public function findById($id)
    {
        $team = $this->teams->find($id);
        return new TeamResource($team);
    }

    /**
     * Get the teams the current user belongs to
     */
    public function fetchUserTeams()
    {
        $teams = $this->teams->fetchUserTeams();
        return TeamResource::collection($teams);
    }

    /**
     * Get team by slug
     */
    public function findBySlug($slug)
    {

    }

    /**
     * Delete team
     */
    public function destroy($id)
    {
        $team = $this->teams->find($id);
        $this->authorize('delete', $team);

        $team->delete();

        return response()->json(['message' => 'Deleted!'], 200);
    }

    public function removeFromTeam($teamId, $userId)
    {
        $team = $this->teams->find($teamId);
        $user = $this->users->find($userId);

        // check that user is not owner
        if($user->isOwnerOfTeam($team)) {
            return response()->json([
                'message' => "Team Owner can't leave!"
            ]);
        }

        // check if auth user is not owner or request user
        if(!auth()->user()->isOwnerOfTeam($team) && auth()->id() !== $user->id) {
            return response()->json([
                'message' => 'You are not permitted to perform this action!'
            ]);
        }

        $this->invitations->removeUserFromTeam($team, $userId);

        return response()->json(['message' => 'Success!'], 200);
    }
}
