@extends('front.layouts.master')
@section('title',$blog->title)
@section('subtitle',$blog->subtitle)
@section('bg',$blog->image)
@section('content')

     <div class="col-md-9 mx-auto">
             {!!$blog->description!!}
     </div>
    @include('front.widgets.category-widget')
@endsection
