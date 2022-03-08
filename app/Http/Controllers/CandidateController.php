<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\User;
use Composer\Util\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CandidateController extends Controller
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
            'election_id' => 'required|integer|exists:elections,id',
            'user_id' => ['required','integer','exists:users,id', Rule::unique('candidates')->where('election_id', $request['election_id'])],
        ]);

        $created_candidate = Candidate::create($fields);
        return Response($created_candidate, 201);
        
        // $election = Election::create($fields);
        // return Response($election, 201);
        // if($request->user()->manager->id != $request){
        //     return Response('you hav\'nt access to this election', 403);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $fields = $request->validate([
            'user_id'=>'required|exists:users,id',
            'election_id'=>'required|exists:elections,id'
        ]);
        return Response(Candidate::where('user_id', $fields['user_id'])->where('election_id', $fields['election_id'])->firstorFail());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidate $candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'user_id'=>'required|exists:users,id',
            'election_id'=>'required|exists:elections,id'
        ]);
        $candidate = Candidate::where('user_id', $fields['user_id'])->where('election_id', $fields['election_id'])->firstorFail();
        $candidate->delete();
        return Response(1, 204);
    }
}
