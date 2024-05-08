<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusCalculate extends Model
{
    use HasFactory;
    protected $table = "status_calculate";
    protected $fillable = ["limits","offset","date_start","date_end","time"];
    protected $timestamp = false;
}
