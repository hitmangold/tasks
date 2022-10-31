<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['user_id','sum'];

    public function orderBook()
    {
        return $this->belongsToMany(Book::class, 'order_books')->withPivot('qty');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
