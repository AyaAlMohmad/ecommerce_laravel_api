<?php

namespace App\Http\Controllers\Api\Store;


use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Resources\SubCategoryResource;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $SubCategory=SubCategoryResource::collection(SubCategory::all());
       return $this->apiResponse($SubCategory);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryRequest  $request)
    {
        $SubCategory = SubCategory::create([
            'name' => $request->name,
            'category_id'=>$request->category_id,

            'user_id' => Auth::id(),
        ]);
        $array = [
            new SubCategoryResource($SubCategory),
            'name_user' => $user = Auth::user()->name,
        ];
        if ($SubCategory) {
            return $this->successResponse($array, 'the SubCategory  Save');
        }
        return $this->errorResponse('the SubCategory Not Save'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $SubCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $SubCategory = SubCategory::find($id);
        $array = [
            new SubCategoryResource($SubCategory),
            'name_user' => $user = Auth::user()->name,
        ];
        if ($SubCategory) {
            return $this->successResponse($array, 'ok');
        }
        return $this->errorResponse('the SubCategory Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $SubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoryRequest $request, $id)
    {
        $SubCategory = SubCategory::find($id);
        if (!$SubCategory) {
            return $this->errorResponse('the SubCategory Not Found', 404);
        }
        
        if ($SubCategory->user_id === Auth::id()) {
            $SubCategory->update([
                'name' => $request->name,
                'category_id'=>$request->category_id,
                'user_id' => Auth::id(),
                
              
            ]);
            $array = [
                new SubCategoryResource($SubCategory),
                'name_user' => $user = Auth::user()->name,
            ];
            if ($SubCategory) {
                return $this->successResponse($array, 'the SubCategory update');
            }
        }
        return $this->errorResponse('you con not updet the SubCategory Because you are not authorized', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $SubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $SubCategory = SubCategory::find($id);

        if ($SubCategory->user_id === Auth::id()) {
            $SubCategory->delete();
            if ($SubCategory) {
                return $this->successResponse(null, 'the SubCategory deleted');
            }
            return $this->errorResponse('you con not delete the SubCategory', 400);
        }
        return $this->errorResponse('you con not delete the SubCategory Because you are not authorized', 401);
    }
    public function showsoft()
    {
        $SubCategorys = SubCategory::onlyTrashed()->get();
        return $this->apiResponse($SubCategorys);
    }
    public function restor($id)
    {
        $SubCategory = SubCategory::withTrashed()->where('id', $id)->restore();
        return $this->successResponse($SubCategory, 'the SubCategory restor');
    }
    public function finldelet($id)
    {
        $SubCategory = SubCategory::withTrashed()->where('id', $id)->forceDelete();
        if ($SubCategory) {
            return $this->successResponse(null, 'the SubCategory deleted');
        }
        return $this->errorResponse('you con not delete the SubCategory', 400);
    }
    public function allWithProducts()
    {
        $products = Subcategory::with('products')->get();
        return $this->successResponse($products, 'Show Products.', 200);
    }
}
