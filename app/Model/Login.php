<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table="user";
    public $primaryKey='uid';
    public $timestamps=false;
}
