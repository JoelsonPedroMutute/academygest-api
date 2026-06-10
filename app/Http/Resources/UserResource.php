<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            'id'              => $this->id,
            'name'            => $this->name,
            'email'           => $this->email,
            'role'            => $this->role,
            'status'          => $this->status,
            'profile_picture' => null,
        ];

        if ($this->role !== 'admin') {
            $data['phone']       = $this->phone;
            $data['address']     = $this->address;
            $data['national_id'] = $this->national_id;
            $data['gender']      = $this->gender;
        }

        return $data;
    }
}
