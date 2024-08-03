@extends('welcome')
@section('content')
    <section id="services-08" class="services-08 pt-120 pb-120 p-relative" style="background: url(/img/bg/aliment-left.png) no-repeat; background-position: left center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-align mb-50 text-center">
                        <h3>{{$quizInfo[0]->title}}</h3>
                    </div>
                </div>
            </div>
            <div class="row services-08-item--wrapper mt-0">
                <div class="col-lg-12 col-md-12" style="border: none;">
                    <form action="{{route('set-results', $quizInfo[0]->id)}}" method="post">
                        @csrf
                        <div class="card" style="background-color:#f1f8fe;padding:10px;">
                            @if($questions)
                                @foreach($questions as $item)
                                <div class="questions-con">
                                    <strong>{{$loop->iteration}} - </strong>
                                    <strong>{{$item->question}}</strong>
                                    <div class="form-check questions-block">
                                        <label>A)</label>
                                        <label class="questions-labels" for="{{$item->id}}1">
                                        <input type="radio" name="{{$item->id}}" id="{{$item->id}}1" value="A" required>
                                        {{$item->A}}
                                        </label>
                                    </div>
                                    <div class="form-check questions-block">
                                        <label>B)</label>
                                        <label class="questions-labels" for="{{$item->id}}2">
                                        <input type="radio" name="{{$item->id}}" id="{{$item->id}}2" value="B" required>
                                            {{$item->B}}
                                        </label>
                                    </div>
                                    <div class="form-check questions-block">
                                        <label>C)</label>
                                        <label class="questions-labels" for="{{$item->id}}3">
                                        <input type="radio" name="{{$item->id}}" id="{{$item->id}}3" value="C" required>
                                            {{$item->C}}
                                        </label>
                                    </div>
                                    <div class="form-check questions-block">
                                        <label>D)</label>
                                        <label class="questions-labels" for="{{$item->id}}4">
                                        <input type="radio" name="{{$item->id}}" id="{{$item->id}}4" value="D" required>
                                            {{$item->D}}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            <button type="submit" class="btn btn-info btn-sm rounded-pill btn-block" style="display:flex;justify-content:center;align-items:center;max-height:34px;">
                                <span>BİTİR</span>
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop
