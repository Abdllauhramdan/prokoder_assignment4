<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['member_id', 'sport_id', 'start_date', 'end_date', 'status', 'suspension_reason'];

    public function member()
    {
        return$this->belongsTo(Member::class);
    }

    public function sport()
    {
        return$this->belongsTo(Sport::class);
    }
}