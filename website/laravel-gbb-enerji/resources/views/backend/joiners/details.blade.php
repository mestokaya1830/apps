@extends('backend.dashboard')
@section('content')

 <div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="custom-toolbar">
          <h2>Katılımcı Detay Sayfası</h2>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                    <tbody>
                      @if($joinerDetails)
                        @foreach($joinerDetails as $item)
                            <tr>
                                <td style="width:140px;font-size:18px;">Soru</td>
                                <td style="font-size:18px;">{{$item['question']}}</td>
                            </tr>
                            <tr>
                                <td style="color: cadetblue;font-size:16px;">A</td>
                                <td style="color: cadetblue;font-size:16px;">{{$item['A']}}</td>
                            </tr>
                            <tr>
                                <td style="color: cadetblue;font-size:16px;">B</td>
                                <td style="color: cadetblue;font-size:16px;">{{$item['B']}}</td>
                            </tr>
                            <tr>
                                <td style="color: cadetblue;font-size:16px;">C</td>
                                <td style="color: cadetblue;font-size:16px;">{{$item['C']}}</td>
                            </tr>
                            <tr>
                                <td style="color: cadetblue;font-size:16px;">D</td>
                                <td style="color: cadetblue;font-size:16px;">{{$item['D']}}</td>
                            </tr>
                            <tr >
                                <td style="width:140px;">
                                    <span style="color:lightseagreen;margin-right:20px;">Doğru Cevap: {{$item['correct_answer']}}</span>
                                    @if($item['correct_answer'] === $item['answers'])
                                        <span style="color:lightseagreen">Verilen Cevap: {{$item['answers']}}</span>
                                        @else
                                        <span style="color:red">Verilen Cevap: {{$item['answers']}}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                      @endif
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(function(){
        $('#dt-basic-example').dataTable();
    });
</script>

@endsection
