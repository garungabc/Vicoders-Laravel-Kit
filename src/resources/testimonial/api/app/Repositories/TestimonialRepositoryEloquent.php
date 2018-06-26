<?php

namespace App\Repositories;

use App\Entities\Testimonial;
use App\Repositories\CanFlushCache;
use App\Repositories\TestimonialRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class TestimonialRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TestimonialRepositoryEloquent extends BaseRepository implements TestimonialRepository, CacheableInterface
{
    use CacheableRepository, CanFlushCache;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Testimonial::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
