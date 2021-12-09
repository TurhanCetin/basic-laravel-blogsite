<?php

namespace App\Http\Controllers\Back;
// Eğer kontrollerın bir klasörün içerisindeyse name space'ini klasöre göre importunu direkt kontroller üzerine vericeksin !!
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['blogs'] = Blog::orderBy('created_at','ASC')->get();
        //return view('back.blogs.index',$blogs); // burada diğer yerlerde verdiğimiz gibi direkt ismiyle verirsek dizi olmadığı için
        //hata verecektir o yüzden compact() methodunu kullanmamız gerekiyor
        return view('back.blogs.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::all();
        return view('back.blogs.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'title' => 'min:3',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048', // uzantı kontrolü yapmamız gerektiğinde mimes ifadesini kullanmamamız gerekmektedir.


        ]);

        $blogs=new Blog; // burada blog modeline ulaşarak tablodaki columlara ulaşmak için bir değişkene atıyoruz
        $blogs->title = $request->title;
        $blogs->subtitle = $request->subtitle;
        $blogs->categoryid = $request->category;
        $blogs->description = $request->description;
        $blogs->slug = str_slug($request->title);

        //Fotoğrad upload etme
        //ilk olarak requestten bir foto geldimi diye kontrol etmemiz gerekiyor
        if ($request->hasFile('image')){ // hasfile kullandık çünkü formda fotoğrafı file olarka gönderiyoruz
            $imageName=str_slug($request->title).'.'.$request->image->getClientOriginalExtension(); // ilk olarak imageimize bir isim atıyoruz
            //ardından getClientOriginalExtension ile de fotoğrafın uzantısını alıyoruz.
            // yani sonuç olarak (bizim atadığmız isimi nokta fotoğrafın requesten gelen görüntüsü.uzantısı)
            $test = $request->image->move(public_path('uploads'),$imageName);
            // buradada postlanan fotoğrafın proje içerisnde nerede tutulacağını belirtiyoruz
            $blogs->image = '/uploads/'.$imageName; // !!! burada başa slush koymaz isek olduğu dizinden gider ve resime ulaşamaz
            //burada ise oluşturduğumuz isimle beraber uploads'a şu isimde image yolladığımızı söylüyoruz
        }   // veritabanına uzantısı ve yolu ile beraber
        $blogs->save();
        toastr()->success('Başarılı','Blog Başarıyla Oluşturuldu');
        return redirect()->route('admin.blogs.index');

        // burada kaydedip index methoduna ulaşarak oluşturduğumu front tableında görüntülüyoruzs
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog=Blog::findorfail($id);
        $data['categories'] = Category::all();
        return view('back.blogs.edit',$data,compact('blog'));
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
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048', // uzantı kontrolü yapmamız gerektiğinde mimes ifadesini kullanmamamız gerekmektedir.


        ]);

        $blogs=Blog::findorfail($id); // burada blog modeline ulaşarak tablodaki columlara ulaşmak için bir değişkene atıyoruz
        $blogs->title = $request->title;
        $blogs->subtitle = $request->subtitle;
        $blogs->categoryid = $request->category;
        $blogs->description = $request->description;
        $blogs->slug = str_slug($request->title);

        //Fotoğrad upload etme
        //ilk olarak requestten bir foto geldimi diye kontrol etmemiz gerekiyor
        if ($request->hasFile('image')){ // hasfile kullandık çünkü formda fotoğrafı file olarak gönderiyoruz
            $imageName='updated'.str_slug($request->title).'.'.$request->image->getClientOriginalExtension(); // ilk olarak imageimize bir isim atıyoruz
            //ardından getClientOriginalExtension ile de fotoğrafın uzantısını alıyoruz.
            // yani sonuç olarak (bizim atadığmız isimi nokta fotoğrafın requesten gelen görüntüsü.uzantısı)
            $request->image->move(public_path('uploads'),$imageName);
            // buradada postlanan fotoğrafın proje içerisnde nerede tutulacağını belirtiyoruz
            $blogs->image = '/uploads/'.$imageName; // !!! burada başa slush koymaz isek olduğu dizinden gider ve resime ulaşamaz
            //burada ise oluşturduğumuz isimle beraber uploads'a şu isimde image yolladığımızı söylüyoruz
        }   // veritabanına uzantısı ve yolu ile beraber
        $blogs->save();
        toastr()->success('Başarılı','Blog Başarıyla Güncellendi');
        return redirect()->route('admin.blogs.index');

        // burada kaydedip index methoduna ulaşarak oluşturduğumu front tableında görüntülüyoruzs
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) // silme işlemi yapoarken destroyu kullanmıyoruz çünkü bizden bir form göndermemizi istiyor.
        //onun yerine biz kendi delete methodumuzu oluşturarak siliyoruz.
    {
        //
    }



    public function softDelete($id){
        Blog::find($id)->delete();
        toastr()->success('Blog Başarıyla Silindi');
        return redirect()->back();

    }



    public function trashed(){
        $blogs=Blog::onlyTrashed()->get();
        toastr()->success('Blog Geri Dönüşüm Kutusuna Atıldı');
        return view('back.blogs.trashed',compact('blogs'));
    }



    public function recover($id){

        Blog::withTrashed()->find($id)->restore();
        toastr()->success('Blog Başarıyla Kurtarıldı');
        return redirect()->route('admin.blogs.index');

    }



    public function hardDelete($id){
       $blog = Blog::onlyTrashed()->find($id);
       if (File::exists($blog->image)){ // File kütüphanesini kullanarak resmi buluyourz
           File::delete(public_path($blog->image)); // daha sonra ise delete fonksiyonunu kullanarak siliyoruz
           // Resimi uploads klasöründen silmeye bak !!
       }
       $blog->forceDelete();
        toastr()->success('Blog Tamamen Silindi');
        return redirect()->route('admin.blogs.index');

    }

    public function switch(Request $request){
        $blog=Blog::findorfail($request->id); //Switche bastığmız bloğun idsini requestten çekip onu buluyor yoksa hata veriyor
        $blog->status=$request->statu=='true' ? 1 : 0 ; // requestten statusunu çekip bizim db deki statusa aktarıyor ve kaydediyor
        // ? 1: 0 ise true ise 1 false ise 0 yapıyor
        $blog->save();//Böylelikle 1 ise 0 0 ise bir oluyor
    }

}
