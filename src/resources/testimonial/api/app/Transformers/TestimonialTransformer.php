<?php

namespace App\Transformers;

use App\Entities\Testimonial;
use League\Fractal\TransformerAbstract;

/**
 * Class TestimonialTransformer
 * @package namespace App\Transformers;
 */
class TestimonialTransformer extends TransformerAbstract
{
    protected $availableIncludes = [

    ];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    /**
     * Transform the Testimonial entity
     * @param App\Entities\Testimonial $model
     *
     * @return array
     */
    public function transform(Testimonial $model)
    {
        return [
            'id'         => (int) $model->id,
            'first_name' => $model->first_name,
            'last_name'  => $model->last_name,
            'image'      => $model->image,
            'content'    => $model->content,
            'order'      => (int) $model->order,
            'status'     => (int) $model->status,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
