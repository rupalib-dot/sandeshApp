<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Users extends JsonResource
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
            'id'        => $this->id,
            'fname'     => $this->fname,
            'lname'     => $this->lname,
            'email'     => $this->email,
            'mobile'    => $this->mobile,
            'dob'       => $this->dob,
            'address'   => $this->address,
            'adhaar'    => $this->adhaar,
        ];
    }
}
