<?php

namespace App\Domain\Category\Repository;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Article\Repository\ArticleModel;

class CategoryModel extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function articles()
    {
        return $this->belongsToMany(ArticleModel::class, 'article_categories', 'category_id', 'article_id');
    }
}
