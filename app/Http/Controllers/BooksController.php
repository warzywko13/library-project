<?php

namespace App\Http\Controllers;

use App\Models\Images;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Books;

class BooksController extends Controller
{
    public function __construct(
        private $model = new Books(),
        private $user = new User(),
        private $prefix = 'book'
    )
    {}

    final public function showBooks(Request $request)
    {
        $results = $this->model->getBooks();
        $books = $this->getImageForArray($results);

        return view('home', ['books' => $books]);
    }

    final public function showBooksAPI()
    {
        $results = $this->model->getBooks();
        $books = $this->getImageForArray($results);

        return response()->json($books);
    }

    final public function showBook(Request $request, int $id = null)
    {
        if($id) {
            $result = $this->model->getBookById($id);
            $book = $this->getImageForObject($result);

            $error = $request['error'];

            return view('view', ['book' => $book]);
        }


        return redirect('/');
    }

    final public function validateAddBookReservation($params): ?string
    {
        if(empty($params['from'])) {
            return __('Pole od nie może być puste');
        }

        if(empty($params['to'])) {
            return __('Pole do nie może być puste');
        }

        if(isset($params['from']) && isset($params['to'])) {
            if( $params['from'] > $params['to'] ) {
                return __('Data do nie może być większa niż od');
            }
        }

        return null;
    }

    final public function addBookReservation(Request $request)
    {
        $params = $request->all();
        $user_id = $request->user()->id;
        $id = $request['id'];

        // Czy książka ma wolne rezerwacje
        $isFree = $this->model->getBookReservation($user_id, $params);
        
        $error = $this->validateAddBookReservation($params);

        if(!empty($error)) {
            return redirect('/book/'.$id)->with(['error' => $error]);
        }

        if($isFree) {
            // Czy istnieją biblioteki w systemie
            $library = $this->model->countLibrary();

            if($library) {
                // Sprawdź najbliższą lokalizację biblioteki
                $user = $this->user->getUser($user_id);

                $x = $user->X;
                $y = $user->Y;

                if($x && $y) {
                    $loc = (new LocationController)->nearestLocation($x, $y);

                    Reservation::create([
                        'user_id' => $user_id,
                        'book_id' => $id,
                        'location_id' => $loc->id,
                        'from' => $params['from'],
                        'to' => $params['to']
                    ]);

                    return redirect('/')->with(['success' => __('Książka wypożyczona pomyślnie. Odbiór w ') . $loc->name]);
                }
            }

            // Zarejestruj książkę
            return redirect('/book/'.$id)->with(['error' => __('Brak utworzonych lokalizacji')]);
        } 

        return redirect('/book/'.$id)->with(['error' => __('Podany termin jest już zarezerwowany')]);
    }
}
