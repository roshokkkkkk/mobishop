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

class OrderStatus extends Model
{
    protected $table = 'order_status';

    public $timestamps = false;

    protected $fillable = ['order_id', 'status_id', 'date_time'];

    public function casts(): array{
        return ['date_time'=>'datetime'];
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
}
