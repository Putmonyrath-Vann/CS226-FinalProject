<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model implements Authenticatable
{
    use HasFactory;
    protected $table = "buyer";
    protected $primaryKey = "buyer_id";

    function getAuthIdentifierName() {
        return 'buyer_id';
    }
    public function getAuthIdentifier() {
        return $this->buyer_id;
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
