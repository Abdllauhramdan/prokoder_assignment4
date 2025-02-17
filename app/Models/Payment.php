<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['member_id', 'amount', 'payment_date'];

    public function member()
    {
        return$this->belongsTo(Member::class);
    }
}
