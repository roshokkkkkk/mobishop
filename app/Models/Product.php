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
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'price', 'description', 'picture_path'];

    /**цвета изображения */
    private const COLORS = [
        'Синий'=>'#0000ff', 'Зеленый'=>'#00ff00', 'Красный'=>'#ff0000', 'Белый'=>'#ebebeb', 'Черный'=>'#000000', 'Бежевый'=>'#F5F5DC'
    ];
    public function characteristics(): BelongsToMany{
        return $this->belongsToMany(Characteristic::class, 'product_characteristic')->withPivot('value');
    }
    public function remain():HasOne{
        return $this->hasOne(Remain::class);
    }
    public function receipts():HasMany{
        return $this->hasMany(ProductReceipt::class);
    }
    public function sales():HasMany{
        return $this->hasMany(ProductSale::class);
    }
    /**остаток на складе */
    public function getStockAttribute(): int{
        return(int)($this->remain?->quantity ?? 0);
    }
    /**значение характеристики по названию*/
    public function spec(string $name): ?string{
        return $this->characteristics->firstWhere('name', $name)?->pivot->value;
    }
    public function getColorHexAttribute():string{
        return self::COLORS[$this->spec('цвет')]??'#3b82f6';
    }
    public function getPriceFormattedAttribute(): string{
        return number_format($this->price, 0,',');
    }
}
