<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Authors extends Model
{
    use HasFactory;
    protected $table = 'authors';

    public function books()
    {
        return $this->belongsToMany(Books::class, 'books_authors');
    }

}
