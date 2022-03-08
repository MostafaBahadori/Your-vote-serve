<?php

namespace App\Http\Resources;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
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

            'user' => new UserResource(User::find($this->user_id)),
            'election_id' => $this->election_id,
            'votes_count' => $this->votes()->where('election_id', $this->election_id)->count()

        ];
    }
}
