@extends('back.layout.master')
@section('content')
@section('title','Kategoriler')
<div class="row">
    <div class="col-md-4">
        <div class="card-shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori Oluştur</h6>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>
                                {{$error}}
                            </li>
                        @endforeach
                    </div>
                @endif
                    <form class="form-group" method="post" action="{{route('admin.category.create')}}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div>
                            <label>Kategorinin Adı</label>
                            <input placeholder="Lütfen yazınızın başlığını giriniz." type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Kategorinin Fotoğrafı</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Kategori Oluştur</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card-shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Kategoriler</h6>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Kategorinin Fotoğrafı</th>
                            <th>Kategori Adı</th>
                            <th>Kategorideki Blog Sayısı</th>
                            <th>Durum</th>
                            <th>Oluşturma ve Güncellenme Tarihleri</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $cat)
                            <tr>
                                <td>
                                    <button style="background-color: white; border: none " class="btn-success showphoto"  data-toggle="modal" data-target="#demoModal">
                                        <img id="{{$cat->image}}" style="width: 150px ; height: 100px" src="{{$cat->image}}" onclick="showIndex(this.id)" alt="">
                                    </button>
                                </td>

                                <td>{{$cat->name}}</td>
                                <td>{{$cat->blogCount()}}</td>
                                <td>
                                    <input type='checkbox' class="switch" category-id="{{$cat->id}}" data-on="Aktif" data-off="Pasif" @if($cat->status==1) checked @endif data-onstyle="success" data-offstyle="danger" data-toggle='toggle'>
                                </td>
                                <td>{{$cat->created_at->diffForHumans()}} Oluşturuldu / {{$cat->updated_at->diffForHumans()}} Güncellendi</td>
                                <td>
                                    <a href="{{route('categorypagedetail',$cat->slug)}}" title="Görüntüle" class="btn-success btn btn-sm"><i class="fa fa-eye"></i></a>
                                    <a category-id="{{$cat->id}}" title="Düzenle" class="btn-primary btn btn-sm edit-click"><i class="fa fa-edit"></i></a>
                                    <a category-id="{{$cat->id}}" category-count="{{$cat->blogCount()}}" category-name="{{$cat->name}}" title="Sil" class="btn-danger btn btn-sm delete-click"><i class="fa fa-times"></i></a>
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

        <!-- The Modal -->
        <div class="modal" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Kategoriyi Düzenle</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>
                                        {{$error}}
                                    </li>
                                @endforeach
                            </div>
                        @endif
                        <form class="form-group" method="post" action="{{route('admin.category.update')}}" enctype="multipart/form-data">
                            @method('DELETE')
                            @csrf
                            <div>
                                <label>Kategorinin Adı</label>
                                <input id="categoryName" placeholder="Lütfen yazınızın başlığını giriniz." type="text" name="name" class="form-control" required>
                                <br>
                            </div>
                            <div class="form-group">
                                <label>Kategorinin Fotoğrafı</label> <br>
                                <img id="categoryImage" src="" class="img-thumbnail rounded" width="300"/>
                                <input  type="file" name="image" class="form-control" >
                                <input type="hidden" name="id" id="category-id">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Kategoriyi Güncelle</button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- The Modal -->
        <div class="modal" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Kategoriyi Sil</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                        <div id="body" class="modal-body">
                            <div class="alert alert-danger" id="blogAlert"></div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
                        <form method="post" action="{{route('admin.category.delete')}}">
                            @csrf
                            <input type="hidden" name="id" id="deleteId">
                            <button id="deleteButton" type="submit" class="btn btn-success">Kategoriyi Sil</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>


@endsection

        @section('js')
            <script>
                $(function (){

                $('.delete-click').click(function (){

                    id = $(this)[0].getAttribute('category-id'); //kategorinin idsini çektik
                    count = $(this)[0].getAttribute('category-count');
                    name = $(this)[0].getAttribute('category-name');

                    if (id==1){
                        $('#blogAlert').html(name +' Kategorisi Sabit Kategoridir Silinen Kategorilerdeki Bloglar Bu Kategoriye Aktarılacaktır');
                        $('#body').show();
                        $('#deleteButton').hide();
                        $('#deleteModal').modal();
                        return;

                    }
                    $('#deleteButton').show();
                    $('#deleteId').val(id);
                    $('#blockAlert').html();
                    $('#body').hide();
                    if (count>0){
                        $('#blogAlert').html(name + ' Kategorisine Ait ' + count + ' Tane Yazı Bulunmaktadır Eğer Silerseniz Blogları Kaybedeceksiniz. Silmek İstediğinize Emin misiniz ? ');
                        $('#body').show();
                    }
                    $('#deleteModal').modal();
                });

                $(document).ready(function() {
                    $('.switch').change(function() {
                        id = $(this)[0].getAttribute('category-id');
                        statu=$(this).prop('checked');
                        $.get("{{route('admin.category.switch')}}", {id:id, statu:statu}, function(data, status){});
                    });
                });

                $('.edit-click').click(function () {
                    id = $(this)[0].getAttribute('category-id'); //kategorinin idsini çektik
                    $.ajax({//ajax kullanarak get methodu ile id yi beliritiler routadaki fonksiyona göndermesini söyledik data olarak
                        type:'GET',
                        url:'{{route('admin.category.edit')}}',
                        data:{id:id},
                        success:function (data) {
                            $('#categoryName').val(data.name); // val bizim inputun valuesüne ulaşmamızı sağlıyor güncellenecek olan kategorinin adını input içerisine bu şekilde yazıdırıyoruz
                            $('#categoryImage').attr('src',data.image);
                            $('#category-id').val(data.id);
                            $('#editModal').modal(); // modalı açıyor bize doların içerisine class ise . id ise # koymayı unutma
                        }
                    });
                });
                })
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
