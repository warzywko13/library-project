<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime;

use function Laravel\Prompts\select;

class Locations extends Model
{
    use HasFactory;

    final public function getLocations()
    {
        return DB::table('locations')
            ->where('deleted', '=', '0')
            ->get();
    }

    final public function getLocationById(int $id)
    {
        return (array) DB::table('locations')
        ->where('deleted', '=', '0')
        ->where('id', '=', $id)
        ->first();
    }

    final public function getLocationByNameAndId(string $name, int $id = null)
    {
        return DB::table('locations')
            ->where('deleted', '0')
            ->where('name', $name)
            ->where('id', '<>', $id)
            ->count();
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

    final public function getNearestLocationForUser(int $x, int $y)
    {   
        $result = DB::select('SELECT
                    id,
                    name,
                    ST_DISTANCE(POINT(:x, :y), POINT(X, Y)) AS distance
                FROM locations
                ORDER BY distance
                LIMIT 1', 
            ['x' => $x, 'y' => $y]
        );

        return $result[0];
    }
}
