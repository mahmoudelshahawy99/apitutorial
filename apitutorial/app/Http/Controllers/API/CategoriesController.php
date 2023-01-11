<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use App\Http\Controllers\Controller;


class CategoriesController extends Controller
{
    use GeneralTrait;

    public function index(){

        $categories = Category::selection()->get();
        return $this->returnData('Categories', $categories,'categories found');
    }

    public function getCategoryById(Request $request){

        $category = Category::selection()->find($request->id);
        if(!$category){
            return $this->returnError('001','category not found');
        }else{
            return $this->returnData('Category', $category,'category found');
        }
    }

    public function changeStatus(Request $request){
        Category::where('id',$request->id)->update(['active' => $request->active]);
        return $this->returnSuccessMessage('Category updated successfully','001');
    }
}
