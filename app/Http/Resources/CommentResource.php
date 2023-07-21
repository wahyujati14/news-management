<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'keterangan'    => $this->keterangan,
            'tanggal'       => Carbon::make($this->created_at)->format('d-m-Y H:i:s'),
            'user'          => UserResource::make($this->user),
        ];
    }
}
