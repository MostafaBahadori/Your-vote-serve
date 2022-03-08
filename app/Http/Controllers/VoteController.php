<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Carbon\Carbon;
use Composer\Util\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'candidate_id'=>'required|exists:users,id',
            'election_id'=>'required|exists:elections,id'
        ]);
        $election = Election::findorFail($fields['election_id']);
        if(Carbon::now()->isAfter($election['end_date']) || Carbon::now()->isBefore($election['start_date'])){
            return Response('You Cant Vote, This Election isnt Held at the Moment', 403);
        }
        Candidate::where('user_id', $fields['candidate_id'])->where('election_id', $fields['election_id'])->firstorFail();

        $user = $request->user();
        $matchThese = ['user_id' => $user->id, 'election_id' => $fields['election_id']];
        $vote = Vote::where($matchThese)->first();
        // check if already voted to update it:
        if($vote){
            $vote['candidate_id'] = $fields['candidate_id'];
            $vote->save();
            return Response('', 204);

        }
        $fields['user_id'] = $request->user()->id;
        $created_vote = Vote::create($fields);
        return Response($created_vote);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function show(Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $vote)
    {
        //
    }
}
