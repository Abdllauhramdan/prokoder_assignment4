<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'phone'];

    public function subscriptions()
    {
        return$this->hasMany(Subscription::class);
    }

    public function payments()
    {
        return$this->hasMany(Payment::class);
    }
}
