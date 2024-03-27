<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Actor_FilmResource extends JsonResource
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
            'id'=> $this->id,
            'actor_id'=>$this->actor_id,
            'film_id'=> $this->film_id
        ];
    }
}

