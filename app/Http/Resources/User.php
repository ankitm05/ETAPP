<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class User extends JsonResource
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
            'id'=>$this->id,
            'email'=>$this->email,
            'name'=>$this->name,
            'profileImage' => $this->profileImage?asset('storage/'.$this->profileImage):'',
            'position' => $this->position,
            'company_name' => $this->company_name,
            'website' => $this->website,
            'location' => $this->location,
            'latitude' => $this->latitude,   
            'longitude' => $this->longitude,
            'phone' => $this->phone,
            'is_email_verify'=> $this->is_email_verify, 
            'device_type'=> $this->device_type, 
            'device_token'=> $this->device_token, 
            'status'=> $this->status,
            'notify_status'=> $this->notify_status,
            'created_at'=> $this->created_at, 
            'updated_at'=> $this->updated_at,
        ];
    }
}