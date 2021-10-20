@extends('front.layouts.master')
@section('title','Kategoriler')
@section('subtitle','Bütün Kategoriler')
@section('bg')
@section('content')

    <div class="col-md-9 mx-auto" >
            <div class="custom_flex">
        @foreach($allCategories as $cat)
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <img class="card-img-top" src="{{$cat->image}}" alt="Card image cap">
                            <h5 class="card-title">{{$cat->name}}</h5>
                            <span>{{$cat->blogCount()}} Tane Yazı Bulunmaktadır</span>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="{{route('categorypagedetail',$cat->slug)}}" class="btn btn-primary">Kategori Sayfasına Git</a>
                        </div>
                    </div>
                </div>
        @endforeach
            {{$allCategories->links("pagination::bootstrap-4")}}

            </div>
    </div>
    <style>
        .custom_flex { display: flex; flex-direction: row; flex-wrap: wrap}
        .card-title { margin-top: 10px}
    </style>
@endsection
