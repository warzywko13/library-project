<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;

class BooksController extends Controller
{
    public function __construct(
        private $model = new Books()
    )
    {}

    final public function showBooks()
    {
        $books = $this->model->getBooks();
        return view('home', ['books' => $books ]);
    }
}
