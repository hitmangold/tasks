<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    public function authors()
    {
        return $this->belongsToMany(Authors::class, 'books_authors');
    }
    public function books_authors()
    {
        return $this->hasMany(Books_Authors::class);
    }
}
