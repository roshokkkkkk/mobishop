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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Order extends Model
{
    protected $table = 'order';

    /**названия статусов*/
    public const NEW = "Новый";
    public const CANCELLED = "Отменен";
    public const DONE = "Выполнен";
    public const STATUSES = ["Новый","Оплачен","Отправлен","Выполнен","Отменен"];


    /**CSS-класс значка статуса */
    private const BADGES= [
        'Новый'=>'new', 'Оплачен'=>'paid', 'Отправлен'=>'shipped', 'Выполнен'=>'done', 'Отменен'=>'cancelled', 
    ];

    protected $fillable = ['user_id', 'address_id', 'order_date', 'status', 'sum'];

    protected function casts():array
    {
        return['order_date'=>'date_time'];
    }

    public function getBadgesAttribute():string{
        return self::BADGES[$this->status]??'new';
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo{
        return $this->belongsTo(Address::class);
    }

    public function productOrders(): HasMany{
        return $this->hasMany(ProductOrder::class);
    }

    public function statuses():HasMany{
        return $this->hasMany(OrderStatus::class);
    }

    public function setStatus(string $name): void{
        $this->update(['status'=>$name]);
        OrderStatus::create([
            'order_id'=>$this->id,
            'status_id'=>Status::where('status',$name)->value('id'),
            'date_time'=>now()
        ]);
    }
}
