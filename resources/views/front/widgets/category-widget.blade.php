<div class="col-md-3">
    <div class="card">
        <div class="card-header"><a href="{{route('categorypage')}}">Kategoriler</a> </div>
    </div>
    @foreach($categories as $category)
    <ul class="list-group">
        <a href="{{route('categorypagedetail',$category->slug)}}" class="list-group-item d-flex justify-content-between align-items-center">
            {{$category->name}}
            <span class="badge badge-primary badge-pill alert-dark">{{$category->blogCount()}}</span>
        </a>
        @endforeach
    </ul>
</div>
