<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    private $message;

    public function __construct($resource, $message)
    {
        parent::__construct($resource);
        $this->resource = $resource;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
                'id' => $this->id,
                'title' => $this->title,
                'author' => $this->author,
                'isbn' => $this->isbn,
                'publisher' => $this->publisher,
                'published_at' => $this->published_at,
                'description' => $this->description,
                'image' => 'http://localhost:8000/storage/images/' . $this->image,
            ];
    }
}
