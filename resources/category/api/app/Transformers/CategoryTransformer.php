<?php

namespace App\Transformers;

use App\Entities\Category;
use League\Fractal\TransformerAbstract;

/**
 * Class CategoryTransformer
 * @package namespace App\Transformers;
 */
class CategoryTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'parent',
    ];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    /**
     * Transform the Category entity
     * @param App\Entities\Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
       return [
            'id'          => (int) $model->id,
            'name'        => $model->name,
            'slug'        => $model->slug,
            'order'       => $model->order,
            'status'      => $model->status,
            'parent_id'   => $model->parent_id,
            'created_at'  => $model->created_at,
            'updated_at'  => $model->updated_at,
        ];
    }

    public function includeParent(Category $model)
    {
        if (!empty($model->parent)) {
            return $this->item($model->parent, new CategoryTransformer);
        }
    }
}
