@extends('layout')
@section('content')
  <h3 style="text-align:center;">Düğümler</h3>
  @isset($nodes)
    @foreach($nodes as $item)
      <div class="row nodes-list">
        <div class="col-lg-12 col-md-12 col-sm-12">{{$item->id}}</div>
        @foreach($edges as $item2)
        @if($item->id == $item2->source)
        <div class="col-lg-12 col-md-12 col-sm-12 nodes-sub-category">{{$item2->id}}</div>
        @endif
        @endforeach
      </div>
    @endforeach
  @endisset
@stop
