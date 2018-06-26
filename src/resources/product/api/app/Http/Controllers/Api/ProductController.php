<?php

namespace App\Http\Controllers\Api;

use App\Entities\Product;
use App\Http\Controllers\Api\ApiController;
use App\Repositories\ProductRepository;
use App\Transformers\ProductTransformer;
use App\Validators\ProductValidator;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    private $repository;
    private $validator;

    public function __construct(ProductRepository $repository, ProductValidator $validator)
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
        $query = new Product;

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

        $per_page = $request->has('per_page') ? (int) $request->get('per_page') : 15;
        $products = $query->paginate($per_page);

        if ($request->has('includes')) {
            $transformer = new ProductTransformer(explode(',', $request->get('includes')));
        } else {
            $transformer = new ProductTransformer;
        }

        return $this->response->paginator($products, $transformer);
    }

    /**
     * Get all items.
     *
     * @param  Request $request [Request].
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $query = new Product;

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

        $products = $query->get();

        if ($request->has('includes')) {
            $transformer = new ProductTransformer(explode(',', $request->get('includes')));
        } else {
            $transformer = new ProductTransformer;
        }

        return $this->response->collection($products, $transformer);
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

        $product = $this->repository->create($data);

        $product->status = Product::STATUS_ACTIVE;
        $product->save();

        return $this->response->item($product, new ProductTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->repository->find($id);
        return $this->response->item($product, new ProductTransformer);
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

        $product = $this->repository->update($request->all(), $id);

        if ($request->has('status')) {
            $product->status = $request->get('status');
            $product->save();
        }

        return $this->response->item($product, new ProductTransformer);
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
                $products = Product::whereIn('id', $data['item_ids'])->update(['status' => Product::STATUS_ACTIVE]);
                break;
            case 'pending':
                $products = Product::whereIn('id', $data['item_ids'])->update(['status' => Product::STATUS_PENDING]);
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
                $products = Product::where('id', $id)->update(['status' => Product::STATUS_ACTIVE]);
                break;
            case 'pending':
                $products = Product::where('id', $id)->update(['status' => Product::STATUS_PENDING]);
                break;
        }
        return $this->success();
    }
}
