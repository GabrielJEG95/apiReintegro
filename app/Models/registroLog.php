<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class registroLog extends Model
{
    protected $primaryKey = "IdLog";
    protected $table = 'registroLog';
    protected $fillable = ['TableName','Users','Action','setValue','IP','APP'];
    public $timestamps = false;

}
