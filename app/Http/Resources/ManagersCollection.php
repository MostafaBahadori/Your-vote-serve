<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ManagersCollection extends ResourceCollection
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

        foreach($this->collection as $manager){
            $result[] = [
                'id'=>$manager->id,
                'user_id'=>$manager->user_id,
                'position'=>$manager->position,
                'created_at'=>$manager->created_at,
                'updated_at'=>$manager->updated_at,
                
            ]
            ;
        }


        return [
            'data' => $result,
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage()
            ],
            
        ];
    }

    public function toResponse($request)
    {
        return JsonResource::toResponse($request);
    }
}
