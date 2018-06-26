<?php

namespace App\Transformers;

use App\Entities\Product;
use League\Fractal\TransformerAbstract;

/**
 * Class ProductTransformer
 * @package namespace App\Transformers;
 */
class ProductTransformer extends TransformerAbstract
{
    protected $availableIncludes = [

    ];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    /**
     * Transform the Product entity
     * @param App\Entities\Product $model
     *
     * @return array
     */
    public function transform(Product $model)
    {
        return [
            'id'          => (int) $model->id,
            'name'        => $model->name,
            'slug'        => $model->slug,
            'image'       => $model->image,
            'description' => $model->description,
            'price'       => $model->price,
            'order'       => (int) $model->order,
            'status'      => (int) $model->status,
            'created_at'  => $model->created_at,
            'updated_at'  => $model->updated_at,
        ];
    }
}
