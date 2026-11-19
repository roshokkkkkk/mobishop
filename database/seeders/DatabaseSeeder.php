<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Status;
use App\Models\Role;
use App\Models\Remain;
use App\Models\ProductReceipt;
use App\Models\Product;
use App\Models\Characteristic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /**справочники*/
        foreach(['customer', 'admin'] as $role){
            Role::firstOrCreate(['role'=>$role]);
        }
        foreach(['Новый','Оплачен','Отправлен','Выполнен','Отменён'] as $status){
            Status::firstOrCreate(['status'=>$status]);
        }
        $names = ['Операционная система','Оперативная память','Встроенная память','Диагональ экрана','Аккумулятор','Цвет'];
        $chars = [];
        foreach($names as $name){
            $chars[] = Characteristic::firstOrCreate(['name'=>$name])->id;
        }
        /**название, описание, цена, остаток, ос, озу, память, диагональ, батарея, цвет */
        $rows=[
            ['AQUARIUS NS M21', 'карманный персональный компьютер для корпоративного использования',62990, 5,'Аврора ОС', '4', '64', '6.67', '5000', 'Красный'],
            ['iPhone 18 Pro Max', 'премиальный телефон для премиальных личностей',132990, 25,'IOS', '12', '512', '6.9', '5567', 'Белый'],
            ['Sony Ericsson', 'классический кнопочный телефон с камерой, музыкой и FM-радио',4300, 215,'Фирменная ОС', '0,00098', '0,039', '1.8', '900', 'Белый'],
            ['Samsung Galaxy S25 FE', 'смартфон с ключевыми функциями флагманов Galaxy S по более доступной цене',46333, 67,'Android', '8', '256', '6.7', '4900', 'Чёрный'],
            ['iQOO 13', 'телефон,для особенных личностей',67067, 67,'Android', '16', '512', '6.82', '6150', 'Бежевый'],
        ];

        foreach ($rows as [$name, $desc, $price, $qty, $os, $ram, $storage, $screen, $battery, $color]){
            $product = Product::create(['name'=>$name, 'description'=>$desc, 'price'=>$price]);
            $product->characteristics()->attach([
                $chars[0]=>['value'=>$os],
                $chars[1]=>['value'=>"{$ram}ГБ"],
                $chars[2]=>['value'=>"{$storage}ГБ"],
                $chars[3]=>['value'=>$screen.""],
                $chars[4]=>['value'=>"{$battery}мА.ч"],
                $chars[5]=>['value'=>$color],
            ]);
            Remain::create(['product_id'=>$product->id, 'quantity'=>$qty]);
            if($qty>0){
                ProductReceipt::create([
                    'product_id'=>$product->id, 'quantity'=>$qty, 'date_of_receipt'=>today(),
                ]);
            }
        }
        $admin=User::create([
            'surname'=>'Администратор', 'firstname'=>'Магазина', 'mail'=>'admin@mobishop.local', 'phone'=>'+7 900 000 00-00', 'password'=>'Admin123'
        ]);
        $admin->roles()->attach(Role::where('role','admin')->value('id'));

        $client=User::create([
            'surname'=>'Колбасенко', 'firstname'=>'Данил', 'patronymic'=>'Иванович', 'mail'=>'aboba21@example.com', 'phone'=>'+7 900 000 00-01', 'password'=>'12485700'
        ]);
        $client->roles()->attach(Role::where('role','customer')->value('id'));
    }
}