<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            $this->transformCollection($this->collection);
            // 'meta' => [
            //     "success" => true,
            //     "message" => "Success Get All Aspiration Categories",
            //     'pagination' => $this->metaData()
            // ]

    }

    private function transformData($data)
    {
        return [
            'id' => $data->id,
            'title' => $data->title,
            'author' => $data->author,
            'isbn' => $data->isbn,
            'publisher' => $data->publisher,
            'published_at' => $data->published_at,
            'description' => $data->description,
            'image' => 'http://localhost:8000/storage/images/' . $data->image,
        ];
    }

    private function transformCollection($collection)
    {
        return $collection->transform(function ($data) {
            return $this->transformData($data);
        });
    }

    private function metaData()
    {
        return [
            "total" => $this->total(),
            "count" => $this->count(),
            "per_page" => (int)$this->perPage(),
            "current_page" => $this->currentPage(),
            "total_pages" => $this->lastPage(),
            "links" => [
                "next" => $this->nextPageUrl()
            ],
        ];
    }
}
