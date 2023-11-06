<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;
use App\Models\Books;

class BooksController extends Controller
{
    public function __construct(
        private $model = new Books(),
        private $prefix = 'book'
    )
    {}

    final public function showBooks()
    {
        $results = $this->model->getBooks();
        $books = $this->getImageForArray($results);

        return view('home', ['books' => $books]);
    }

    final public function showBook(Request $request, int $id = null)
    {
        if($id) {
            $result = $this->model->getBookById($id);
            $book = $this->getImageForObject($result);

            return view('view', ['book' => $book]);
        }

        return redirect('/');
    }
}
