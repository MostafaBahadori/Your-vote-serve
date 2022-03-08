<?php

namespace App\Http\Resources;

use App\Models\Manager;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class ElectionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $result = [];

        foreach ($this->collection as $election) {
            $result[] = [
                'id' => $election->id,
                'title' => $election->title,
                'image' => Storage::url($election->image),
                'start_date' => $election->start_date,
                'end_date' => $election->end_date,
                'total_votes'=> $election->votes()->count(),
                'total_candidates'=> $election->candidates()->count(),
                

            ];
        }


        return $result;
    }

    public function toResponse($request)
    {
        return JsonResource::toResponse($request);
    }
}
