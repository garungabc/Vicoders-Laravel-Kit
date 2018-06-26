<?php

namespace App\Transformers;

use App\Entities\Post;
use League\Fractal\TransformerAbstract;

/**
 * Class PostTransformer
 * @package namespace App\Transformers;
 */
class PostTransformer extends TransformerAbstract
{
    protected $availableIncludes = [

    ];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    /**
     * Transform the Post entity
     * @param App\Entities\Post $model
     *
     * @return array
     */
    public function transform(Post $model)
    {
        return [
            'id'          => (int) $model->id,
            'title'       => $model->title,
            'slug'        => $model->slug,
            'image'       => $model->image,
            'description' => $model->description,
            'content'     => $model->content,
            'user_id'     => (int) $model->user_id,
            'order'       => (int) $model->order,
            'status'      => (int) $model->status,
            'created_at'  => $model->created_at,
            'updated_at'  => $model->updated_at,
        ];
    }
}
