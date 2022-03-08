<?php

namespace App\Http\Resources;

use App\Models\Candidate;
use App\Models\Manager;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ElectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => Storage::url($this->image),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_by' => new UserResource(Manager::findorFail($this->manager_id)->user),
            'candidates' => new CandidatesCollection($this->candidates),
            'total_votes' => $this->votes()->count(),
            'user_vote'=>Vote::where('election_id', $this->id)->where('user_id', $request->user()->id)->first()['candidate_id'] ?? null

        ];
    }
}
