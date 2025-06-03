<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
			
			'id' => $this->id,
			'email' =>$this->email,
			'tel' =>$this->tel,
			'sex' =>$this->sex,
			'birthdate' => $this->birthdate,
			'firstname' =>$this->firstname,
			'lastname' =>$this->lastname,
			'country' =>$this->country,
			'address' =>$this->address,
			'picture' =>$this->picture,
		];
    }
}
