<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $default_folder = asset('images/avatar/user/') . '/';
        if ($this->folder != null && $this->avatar != null) {
            $avatar = $default_folder . $this->folder . '/' . $this->avatar;
        } else {
            $avatar = $default_folder . 'default/' . $this->gender . '.jpg';
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'avatar' => $avatar,
            'status' => $this->status,
        ];
    }
}
