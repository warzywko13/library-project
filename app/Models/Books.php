<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Books extends Model
{
    use HasFactory;

    final public function getBooks()
    {
        return DB::table('books')
            ->where('deleted', '0')
            ->get();
    }

    final public function getBook(int $id)
    {
        return (object) DB::table('books')
            ->where('deleted', '0')
            ->where('id', $id)
            ->first();
    }
}
