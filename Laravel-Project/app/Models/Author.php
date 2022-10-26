<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = ['name','surname','user_id'];
    protected $table = 'authors';

    public function books()
    {
        return $this->belongsToMany(Book::class, 'books_authors');
    }
    public function booksAuthors()
    {
        return $this->HasMany(BookAuthor::class);
    }
    public function user() {
        return $this->hasOne(User::class);
    }
}
