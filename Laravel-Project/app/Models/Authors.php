<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Authors extends Model
{
    use HasFactory;
    protected $fillable = ['name','surname'];
    protected $table = 'authors';

    public function books()
    {
        return $this->belongsToMany(Books::class, 'books_authors');
    }
    public function books_authors()
    {
        return $this->HasMany(Books_Authors::class);
    }

}
