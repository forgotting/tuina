<!-- punch.blade.php -->
@extends('layout')

@section('title', '打卡')

@section('header')
    @parent
@endsection

@section('content')
<style>
    .title {
        font-size:90px;
    }
    .title a:link {
        color: #333333; 
        text-decoration: none;
    }
    .title a:hover {
        opacity: 0.7;
    }
</style>

<div class="flex-center position-ref full-height">
    @include('login')

    <div class="content">
        <table class="table" align="center" style="width: 850px; margin-top: 100px;">
            <thead>
                <tr>
                    <th scope="col" colspan="3" style="font-size: 90px; height: 100px;border-bottom: none; padding-bottom: 100px;">
                        <p id="display-datetime" style="text-align: center;"></p>
                        <p id="punch_year_month" style="display: none;"></p>
                        <p id="punch_date" style="display: none;"></p>
                        <p id="punch_time" style="display: none;"></p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($start_punch as $s)
                    <td class="title" style="border-top: none;"><a href="/punch/{{ $s->id }}">{{ $s->name }}</a>
                        <div class="links">
                                @if (isset($s->start_time))
                                    <button type="button" class="btn btn-primary btn-lg" disabled="true">{{ $s->start_time }}</button>
                                @else
                                    <button id='start' type="button" class="btn btn-primary btn-lg" value={{ $s->id }}>上班</button>
                                @endif
                                @if (isset($s->stop_time))
                                    <button type="button" class="btn btn-success btn-lg" disabled="true">{{ $s->stop_time }}</button>
                                @else
                                    <button id='stop' type="button" class="btn btn-success btn-lg" value={{ $s->id }}>下班</button>
                                @endif
                        </div>
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('page-js-script')
<script type="text/javascript">
    $(document).ready(function () {
        setInterval(function(){
            var date = new Date();
            var format = "YYYY-MMM-DD DDD";
            dateConvert(date,format)
        }, 1);
        $(".btn-primary").click({url: "{{ url('/punch/start_work/') }}"}, punch);
        $(".btn-success").click({url: "{{ url('/punch/stop_work/') }}"}, punch);
    });

    function dateConvert(dateobj, format) {
        var year = dateobj.getFullYear();
        var month= ("0" + (dateobj.getMonth()+1)).slice(-2);
        var date = ("0" + dateobj.getDate()).slice(-2);
        var hours = ("0" + dateobj.getHours()).slice(-2);
        var minutes = ("0" + dateobj.getMinutes()).slice(-2);
        var seconds = ("0" + dateobj.getSeconds()).slice(-2);
        var day = dateobj.getDay();
        var months = ["01","02","03","04","05","06","07","08","09","10","11","12"];
        var converted_date = "";

        switch(format) {
            case "YYYY-MM-DD":
                converted_date = year + "-" + month + "-" + date;
                break;
            case "YYYY-MMM-DD DDD":
                converted_date = year + "-" + months[parseInt(month)-1] + "-" + date
                + " " + hours + ":" + minutes;
                break;
        }
        //return converted_date;
        // to show it I used innerHTMl in a <p> tag
        document.getElementById("display-datetime").innerHTML = converted_date;
        document.getElementById("punch_year_month").innerHTML = year + months[parseInt(month)-1];
        document.getElementById("punch_date").innerHTML = date;
        document.getElementById("punch_time").innerHTML = hours + ":" + minutes;
    }

    function punch (event) {
        let $id = $(this).attr("value");
        let $punch_year_month = document.getElementById("punch_year_month").innerHTML;
        let $punch_date = document.getElementById("punch_date").innerHTML;
        let $punch_time = document.getElementById("punch_time").innerHTML;
        var success_result;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            async: false,
            type: "POST",
            data: { 
                "id" : $id , 
                "punch_year_month" : $punch_year_month , 
                "punch_date" : $punch_date,
                "punch_time" : $punch_time,
            },
            dataType: "json",
            url: event.data.url,
            success:function(result){
                success_result = result;
            }
        });
        $(this).text(success_result);
        $(this).attr("disabled", true);
    }
</script>
@stop