<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model implements Authenticatable
{
    use HasFactory;
    protected $table = "driver";
    protected $primaryKey = "driver_id";

    function getAuthIdentifierName() {
        return 'driver_id';
    }
    public function getAuthIdentifier() {
        return $this->driver_id;
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
