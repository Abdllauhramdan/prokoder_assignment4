<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Offer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'discount_percentage', 'start_date', 'end_date'];
}