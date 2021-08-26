<!-- acupoint.blade.php -->
@extends('layout')

@section('title', '穴道')

@section('header')
    @parent
@endsection

@section('content')
<style>
    #greenhouse {
        position: relative;
        width: 100%;
        vertical-align: middle;
        margin: 0;
        overflow: hidden;
    }

    #greenhouse svg { 
        display: inline-block;
        position: absolute;
        top: 0; 
        left: 0;
    }

</style>
<div class="flex-center position-ref full-height">
    @include('login')
        {!! Form::open(['url' => '/quote/'.Request::route('id'), 'method' => 'post']) !!}
        {{ Form::hidden('id', Request::route('id')) }}
        <div class="row" style="margin-top: 100px;">
        <table border="1">
            <tr>
                <td rowspan="4" width="200" height="500">
                    <div id="greenhouse">
                        <svg viewBox="0 0 300 600" preserveAspectRatio="xMinYMin meet" id="body">
                            <img src={{ asset('uploads/images/body.jpeg') }} 
                            alt="body" width="300">
                        </svg>
                    </div>
                </td>
                <td rowspan="4" width="200" height="300">
                    <div id="greenhouse">
                        <svg viewBox="0 0 200 200" preserveAspectRatio="xMinYMin meet" id="ear">
                            <img src={{ asset('uploads/images/ear.svg') }} 
                            alt="ear" width="200">
                        </svg>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" width="150" height="100" style="text-align: center;">
                <div class="btn-group">
                    <button type="button" 
                        class="btn btn-primary dropdown-toggle" 
                        data-toggle="dropdown" 
                        aria-expanded="false"
                        id="sick">
                        疾病 
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li value="1"><a href="#">手痛</a></li>
                        <li value="2"><a href="#">頭痛</a></li>
                        <li value="3"><a href="#">腳痛</a></li>
                    </ul>
                </div>
                </td>
            </tr>
            <tr>
                <td width="100" height="80" style="text-align: center;">
                    <button type="button" class="btn btn-success" id="body_point">身體</button>
                </td>
                <td width="100" height="80" style="text-align: center;">
                    <button type="button" class="btn btn-success" id="ear_point">耳朵</button>
                </td>
            </tr> 
            <tr>
                <td colspan="2" class="word_style" style="text-align: center;">
                    <div class="btn-group-vertical" role="group" id="acupoint"></div>
                </td>
            </tr>        
        </table>
        <br>
        <!--a class="btn btn-primary btn-lg" href="{{ url()->previous() }}" style="margin-right: 50px;">取消</!--a>
        {!! Form::submit('送出', ['class' => 'btn btn-success btn-lg']) !!}
        {!! Form::close() !!}-->
    </div>
</div>
@endsection
@section('page-js-script')
<script type="text/javascript">
    $("#ear_point").click(function(){
        var ears = [];

        @foreach($ears as $e)
            ears.push([ {{$e->ear_x}}, {{$e->ear_y}}, '{{ $e->name }}']);
        @endforeach

        ear_html_obj = ears_to_ear(ears);

        $("#body").html("");
        $("#ear").html(ear_html_obj.ear_html);
        $("#acupoint").html(ear_html_obj.ear_html_button);
    });
    $("#body_point").click(function(){
        var bodys = [];

        @foreach($bodys as $b)
            bodys.push([ {{$b->body_x}}, {{$b->body_y}}, '{{ $b->name }}']);
        @endforeach

        body_html_obj = bodys_to_body(bodys);
        
        $("#ear").html("");
        $("#body").html(body_html_obj.body_html);
        $("#acupoint").html(body_html_obj.body_html_button);
    });
    $('li').click(function(){
        $("#sick").html($(this).text() + '<span class="caret"></span>');
        var ears = [];
        var bodys = [];

        if ($(this).val() == "1") {
            @foreach($ears as $e)
                if ({{ $e->id }} <=2 ) {
                    ears.push([{{$e->ear_x}}, {{$e->ear_y}}, '{{ $e->name }}']);
                }
            @endforeach
        }

        if ($(this).val() == "2") {
            @foreach($ears as $e)
                if ({{ $e->id }} > 2 ) {
                    ears.push([{{$e->ear_x}}, {{$e->ear_y}}, '{{ $e->name }}']);
                }
            @endforeach

            @foreach($bodys as $b)
                bodys.push([{{$b->body_x}}, {{$b->body_y}}, '{{ $b->name }}']);
            @endforeach
        }

        if ($(this).val() == "3") {
            @foreach($ears as $e)
                ears.push([{{$e->ear_x}}, {{$e->ear_y}}, '{{ $e->name }}']);
            @endforeach

            @foreach($bodys as $b)
                bodys.push([{{$b->body_x}}, {{$b->body_y}}, '{{ $b->name }}']);
            @endforeach
        }

        ear_html_obj = ears_to_ear(ears);
        body_html_obj = bodys_to_body(bodys);

        $("#ear").html(ear_html_obj.ear_html);
        $("#body").html(body_html_obj.body_html);
        $("#acupoint").html(ear_html_obj.ear_html_button + body_html_obj.body_html_button);
    });

    function acupoint_body_show(arr) {
        $("#ear").html("");
        acupoint_body(arr);
    }
    function acupoint_ear_show(arr) {
        $("#body").html("");
        acupoint_ear(arr);
    }
    function acupoint_body(arr) {
        $("#body").html("<circle cx="+arr[0]+" cy="+arr[1]+" r='3' stroke='black' stroke-width='1' fill='red'/>"
            );
    }
    function acupoint_ear(arr) {
        $("#ear").html("<circle cx="+arr[0]+" cy="+arr[1]+" r='5' stroke='black' stroke-width='2' fill='red'/>");
    }
    function ears_to_ear(ears) {
        var ear_html_button = "";
        var ear_html = "";

        for(var ear in ears) {
            ear_html_button = ear_html_button + "<button onclick='acupoint_ear_show(["+ears[ear][0]+","+ears[ear][1]+"])' type='button' class='btn btn-default' style='margin-top: 5px;'>"+ears[ear][2]+"</button>";
            ear_html = ear_html + "<circle cx="+ears[ear][0]+" cy="+ears[ear][1]+" r='5' stroke='black' stroke-width='2' fill='red'/>";
        }

        return {ear_html, ear_html_button};
    }
    function bodys_to_body(bodys) {
        var body_html_button = "";
        var body_html = "";

        for(var body in bodys) {
            body_html_button = body_html_button + "<button onclick='acupoint_body_show(["+bodys[body][0]+","+bodys[body][1]+"])' type='button' class='btn btn-default' style='margin-top: 5px;'>"+bodys[body][2]+"</button>";
            body_html = body_html + "<circle cx="+bodys[body][0]+" cy="+bodys[body][1]+" r='3' stroke='black' stroke-width='1' fill='red'/>";
        }
        
        return {body_html, body_html_button};
    }

</script>
@stop