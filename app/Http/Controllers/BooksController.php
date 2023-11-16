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

    final public function showBooks(Request $request)
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

            $error = $request['error'];

            // dd($error);


            return view('view', ['book' => $book]);
        }


        return redirect('/');
    }

    final public function addBookReservation(Request $request)
    {
        $params = $request->all();
        $user_id = $request->user()->id;
        $id = $request['id'];

        // Czy książka ma wolne rezerwacje
        $isFree = $this->model->getBookReservation($user_id, $params);

        if(!$isFree) {
            // Sprawdź najbliższą lokalizację biblioteki
            $library = $this->model->countLibrary();
            if($library) {

            }

            // Zarejestruj książkę
            return redirect('/book/'.$id)->with(['error' => __('Brak utworzonych lokalizacji')]);
        } 

        return redirect('/book/'.$id)->with(['error' => __('Podany termin jest już zarezerwowany')]);
    }
}
