<?php

namespace App\Http\Controllers\Api;

use App\Entities\Testimonial;
use App\Http\Controllers\Api\ApiController;
use App\Repositories\TestimonialRepository;
use App\Transformers\TestimonialTransformer;
use App\Validators\TestimonialValidator;
use Illuminate\Http\Request;

class TestimonialController extends ApiController
{
    private $repository;
    private $validator;

    public function __construct(TestimonialRepository $repository, TestimonialValidator $validator)
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
        $query = new Testimonial;

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

        $per_page     = $request->has('per_page') ? (int) $request->get('per_page') : 15;
        $testimonials = $query->paginate($per_page);

        if ($request->has('includes')) {
            $transformer = new TestimonialTransformer(explode(',', $request->get('includes')));
        } else {
            $transformer = new TestimonialTransformer;
        }

        return $this->response->paginator($testimonials, $transformer);
    }

    /**
     * Get all items.
     *
     * @param  Request $request [Request].
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $query = new Testimonial;

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

        $testimonials = $query->get();

        if ($request->has('includes')) {
            $transformer = new TestimonialTransformer(explode(',', $request->get('includes')));
        } else {
            $transformer = new TestimonialTransformer;
        }

        return $this->response->collection($testimonials, $transformer);
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

        $data        = $request->all();
        $testimonial = $this->repository->create($data);

        $testimonial->status = Testimonial::STATUS_ACTIVE;
        $testimonial->save();

        return $this->response->item($testimonial, new TestimonialTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $testimonial = $this->repository->find($id);
        return $this->response->item($testimonial, new TestimonialTransformer);
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

        $testimonial = $this->repository->update($request->all(), $id);

        if ($request->has('status')) {
            $testimonial->status = $request->get('status');
            $testimonial->save();
        }

        return $this->response->item($testimonial, new TestimonialTransformer);
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
                $testimonials = Testimonial::whereIn('id', $data['item_ids'])->update(['status' => Testimonial::STATUS_ACTIVE]);
                break;
            case 'pending':
                $testimonials = Testimonial::whereIn('id', $data['item_ids'])->update(['status' => Testimonial::STATUS_PENDING]);
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
                $testimonials = Testimonial::where('id', $id)->update(['status' => Testimonial::STATUS_ACTIVE]);
                break;
            case 'pending':
                $testimonials = Testimonial::where('id', $id)->update(['status' => Testimonial::STATUS_PENDING]);
                break;
        }
        return $this->success();
    }
}
