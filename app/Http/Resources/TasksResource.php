<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // here we are converting the collection to a json object
        return [
            'id' => (string)$this->id, // task id
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
                'priority' => $this->priority,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'relationships' => [ // this is the relationship related to a single task
                'id' => (string)$this->user->id, // user id
                'user name' => $this->user->name,
                'user emails' => $this->user->email
            ]
        ];
    }
}
