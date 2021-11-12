<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurposalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'title'=> $this->title,
            'description'=> $this->description,
            'rate'=> $this->rate,
            'owner_id'=> $this->owner_id,
            'developer_id'=> $this->developer_id,
            'category_id'=> $this->category_id,
            'budget'=> $this->budget,
            'location'=> $this->location,
            'status'=> $this->status,
            'file'=> $this->file,




        ];




    }
}
