<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
// ステップ7内容
    // ダミーレコードを代入する機能を使うことを宣言しています。
    use HasFactory;

    // 以下の情報（属性）を一度に保存したり変更したりできるように設定しています。
    // $fillable を設定しないと、Laravelはセキュリティリスクを避けるために、この一括代入をブロックします。
    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'img_path',
    ];

    // Productモデルがsalesテーブルとリレーション関係を結ぶためのメソッドです
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Productモデルがcompanysテーブルとリレーション関係を結ぶ為のメソッドです
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
}
