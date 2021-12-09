<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Blogs;
use Illuminate\Support\Facedes\DB;

class Homepage extends Controller
{
    public function index(){
        $data['categories']=Category::where('status',1)->get();
        $data['blogs']=Blog::orderby('created_at','DESC')->paginate(2); // paginate kullandığın yerde get kullanamazsın !!!
        $data['blogs']->withPath(url('sayfa')); // paginate için url tanımlıyoruz url() içerisinde yazmassak eğer 2. sayfadan 1.ye geçerken sıkıntı yaratıyor
        return view('front.homepage',$data);
    }



}
