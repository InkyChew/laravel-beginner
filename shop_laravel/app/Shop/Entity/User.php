<?php

namespace App\Shop\Entity;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    //mass assignment
    protected $fillable = [
        "email",
        "password",
        "type",
        "nickname",
    ];
}