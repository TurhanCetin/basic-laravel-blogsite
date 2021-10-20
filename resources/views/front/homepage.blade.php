@extends('front.layouts.master')
@section('title','Anasayfa')
@section('content')
    <div class="col-md-9 mx-auto">
            @foreach($blogs as $blog)
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
        {{$blogs->links("pagination::bootstrap-4")}}
</div>

    @include('front.widgets.category-widget')
@endsection
