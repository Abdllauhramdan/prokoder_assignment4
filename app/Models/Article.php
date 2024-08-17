<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'content', 'category_id'];

    public function category()
    {
        return$this->belongsTo(Category::class);
    }

    public function tags()
    {
        return$this->belongsToMany(Tag::class);
    }
}