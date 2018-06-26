<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $repository;

    public function __construct(CategoryRepository $repository)
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
        $per_page   = $request->has('per_page') ? (int) $request->get('per_page') : 15;
        $categories = Category::paginate($per_page)->appends($request->except('page'));

        $data = [
            'categories' => $categories,
        ];
        return view('categories.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        $data     = $request->validated();
        $category = $this->repository->create($data);

        $category->status = Category::STATUS_ACTIVE;
        $category->save();

        return redirect()->back()->with('success', 'Category created successfully');
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

        $data = [
            'category' => $category,
        ];

        return view('categories.show', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategory $request, $id)
    {
        $data     = $request->validated();
        $category = $this->repository->update($data, $id);

        if ($request->has('status')) {
            $category->status = $request->get('status');
            $category->save();
        }

        return redirect()->back()->with('success', 'Category updated successfully');
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
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
