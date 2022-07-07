<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Favourite;
use Kyslik\ColumnSortable\Sortable;
class Blog extends Model
{
    use HasFactory;
    use Sortable;
    protected $guard = 'blogs';

    protected $fillable = [
        'title',
        'description',
        'status',
        'tag',
        'order'
    ];


    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'blog_id');
    }

    public $sortable = ['id', 'title', 'description','status','tag','order', 'created_at', 'updated_at'];
    //searching data
    public function scopeSearch($query, $s)
    {
        return $query->where('title', 'like', '%' . $s . '%')
            ->orwhere('description', 'like', '%' . $s . '%')
            ->orwhere('status', 'like', '%' . $s . '%')
            ->orwhere('tag', 'like', '%' . $s . '%')
            ->orwhere('order', 'like', '%' . $s . '%');
    }
}
