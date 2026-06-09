<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'profile_picture' => null, // We'll handle this once we have the column
        ];

        // Only include academic data for non-admin users
        if ($this->role !== 'admin') {
            $data['phone'] = $this->telefone;
            $data['address'] = $this->endereco;
            $data['bi'] = $this->bi;
            $data['gender'] = $this->genero;
        }

        return $data;
    }
}
