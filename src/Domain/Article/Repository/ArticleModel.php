<?php

namespace App\Domain\Article\Repository;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Category\Repository\CategoryModel;
use App\Domain\User\Repository\UserModel;

class ArticleModel extends Model
{
    protected $table = 'articles';

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(
            CategoryModel::class,
            'article_categories',
            'article_id',
            'category_id'
        );
    }

    public function author()
    {
        return $this->belongsTo(UserModel::class, 'author_id');
    }
}
