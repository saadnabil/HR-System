<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return array_merge(parent::toArray($request), [
            'employee' => new EmployeeResource($this->employee),
            'comment_text'      =>  $this->employee->name .  __(' added this card to ')  . __('task_status_'.$this->description)
        ]);
    }
}
