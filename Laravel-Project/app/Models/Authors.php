<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Authors extends Model
{
    use HasFactory;

    public function AuthorsModel()
    {
        return DB::table('authors')->select('*')->get();
    }
}
