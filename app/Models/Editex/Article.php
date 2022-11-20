<?php

namespace App\Models\Editex;

use App\Models\BaseModel;
use App\Models\Traits\ModelAttributes;
use App\Models\Traits\Attributes\ArticleAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User.
 */
class Article extends BaseModel
{
    use SoftDeletes, ModelAttributes, ArticleAttributes;

    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = [
        'publisher_id',
        'publisher_name',
        'article_id',
        'article_path',
        'noecs',
        'noecse_start',
        'noecse_end',
        'galleypdf',
        'galleypdf_start',
        'galleypdf_end',
        'galleyproofpdf',
        'galleyproofpdf_start',
        'galleyproofpdf_end',
        'typeset',
        'typeset_start',
        'typeset_end',
        'active',
    ];

    /**
     * Dates.
     *
     * @var array
     */
    protected $dates = [        
        'created_at',
        'updated_at',
    ];

    
}
