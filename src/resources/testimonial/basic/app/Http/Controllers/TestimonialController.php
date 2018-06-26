<?php

namespace App\Http\Controllers;

use App\Entities\Testimonial;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonial;
use App\Http\Requests\UpdateTestimonial;
use App\Repositories\TestimonialRepository;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    private $repository;

    public function __construct(TestimonialRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page     = $request->has('per_page') ? (int) $request->get('per_page') : 15;
        $testimonials = Testimonial::paginate($per_page)->appends($request->except('page'));

        $data = [
            'testimonials' => $testimonials,
        ];
        return view('testimonials.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestimonial $request)
    {
        $data        = $request->validated();
        $testimonial = $this->repository->create($data);

        $testimonial->status = Testimonial::STATUS_ACTIVE;
        $testimonial->save();

        return redirect()->back()->with('success', 'Testimonial created successfully');
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

        $data = [
            'testimonial' => $testimonial,
        ];

        return view('testimonials.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testimonial = $this->repository->find($id);

        $data = [
            'testimonial' => $testimonial,
        ];

        return view('testimonials.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTestimonial $request, $id)
    {
        $data        = $request->validated();
        $testimonial = $this->repository->update($data, $id);

        if ($request->has('status')) {
            $testimonial->status = $request->get('status');
            $testimonial->save();
        }

        return redirect()->back()->with('success', 'Testimonial updated successfully');
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
        return redirect()->back()->with('success', 'Testimonial deleted successfully');
    }
}
