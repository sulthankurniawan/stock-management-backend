<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'entry_id';
    public $incrementing = true;
}
