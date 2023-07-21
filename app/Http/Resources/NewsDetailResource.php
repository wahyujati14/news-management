<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NewsDetailResource extends JsonResource
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
            'id'        => $this->id,
            'judul'     => $this->judul,
            'slug'      => $this->slug,
            'gambar'    => url('uploads/'.$this->gambar),
            'tanggal'   => Carbon::make($this->tanggal)->format('d-m-Y H:i:s'),
            'deskripsi' => $this->deskripsi,
            'comment'   => CommentResource::collection($this->comment),
        ];
    }
}
