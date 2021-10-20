@extends('front.layouts.master')
@section('title',$catDetail->name.' Kategorisi')
@section('bg')
@section('content')

    <div class="col-md-9 mx-auto">
        @if(count($blogOfCategory)>0)
        @foreach($blogOfCategory as $blog)
            <div  class="post-preview">
                <a href="{{route('frontdetailpage',[$blog->getCatName->slug,$blog->slug])}}">
                    <img src="{{$blog->image}}">
                    <h2 class="post-title">{{$blog->title}}</h2>
                    <h5 class="post-subtitle">{{$blog->subtitle}}</h5>
                </a>
                <span style="float:left;margin-right: 10px" class="badge badge-primary badge-pill alert-dark">{{$blog->see}}</span>
                <h6 style="font-weight: normal; margin-top: 15px">kişi tarafından okundu</h6>
                <p class="post-meta">Kategori:
                    <a href="{{route('categorypagedetail',$blog->getCatName->slug)}}">{{$blog->getCatName->name}}</a>
                    <span style="float: right">{{$blog->created_at->diffForHumans()}}</span>
                </p>
            </div>
            @if(!$loop->last)
                <hr>
            @endif
        @endforeach
            {{$blogOfCategory->links("pagination::bootstrap-4")}}
            @else
            <div class="alert alert-danger" role="alert">
                Şuanda bu kategoride bir blog yazısı bulunmamaktadır. <a href="{{route('categorypage')}}" class="alert-link">Kategoriler</a>. Kategorilere ulaşmak için tıklayınız.
            </div>
            @endif
    </div>
@endsection
