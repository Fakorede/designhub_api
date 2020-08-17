<?php

namespace App\Http\Controllers\Teams;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\TeamInterface;

class TeamsController extends Controller
{
    protected $teams;

    public function __construct(TeamInterface $teams)
    {
        $this->teams = $teams;
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

    }

    /**
     * Update team
     */
    public function update(Request $request)
    {

    }

    /**
     * Find a team by its ID
     */
    public function findById($id)
    {

    }

    /**
     * Get the teams the current user belongs to
     */
    public function fetchUserTeams()
    {

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

    }
}
