<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'location_id', 'book_id', 'from', 'to'];


    final public function getReservation(int $id)
    {
        $result = DB::select('SELECT
                r.id,
                b.name as book,
                l.name as location,
                r.from,
                r.to
            FROM reservations r
            LEFT JOIN books b ON r.book_id = b.id
            LEFT JOIN locations l ON l.id = r.location_id
            WHERE r.deleted = 0 AND r.user_id = :user_id',
            ['user_id' => $id]
        );

        return $result;
    }
}
