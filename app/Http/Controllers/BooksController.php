<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;
use App\Models\Books;

class BooksController extends Controller
{
    public function __construct(
        private $model = new Books(),
        private $image = new Images(),
    )
    {}

    final public function showBooks()
    {
        $results = $this->model->getBooks();

        $books = [];
        foreach($results as $result) {
            if(!empty($result->image_id)) {
                $result->image = $this->image->getImage($result->image_id);
            }

            $books[] = $result;
        }

        return view('home', ['books' => $books ]);
    }
}
