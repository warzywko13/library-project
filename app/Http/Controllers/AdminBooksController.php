<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class AdminBooksController extends Controller
{
    public function __construct(
        private $model = new Books(),
        private $prefix = 'admin'
    )
    {}

    final public function showBooks()
    {
        $books = $this->model->getBooks();
        return view($this->prefix . '/index', ['books' => $books ]);
    }

    final public function addedit(Request $request, int $id = null)
    {
        $params = (object) $request->all();

        if($request->session()->token() != csrf_token()) {
            return redirect('/');
            die;
        }

        if(isset($params->id)) {
            return redirect('/' . $this->prefix);
            die;
        } else {
            $book = new \stdClass();
            if($id) {
                $book = $this->model->getBook($id);
            }
        }

        return view($this->prefix . '/addedit', ['book' => $book]);
    }
}
