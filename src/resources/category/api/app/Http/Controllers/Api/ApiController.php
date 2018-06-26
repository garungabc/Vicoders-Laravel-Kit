<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

class ApiController extends Controller
{
    use Helpers;

    protected function _getSlug($repository, $name)
    {
        $slug = str_slug($name);
        $i    = 1;
        while ($repository->findByField('slug', $slug)->first()) {
            $slug = str_slug($name) . '-' . $i++;
        }
        return $slug;
    }
}