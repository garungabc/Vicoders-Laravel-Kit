<?php

namespace App\Http\Controllers\Api;

use App\Entities\Category;
use App\Http\Controllers\Api\ApiController;
use App\Repositories\CategoryRepository;
use App\Transformers\CategoryTransformer;
use App\Validators\CategoryValidator;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    private $repository;
    private $validator;

    public function __construct(CategoryRepository $repository, CategoryValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = new Category;

        $constraints = (array) json_decode($request->get('constraints'));
        if (count($constraints)) {
            $query = $query->where($constraints);
        }

        if ($request->has('search')) {
            $search = $request->get('search');
            $query  = $query->where(function ($q) use ($request, $search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->has('order_by')) {
            $orderBy = (array) json_decode($request->get('order_by'));
            if (count($orderBy) > 0) {
                foreach ($orderBy as $key => $value) {
                    $query = $query->orderBy($key, $value);
                }
            }
        }

        $per_page   = $request->has('per_page') ? (int) $request->get('per_page') : 15;
        $categories = $query->paginate($per_page);

        if ($request->has('includes')) {
            $transformer = new CategoryTransformer(explode(',', $request->get('includes')));
        } else {
            $transformer = new CategoryTransformer;
        }

        return $this->response->paginator($categories, $transformer);
    }

    /**
     * Get all items.
     *
     * @param  Request $request [Request].
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $query = new Category;

        $constraints = (array) json_decode($request->get('constraints'));
        if (count($constraints)) {
            $query = $query->where($constraints);
        }

        if ($request->has('search')) {
            $search = $request->get('search');
            $query  = $query->where(function ($q) use ($request, $search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->has('order_by')) {
            $orderBy = (array) json_decode($request->get('order_by'));
            if (count($orderBy) > 0) {
                foreach ($orderBy as $key => $value) {
                    $query = $query->orderBy($key, $value);
                }
            }
        }

        $categories = $query->get();

        if ($request->has('includes')) {
            $transformer = new CategoryTransformer(explode(',', $request->get('includes')));
        } else {
            $transformer = new CategoryTransformer;
        }

        return $this->response->collection($categories, $transformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator->isValid($request, 'RULE_CREATE');

        $data         = $request->all();
        $data['slug'] = $this->_getSlug($this->repository, $data['name']);

        $category = $this->repository->create($data);

        $category->status = Category::STATUS_ACTIVE;
        $category->save();

        return $this->response->item($category, new CategoryTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->repository->find($id);
        return $this->response->item($category, new CategoryTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validator->isValid($request, 'RULE_UPDATE');

        $category = $this->repository->update($request->all(), $id);

        if ($request->has('status')) {
            $category->status = $request->get('status');
            $category->save();
        }

        return $this->response->item($category, new CategoryTransformer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return $this->success();
    }

    /**
     * Update all status resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatusAllItems(Request $request)
    {
        $this->validator->isValid($request, 'CHANGE_STATUS_ALL_ITEMS');

        $data = $request->all();

        switch ($data['status']) {
            case 'active':
                $categories = Category::whereIn('id', $data['item_ids'])->update(['status' => Category::STATUS_ACTIVE]);
                break;
            case 'pending':
                $categories = Category::whereIn('id', $data['item_ids'])->update(['status' => Category::STATUS_PENDING]);
                break;
        }
        return $this->success();
    }

    /**
     * Update specified status resource in storage.
     *
     * @param  Request $request [Request].
     * @param  [type]  $id      [item id].
     * @return \Illuminate\Http\Response
     */
    public function changeStatusItem(Request $request, $id)
    {
        $this->validator->isValid($request, 'CHANGE_STATUS_ITEM');

        $data = $request->all();

        switch ($data['status']) {
            case 'active':
                $categories = Category::where('id', $id)->update(['status' => Category::STATUS_ACTIVE]);
                break;
            case 'pending':
                $categories = Category::where('id', $id)->update(['status' => Category::STATUS_PENDING]);
                break;
        }
        return $this->success();
    }
}
