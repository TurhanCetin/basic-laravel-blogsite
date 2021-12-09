@extends('back.layout.master')
@section('content')
@section('title','Tüm Bloglar')

<div class="card shadow mb-4">
<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">@yield('title')
    <span class="float-right">{{$blogs->count()}} blog bulundu</strong>
        <a href="{{route('admin.deleted.blog')}}" class="btn btn-warning btn-sm"><i class="fa fa-trash"> Silinen Bloglar</i></a>
    </h6>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>Blog Başlık Fotoğrafları</th>
                <th>Blog Başlıkları</th>
                <th>Blog Altbaşlıkları</th>
                <th>Kategoriler</th>
                <th>Hit</th>
                <th>Durum</th>
                <th>Oluşturma ve Güncellenme Tarihleri</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($blogs as $blog)
            <tr>
                <td>
                    <button style="background-color: white; border: none " class="btn-success showphoto"  data-toggle="modal" data-target="#demoModal">
                        <img id="{{$blog->image}}" style="width: 150px ; height: 100px" src="{{$blog->image}}" onclick="showIndex(this.id)" alt="">
                    </button>
                </td>

                <td>{{$blog->title}}</td>
                <td>{{$blog->subtitle}}</td>
                <td>{{$blog->getCatname->name}}</td>
                <td>{{$blog->see}}</td>.
                <td>
                    <input type='checkbox' class="switch" article-id="{{$blog->id}}" data-on="Aktif" data-off="Pasif" @if($blog->status==1) checked @endif data-onstyle="success" data-offstyle="danger" data-toggle='toggle'>
                </td>
                <td>{{$blog->created_at->diffForHumans()}} Oluşturuldu / {{$blog->updated_at->diffForHumans()}} Güncellendi</td>
                <td>
                    <a href="{{route('frontdetailpage',[$blog->getCatName->slug,$blog->slug])}}" title="Görüntüle" class="btn-success btn btn-sm"><i class="fa fa-eye"></i></a>
                    <a href="{{route('admin.blogs.edit',$blog->id)}}"title="Düzenle" class="btn-primary btn btn-sm"><i class="fa fa-pen"></i></a>
                    <a href="{{route('admin.soft.delete.blog',$blog->id)}}" title="Sil" class="btn-danger btn btn-sm"><i class="fa fa-times"></i></a>
                </td>
            </tr>
            @endforeach




            </tbody>
        </table>
    </div>
</div>
</div>


<div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div>
                <button type="button" onclick="document.getElementById('demoModal').style.display='none'" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="test" class="card">

            </div>
        </div>
    </div>
</div>


@endsection

@section('js')

    <script>

        $(document).ready(function() {
            $('.switch').change(function() {
                id = $(this)[0].getAttribute('article-id');
                statu=$(this).prop('checked');
                $.get("{{route('admin.switch')}}", {id:id, statu:statu}, function(data, status){});

            });
        });
    </script>

    <script>

        function showIndex(image_id){
            var image = document.createElement('img');
            image.setAttribute('id', 'photo');
            image.setAttribute('src', image_id);
            var b = document.getElementById('test');
            b.appendChild(image);
        };

        function rmvChild(){
            let element = document.getElementById("test");
            while (element.firstChild) {
                element.removeChild(element.firstChild);
            }
        }

        $("#demoModal").focusout(function () {
            rmvChild();
        });
        $('.close').click(function () {
            rmvChild();
        });

    </script>

@endsection
