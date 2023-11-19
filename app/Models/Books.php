<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Books extends Model
{
    use HasFactory;

    final public function getBooks()
    {
        $date = new DateTime();

        $result = DB::select("
            SELECT
                b.*,
                b.count - IFNULL(rr.count, 0) AS count_result
            FROM books b 
            LEFT JOIN (
                SELECT 
                    r.book_id,
                    COUNT(r.id) AS count 
                FROM reservations r
                WHERE :date BETWEEN r.from AND r.to
                AND r.deleted = 0
                GROUP BY r.book_id
            ) AS rr ON rr.book_id = b.id
            WHERE b.deleted = 0", 
            ['date' => $date]
        );

        return $result;
    }

    final public function getBookById(int $id)
    {
        return (array) DB::table('books')
            ->where('deleted', '0')
            ->where('id', $id)
            ->first();
    }

    final public function addUpdateBook(array $ob): bool|int
    {
        if(isset($ob['id'])) {
            if(isset($ob['deleted'])) {
                //delete
                $ob['deleted_at'] = new DateTime();
                $ob['deleted_by'] = auth()->user()->id;
            } else {
                //update
                $ob['updated_at'] = new DateTime();
                $ob['updated_by'] = auth()->user()->id;
            }

            return DB::table('books')
                ->where('id', $ob['id'])
                ->update($ob);
        }

        //insert
        $ob['created_at'] = new DateTime();
        $ob['created_by'] = auth()->user()->id;
        return DB::table('books')
            ->insert($ob);
    }

    final public function getBookByNameAndId(string $name, int $id = null)
    {
        return DB::table('books')
            ->where('deleted', '0')
            ->where('name', $name)
            ->where('id', '<>', $id)
            ->count();
    }

    final public function getBookReservation(int $user_id, array $params)
    {
        $from = $params['from'];
        $to = $params['to'];
        $id = $params['id'];

        $result = DB::select("
                        SELECT
                            b.count - IFNULL(rr.count, 0) AS result
                        FROM books b 
                        LEFT JOIN (
                            SELECT 
                                r.book_id,
                                COUNT(r.id) AS count 
                            FROM reservations r
                            WHERE user_id <> :user_id
                            AND (
                                (:from BETWEEN r.from AND r.to)
                                OR
                                (:to BETWEEN r.from AND r.to)
                            ) AND r.deleted = 0
                            GROUP BY r.book_id
                        ) AS rr ON rr.book_id = b.id
                        WHERE b.deleted = 0 AND b.id = :id", 
                ['user_id' => $user_id, 'from' => $from, 'to' => $to, 'id' => $id]
            );
    
        // Access the result
        $result = $result[0]->result;

        return $result;
    }

    final public function countLibrary()
    {
        $result = DB::table('locations')->count();
        return $result;
    }

    final public function getLocationById(int $id)
    {
        return (array) DB::table('locations')
            ->where('deleted', '0')
            ->where('id', $id)
            ->first();
    }

    final public function addUpdateLocation(array $ob): bool|int
    {
        if(isset($ob['id'])) {
            if(isset($ob['deleted'])) {
                //delete
                $ob['deleted_at'] = new DateTime();
                $ob['deleted_by'] = auth()->user()->id;
            } else {
                //update
                $ob['updated_at'] = new DateTime();
                $ob['updated_by'] = auth()->user()->id;
            }

            return DB::table('locations')
                ->where('id', $ob['id'])
                ->update($ob);
        }

        //insert
        $ob['created_at'] = new DateTime();
        $ob['created_by'] = auth()->user()->id;
        return DB::table('locations')
            ->insert($ob);
    }

    final public function getLocationByNameAndId(string $name, int $id = null)
    {
        return DB::table('locations')
            ->where('deleted', '0')
            ->where('name', $name)
            ->where('id', '<>', $id)
            ->count();
    }
}
