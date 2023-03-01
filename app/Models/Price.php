<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $table = 'prices';

    protected $fillable = ['amount', 'product_id', 'user_id'];

    public function rel_to_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
