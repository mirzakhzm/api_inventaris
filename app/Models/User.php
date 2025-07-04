<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'username',
        'email',
        'first_name',
        'last_name',
        'phone',
        'password',
        'role'
    ];

    protected $hidden = [
        'password'
    ];

    public function getAuthIdentifierName()
    {
        return 'username';
    }
    public function getAuthIdentifier()
    {
        return $this->username;
    }
    public function getAuthPasswordName()
    {
        return 'password';
    }
    public function getAuthPassword()
    {
        return $this->password;
    }
    public function getRememberToken()
    {
        return $this->token;
    }
    public function setRememberToken($value)
    {
        $this->token = $value;
    }
    public function getRememberTokenName()
    {
        return 'token';
    }

    public function incomingItems()
    {
        return $this->hasMany(IncomingItem::class, 'created_by','id');
    }

}

