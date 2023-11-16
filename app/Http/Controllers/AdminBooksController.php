<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Images;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AdminBooksController extends Controller
{
    public function __construct(
        private $model = new Books(),
        private $image = new Images(),
        private $prefix = 'admin'
    )
    {}

    final public function showBooks()
    {
        $books = $this->model->getBooks();
        return view($this->prefix . '/index', ['books' => $books]);
    }

    public function validateAdmin(array $params): array
    {
        $error = [];

        if(empty($params['name'])) {
            $error['name'] = __('Nazwa książki nie może być pusta!');
        }

        if(empty($params['description'])) {
            $error['description'] = __('Opis książki nie może być pusty!');
        }

        if(
            !empty($params['name'])
            && $this->model->getBookByNameAndId($params['name'],  $params['id'])
        ) {
            $error['name'] = __('Książka o takiej nazwie już występuje w systemie');
        }

        return $error;
    }

    final public function addedit(Request $request, int $id = null)
    {
        $params = $request->all();

        if($request->session()->token() != csrf_token()) {
            return redirect('/');
        }

        $error = [];

        // Jeśli zapisz/edytuj
        if(
            isset($params['submit'])
        ) {
            $image = $request->file('image');
            $image_id = null;
            if($image) {
                $image_id = $this->image->addImage($image);
            }

            if(!empty($params['id'])) {
                $book['id'] = $params['id'];
            }
            $book['name'] = $params['name'];
            $book['count'] = $params['count'];
            $book['description'] = $params['description'];
            if($image) {
                $book['image_id'] = $image_id;
            }

            $error = $this->validateAdmin($params);

            if(empty($error)) {
                $this->model->addUpdateBook($book);

                $message['success'] = __('Dodano pomyślnie');
                if($params['id']) {
                    $message['success'] = __('Zedytowano pomyślnie');
                }

                return redirect('/' . $this->prefix)->with($message);
            }
        } else {
            // Wczydaj dane do formularza
            $book = [];
            if($id) {
                $book = $this->model->getBookById($id);
                $book['data_image'] = $this->image->getImage($book['image_id']);
            }
        }

        return view($this->prefix . '/addedit', ['book' => $book, 'error' => $error]);
    }

    final public function deleteBook(Request $request)
    {
        $id = $request->input('id');

        if($id) {
            $book = $this->model->getBookById($id);
            $book['deleted'] = 1;

            $result = $this->model->addUpdateBook($book);
        }

        $message['success'] = __('Usunięto pomyślnie');

        return redirect('/' . $this->prefix)->with($message);
    }
}
