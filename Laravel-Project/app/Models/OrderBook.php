<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBook extends Model
{
    use HasFactory;
    protected $table = 'order_books';
    protected $fillable = ['order_id','book_id','qty'];

    public function book()
    {
        return $this->hasMany(Book::class);
    }
}
