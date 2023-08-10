<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'post_id',
        'message',
    ];
     //「1対多」の関係なので単数系に
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    //「1対多」の関係なので単数系に
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
