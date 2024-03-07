<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
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
            'title'=>$this->title,
            'description'=> $this->description,
            'release_year'=>$this->release_year,
            'language_id'=>$this->language_id,
            'original_language_id'=>$this->original_language_id,
            'rental_duration'=>$this->rental_duration,
            'rental_rate'=>$this->rental_rate,
            'length'=>$this->length,
            'replacement_cost'=>$this->replacement_cost,
            'rating'=>$this->rating,
            'special_features'=>$this->special_features
        ];
    }
}
