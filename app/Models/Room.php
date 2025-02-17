<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'sport_id'];

    public function sport()
    {
        return$this->belongsTo(Sport::class);
    }
}

