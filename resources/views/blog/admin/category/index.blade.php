@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @foreach($paginator as $item)
                @php /** \App\Models\BlogCategory $item */   @endphp
            <div class="col-md-1">
              {{$item->id}}
            </div>
            <div class="col-md-9">
                <a href="{{route('blog.admin.categories.edit', $item->id)}}">{{$item->title}}</a>

            </div>
            <div class="col-md-2">

            </div>
            @endforeach
        </div>
    </div>
@endsection

