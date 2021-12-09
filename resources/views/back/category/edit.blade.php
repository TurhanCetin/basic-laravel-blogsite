@extends('back.layout.master')
@section('content')
@section('title',$category->name)

<div class="card shadow mb-4">
<div class="card-header py-3">
    <h6 style="display: inline-block" class="m-0 font-weight-bold text-primary">@yield('title')</h6>
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
        <form class="form-group" method="post" action="{{route('admin.category.update',$category->id)}}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div>
                <label>Kategorinin Adı</label>
                <input value="{{$category->name}}" placeholder="Lütfen yazınızın başlığını giriniz." type="text" name="name" class="form-control" required>
                <br>
            </div>
            <div class="form-group">
                <label>Kategorinin Fotoğrafı</label> <br>
                <img src="{{asset($category->image)}}" class="img-thumbnail rounded" width="300"/>
                <input type="file" name="image" class="form-control" >
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Kategoriyi Güncelle</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editor').summernote({
                'height':300
            }
            );
        });
    </script>
@endsection

