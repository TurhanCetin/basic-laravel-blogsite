@extends('back.layout.master')
@section('content')
@section('title',$blog->title)

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
    <form class="form-group" method="post" action="{{route('admin.blogs.update',$blog->id)}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div>
            <label>Bloğun Başlığı</label>
            <input  type="text" name="title" class="form-control"  value="{{$blog->title}}" required>
        </div>
        <div>
            <label>Bloğun Altbaşlığı</label>
            <input type="text" name="subtitle" class="form-control" value="{{$blog->subtitle}}" required>
        </div>
        <div class="form-group">
            <label for="">Kategori</label>
            <select name="category" class="form-control" required>
                <option value="">Kategori Seçiniz</option>
                @foreach($categories as $category)
                <option @if($blog->categoryid==$category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Bloğun Fotoğrafı</label> <br>
            <img src="{{asset($blog->image)}}" class="img-thumbnail rounded" width="300"/>
            <input type="file" name="image" class="form-control" >
        </div>
        <div class="form-group">
            <label>Bloğun İçeriği</label>
            <textarea  id="editor" name="description" class="form-control" rows="4">{!!$blog->description!!}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Bloğu Güncelle</button>
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

