<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Address extends Model
{
    protected $table = 'address';

    public $timestamps = false;

    protected $fillable = ['user_id', 'city', 'street', 'house', 'apartment'];

    public function getFullAtribute():string
    {
        $s = "г. {$this->city}, {$this->street}, д.{$this->house}";
        return $this->apartment ? $s.", кв. {$this->apartment}":$s;
    }
}
