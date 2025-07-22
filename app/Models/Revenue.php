<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Revenue extends Model
{
 use HasFactory;

    protected $table = 'revenues'; // Specify the table name

    protected $fillable = [
        'coach_id',
        'amount',
        'created_at',
        'updated_at',
    ];
 public $timestamps = false;
}
