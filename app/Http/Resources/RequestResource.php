<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $arr = [
            'id' => $this->id,
            'from' => new UserResource(User::findorFail($this->from)),
            'to' => new UserResource(User::findorFail($this->to)),
            'title' => $this->title,
            'content'=>$this->content,
            'answer' => $this->answer,
            'answered_at' => $this->answered_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        // $user = $request->user();
        // if($user->id != $this->from){
        //     $arr['from'] = new UserResource(User::findorFail($this->from));
        // }
        // if($user->id != $this->to){
        //     $arr['to'] = new UserResource(User::findorFail($this->to));
        // }
        return $arr;
    }
}
