<?php

namespace App\Domain\User\Repository;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    public $timestamps = false;
    protected $table = 'users';
    protected $guarded = [];

}