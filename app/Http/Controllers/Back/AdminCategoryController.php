<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;


class AdminCategoryController extends Controller
{

    public function index(){

        $categories = Category::get();
        return view('back.category.index',compact('categories'));
    }

    public function create(Request $request){

        $request->validate([
            'name' => 'min:3',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',

        ]);

        $isExist = Category::whereSlug(str_slug($request->name))->first();
        // Slug değeri ile kaydettik çünkü kategorinin ismini alırsak eğer
        // örneğin bilişim yerine bilisim yazarsa biri kabul edecektir
        if($isExist){
            toastr()->error($request->name. 'Adında Bir Kategori Mevcut');
            // !!!!! şU TOASTER HATASINI ARTIK HALLET
            return redirect()->back();
        }

        $category = new Category;
        $category->name = $request->name;
        $category->slug = str_slug($request->name);

        if ($request->hasFile('image')){

            $imagename = str_slug($request->name).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imagename);
            $category->image = '/uploads/'.$imagename;
        }

        $category->save();
        toastr('Başarılı','Kategori Başarıyla Eklendi');
        return redirect()->route('admin.category');
    }


    public function edit(Request $request){
        $category = Category::findorfail($request->id);
    return response()->json($category);
    }


    public function update(Request $request){

        $request->validate([
            'name' => 'min:3',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',

        ]);

        $isExist = Category::whereSlug(str_slug($request->name))->whereNotIn('id',[$request->id])->first();
        //whereNotIn güncelleye girdik ama hiçbir değişiklik yapmadan güncelleye bastığımızda bu kategori var demesin diye bu id dışındakilerde bu var mı diye aradık
        // Slug değeri ile kaydettik çünkü kategorinin ismini alırsak eğer
        // örneğin bilişim yerine bilisim yazarsa kabul edecektir
        if($isExist){
            toastr()->error($request->name. 'Adında Bir Kategori Mevcut');
            // !!!!! şU TOASTER HATASINI ARTIK HALLET
            return redirect()->back();
        }

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = str_slug($request->name);

        if ($request->hasFile('image')){

            $imagename = str_slug($request->name).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imagename);
            $category->image = '/uploads/'.$imagename;
        }

        $category->save();
        toastr('Başarılı','Kategori Başarıyla Güncellendi');
        return redirect()->route('admin.category');
    }

    public function delete(Request $request){
         $category = Category::findorfail($request->id);
         if ($category->id==1){
             toastr()->error('Bu kategori silinemez');
             return redirect()->back();
         }
         $message='';
        $count=$category->blogCount();
         if ($count>0){
             Blog::where('categoryId',$category->id)->update(['categoryId'=>1]);
             $defaultCategory=Category::find(1);
             $message = 'Kategory Başarıyla Silindi Bu kategoriye ait '.$count.' tane blog '.$defaultCategory->name.' aktarıldı. ';
         }
        $category->delete();
        toastr()->success('Kategori Başarıyla Silindi',$message);
        return redirect()->back();
    }


    public function switch(Request $request){
        $category=Category::findorfail($request->id); //Switche bastığmız bloğun idsini requestten çekip onu buluyor yoksa hata veriyor
        $category->status=$request->statu=='true' ? 1 : 0 ; // requestten statusunu çekip bizim db deki statusa aktarıyor ve kaydediyor
        // ? 1: 0 ise true ise 1 false ise 0 yapıyor
        $category->save();//Böylelikle 1 ise 0 0 ise bir oluyor
    }

}
