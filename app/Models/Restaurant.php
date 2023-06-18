<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model implements Authenticatable
{
    use HasFactory;
    protected $table = "restaurant";
    protected $primaryKey = "restaurant_id";

    function getAuthIdentifierName() {
        return 'restaurant_id';
    }
    public function getAuthIdentifier() {
        return $this->restaurant_id;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
