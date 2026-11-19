<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public $timestamps = false;
    protected $fillable = ['surname', 'lastname', 'partonymic', 'email', 'phone', 'password'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts():array{
        return['password'=>'hashed'];
    }

    public function roles():BelongsToMany{
        return $this->belongsToMany(Role::class, 'user_roles');
    }
    public function isAdmin():bool{
        return $this->roles()->where('role', 'admin')->exists();
    }
    public function addresses():hasMany{
        return $this->hasMany(Address::class);
    }
    public function orders():HasMany{
        return $this->hasMany(Order::class);
    }
    public function basket():HasMany{
        return $this->hasMany(Basket::class);
    }
    public function getFullNameAttribute():string{
        return trim("{this->surname} {this->lastname} {this->partonymic}");
    }
}
