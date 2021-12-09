<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $data['allCategories']=Category::where('status',1)->paginate(4);
        $data['blogs']=Blog::orderby('created_at','DESC')->get();
        return view('front.categorypage',$data);

    }
    public function catDetail($slug){
        $category=Category::whereSlug($slug)->first() ?? abort(403,'Böyle bir kategori bulunamadı');
        $data['catDetail']=$category;
        $data['blogOfCategory']=Blog::where('categoryid',$category->id)->orderby('created_at','DESC')->paginate(1);
        return view('front.categorydetailpage',$data);

    }
}
