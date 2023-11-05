<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Images extends Model
{
    use HasFactory;

    final public function addImage($image)
    {
        $data = file_get_contents($image);
        $imageName = $image->getClientOriginalName();

        $params['name'] = $imageName;
        $params['data'] = base64_encode($data);

        return DB::table('images')->insertGetId($params);
    }

    final public function getImage($id)
    {
        $result = DB::table('images')
            ->where('id', $id)
            ->first();

        if(!$result) {
            return null;
        }

        return $result->data;
    }

}
