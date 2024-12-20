<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    // $fillable - массив, содержащий названия столбцов, которые могут быть массово заполнены.
    // В этом случае только столбец 'name' может быть массово заполнен.

    public function news()
    {
        return $this->hasMany(News::class);
        // одна категория может иметь множество новостей.
    }
}
