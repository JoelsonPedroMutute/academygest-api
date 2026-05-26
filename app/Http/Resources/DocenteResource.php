<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class DocenteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'data_nascimento' => $this->data_nascimento,
            'especialidade' => $this->especialidade,

            'user' => UserResource::make(
                $this->whenLoaded('user')
            ),
        ];
    }
}
