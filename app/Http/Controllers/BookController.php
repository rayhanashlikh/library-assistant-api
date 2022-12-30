<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends BaseApiController
{
    public function getAllBooks(Request $request)
    {
        try {
            $per_page = $request->per_page ?: 20;

            $data = Book::paginate($per_page);
            $result = new BookCollection($data);

            return $this->respond($result);
        } catch (\Exception$e) {
            return $this->ApiExceptionError($e->getMessage());
        }
    }

    public function addBook(StoreBookRequest $request)
    {
        try {
            if ($request->file('image')) {
                $image = $request->file('image');
                $dmy = date('Y') . '-' . date('m') . '-' . date('d');
                $name = Str::random(10);
                $image_name = $name . '-' . $dmy . '.' . $image->getClientOriginalExtension();
                Storage::disk('local')->put('/public/images/' . $image_name, file_get_contents($image));
            }

            $data = Book::create([
                'title' => $request->title,
                'author' => $request->author,
                'isbn' => $request->isbn,
                'publisher' => $request->publisher,
                'published_at' => $request->published_at,
                'description' => $request->description,
                'image' => $image_name,
            ]);

            $result = new BookResource($data, 'Book added successfully');
            return $this->respond($result);
        } catch (\Exception$e) {
            return $this->ApiExceptionError($e->getMessage());
        }
    }

    public function getBook(Book $book)
    {
        try {
            $data = Book::find($book->id);
            $result = new BookResource($data, 'Book retrieved successfully.');

            return $this->respond($result);
        } catch (\Exception$e) {
            return $this->ApiExceptionError($e->getMessage());
        }
    }

    public function updateBook(UpdateBookRequest $request, Book $book)
    {
        try {
            $data = Book::find($book->id);

            if ($request->file('image')) {
                $image = $request->file('image');
                $dmy = date('Y') . '-' . date('m') . '-' . date('d');
                $name = Str::random(10);
                $image_name = $name . '-' . $dmy . '.' . $image->getClientOriginalExtension();
                Storage::disk('local')->put('/public/images/' . $image_name, file_get_contents($image));
                Storage::disk('local')->delete('/public/images/' . $data->image);

                $data->update([
                    'title' => $request->title,
                    'author' => $request->author,
                    'isbn' => $request->isbn,
                    'publisher' => $request->publisher,
                    'published_at' => $request->published_at,
                    'description' => $request->description,
                    'image' => $image_name,
                ]);
            } else {
                $data->update([
                    'title' => $request->title,
                    'author' => $request->author,
                    'isbn' => $request->isbn,
                    'publisher' => $request->publisher,
                    'published_at' => $request->published_at,
                    'description' => $request->description,
                ]);
            }
            $result = new BookResource($data, 'Book updated successfully');

            return $this->respond($result);
        } catch (\Exception$e) {
            return $this->ApiExceptionError($e->getMessage());
        }
    }

    public function deleteBook(Book $book)
    {
        try {
            $data = Book::find($book->id);
            Storage::disk('local')->delete('/public/images/' . $data->image);
            $data->delete();
            $result = new BookResource($data, 'Book deleted successfully');

            return $this->respond($result);
        } catch (\Exception$e) {
            return $this->ApiExceptionError($e->getMessage());
        }
    }
}
