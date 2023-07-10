<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryRequset;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $category=CategoryResource::collection(Category::all());
       return $this->apiResponse($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $Category = Category::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);
        $array = [
            new CategoryResource($Category),
            'name_user' => $user = Auth::user()->name,
        ];
        if ($Category) {
            return $this->successResponse($array, 'the Category  Save');
        }
        return $this->errorResponse('the Category Not Save'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Category = Category::find($id);
        $array = [
            new CategoryResource($Category),
            'name_user' => $user = Auth::user()->name,
        ];
        if ($Category) {
            return $this->successResponse($array, 'ok');
        }
        return $this->errorResponse('the Category Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $Category = Category::find($id);
        if (!$Category) {
            return $this->errorResponse('the Category Not Found', 404);
        }
        
        if ($Category->user_id === Auth::id()) {
            $Category->update([
                'name' => $request->name,
                'user_id' => Auth::id(),
              
            ]);
            $array = [
                new CategoryResource($Category),
                'name_user' => $user = Auth::user()->name,
            ];
            if ($Category) {
                return $this->successResponse($array, 'the Category update');
            }
        }
        return $this->errorResponse('you con not updet the Category Because you are not authorized', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Category = Category::find($id);

        if ($Category->user_id === Auth::id()) {
            $Category->delete();
            if ($Category) {
                return $this->successResponse(null, 'the Category deleted');
            }
            return $this->errorResponse('you con not delete the Category', 400);
        }
        return $this->errorResponse('you con not delete the Category Because you are not authorized', 401);
    }
    public function showsoft()
    {
        $Categories = Category::onlyTrashed()->get();
        return $this->apiResponse($Categories);
    }
    public function restor($id)
    {
        $Category = Category::withTrashed()->where('id', $id)->restore();
        return $this->successResponse($Category, 'the Category restor');
    }
    public function finldelet($id)
    {
        $Category = Category::withTrashed()->where('id', $id)->forceDelete();
        if ($Category) {
            return $this->successResponse(null, 'the Category deleted');
        }
        return $this->errorResponse('you con not delete the Category', 400);
    }
    public function allWithSub()
    {
        $subcategory = Category::with('subcategories')->get();
        return $this->successResponse($subcategory, 'Show Subcategories.', 200);
    }

    public function getSubcategories($id)
    {
        $category = Category::find($id);
        if(!$category){
            return $this->errorResponse('Category not found.', 404);
        }
        $subcategory = $category->subcategories()->get();
        return $this->successResponse($subcategory, 'Show Subcategories.', 200);
    }

    public function products()
    {
        $categories = Category::with('subcategories.products')->get();
        $data = [];
        foreach($categories as $category){
            foreach($category->subcategories as $sub)
                foreach($sub->products as $product)
                    $data[] = [
                        'category name' => $category->name,
                        'subcategory name' => $sub->name,
                        'product name' => $product->name,
                        'product price' => $product->price
                    ];
        }
        return $this->successResponse($data, 'Show Subcategories.', 200);
    }
}
