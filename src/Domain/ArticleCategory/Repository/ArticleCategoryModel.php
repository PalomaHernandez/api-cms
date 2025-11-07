<?php

namespace App\Domain\ArticleCategory\Model;

use Illuminate\Database\Eloquent\Model;

class ArticleCategoryModel extends Model
{
    protected $table = 'article_categories';
    protected $fillable = ['article_id', 'category_id'];

    public $timestamps = false;
}
