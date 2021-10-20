<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Blog;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blogSingle($category,$slug){
        $category=Category::whereSlug($category)->first() ?? abort(403,'Böyle bir kategori bulunamadı');
        $blog =Blog::where('slug',$slug)->whereCategoryid($category->id)->first() ?? abort(403,"Böyle bir yazı bulunamadı");
        $blog->increment('see');
        $data['blog']=$blog;
        $data['categories']=Category::get();
        return view('front.blogpage',$data);
    }
}
