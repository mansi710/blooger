<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;
use App\Models\User;

class Favourite extends Model
{
    use HasFactory;


    protected $guard='favourites';

    protected $fillable = [
        'user_id',
        'blog_id',
        'rating_data'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function blogs()
    {
        
        return $this->belongsTo(Blog::class,'blog_id');
    }

}
