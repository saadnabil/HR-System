<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyStructureListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang              = app()->getLocale() == 'ar' ? '_ar' : '';
        return [
            'id'          => $this->id,
            'pid'         => $this->parent,
            'name'        => $this->employee->name ?? '',
            'title'       => $this['name'.$lang],
            'email'       => $this->employee->email ?? '',
            'image'       => $this->employee && $this->employee->user ? $this->employee->user['avatar'] : '',
        ];
    }
}
