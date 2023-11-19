<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function __construct(
        private $model = new Reservation
    )
    {}

    final public function showReservations()
    {
        $user_id = \Auth::user()->id;
        $reservations = $this->model->getReservation($user_id);

        return view('reservationlist', ['reservations' => $reservations]);
    }
}
