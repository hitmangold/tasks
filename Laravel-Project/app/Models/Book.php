<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title','price','qty'];
    protected $table = 'books';
    use HasFactory;

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'books_authors');
    }
    public function booksAuthors()
    {
        return $this->hasMany(BookAuthor::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_books')->withPivot('qty');
    }
    public function orderBooks()
    {
        return $this->hasMany(OrderBook::class);
    }
}
