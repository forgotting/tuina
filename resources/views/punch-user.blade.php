<!-- punch.blade.php -->
@extends('layout')

@section('title', '打卡')

@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.min.css') }}"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.css"/>
@endsection

@section('content')
<style>
    .title {
        font-size:50px;
    }
</style>

<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">打卡紀錄</div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="font-size: 30px;">{{ $user_name }}</div>
                        <div class="panel-body">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" style="margin-top: 100px;" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        {{ Form::hidden('user_id', Request::route('id'), ['id' => 'user_id']) }}
        <div class="modal-content">
            <div class="modal-body">
                <h4>請假時間</h4>

                開始時間:
                <br />
                <input type="text" id="start_time" name="start_time" class="form-control">
                
                結束時間:
                <br />
                <input type="text" class="form-control" name="finish_time" id="finish_time">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <input type="button" class="btn btn-primary" id="punch_update" value="儲存">
            </div>
        </div>
    </div>
</div>
@include('login')
@endsection
@section('page-js-files')
<!--script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script-->
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment-with-locales.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.js"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/locale/bootstrap-datepicker.zh-TW.min.js') }}"></script>
<!--script src="//www.helloweba.net/demo/2017/Fullcalendar/lib/locale/zh-tw.js"></script-->
@stop
@section('page-js-script')
<script type="text/javascript">
<!--
$(document).ready(function() {
    $("#loginModal").modal('show');
    $('#loginModal').on('hidden.bs.modal', function () {
        window.location.href = "{{ route('punch') }}";
    });
    $("#loginSubmit").on('click', function(e) {
        e.preventDefault();
        var id = {{ Request::route('id') }};
        var data = {
            _token: '{{ csrf_token() }}',
            id: $("[name='id']").val(),
            password: $("[name='password']").val()
        };

        $.post('/login', data, function(result) {

            if (result.result == true) {
                $("#loginModal").hide();
                $(".modal-backdrop").remove();
                $('#calendar').fullCalendar({
                    // put your options and callbacks here
                    customButtons: {
                        punchButton: {
                            text: '請假',
                            click: function() {
                                $('#editModal').modal();
                            }
                        },
                        excelButton: {
                            text: '下載',
                            click: function(e) {
                                e.preventDefault();
                                var date = new Date();
                                var getmonth = $('#calendar').fullCalendar('getDate');
                                var year = getmonth.format('YYYY');
                                var month = getmonth.format('MM');
                                window.location.href = "{{ url('/excel/export/punch/'.Request::route('id')) }}/" + year +"-"+ month;
                            }
                        }
                    },
                    header: {
                        left: 'prev, next today',
                        center: 'title',
                        right: 'punchButton, excelButton'
                    },
                    buttonText: {
                        today: '今天',
                        month: '月',
                        week: '周',
                        day: '日'
                    },
                    views: {
                        month: {
                            titleFormat: 'YYYY年 M月',
                            columnFormat: 'dddd'
                        }
                    },
                    monthNames: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
                    dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
                    defaultView: 'month',
                    firstDay: 1,
                    timeFormat: 'H(:mm)',
                    displayEventTime: false,
                    timezone: 'Asia/Taipei',
                    events: [
                        @foreach($events as $event)
                        {
                            id: '{{ $event->id }}',
                            title: '{{ $event->title }} {{ $event->time }}',
                            start: '{{ $event->year_month }}-{{ $event->date }} {{ $event->time }}',
                            color: '#337AB7',
                            @if ($event->title == "下班")
                                color: '#5CB85C',
                            @endif
                            @if ($event->end_date != "")
                                title: '{{ $event->title }} {{ $event->time }} ~ {{ $event->end_time }}',
                                end: '{{ $event->end_year_month }}-{{ $event->end_date }} {{ $event->end_time }}',
                                color: 'red',
                            @endif
                        },
                        @endforeach
                    ],
                });
            } else {
                $("#alertMsg").html(result.msg);
            }
        });
    });

    $('#punch_update').click(function(e) {
        e.preventDefault();
        var data = {
            _token: '{{ csrf_token() }}',
            user_id: $('#user_id').val(),
            start_time: $('#start_time').val(),
            finish_time: $('#finish_time').val(),
        };

        $.post('/punch/ajax_update', data, function( result ) {
            /*$('#calendar').fullCalendar('removeEvents', $('#event_id').val());*/

            $('#calendar').fullCalendar('renderEvent', 
            {
                title: result.event.title + ' ' + result.event.time + '~' + result.event.end_time,
                start: result.event.date + ' ' + result.event.time,
                end: result.event.end_date + ' ' + result.event.end_time,
                color: 'red',
            }, true);
            $('#editModal').modal('hide');
        });
    });
    $('#start_time').datetimepicker({
        language: "zh-TW",
        format: 'yyyy-mm-dd hh:ii',
        todayBtn:  1,
        daysOfWeekDisabled: "0",
        showClear: true,
        showClose: true,
    })
    $('#finish_time').datetimepicker({
        language: "zh-TW",
        format: 'yyyy-mm-dd hh:ii',
        todayBtn:  1,
        daysOfWeekDisabled: "0",
    })
});
//-->
</script>
@stop