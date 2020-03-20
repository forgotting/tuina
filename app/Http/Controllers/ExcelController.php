<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\User;
use App\Punch;

class ExcelController extends Controller
{
    //
    public function punchExport(Request $request, $id, $year, $month) {
        $punch = new Punch;
        $users = new User;
        $user_name = $users::where('id', $id)->first()->name;
        $punches = $punch::where('punch_year_month', $year.$month)->get();
        $cellData[] = ['日期', '上班時間', '下班時間', '請假開始時間', '請假結束時間'];

        $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        //dd($punches);

        for($day = 1; $day <= $month_days; $day++) {
            $start_time = "";
            $end_time = "";
            $punch_time = "";
            $punch_end_time = "";

            foreach ($punches as $key => $value) {

                if ($value->punch_date == $day) {

                    if ($value->description == "1") {
                        $start_time = $value->punch_time;
                    }

                    if ($value->description == "2") {
                        $end_time = $value->punch_time;
                    }
                }

                if ($value->description == "3") {

                    if ($value->punch_date <= $day && $value->punch_end_date >= $day) {
                        
                        if ($value->punch_date == $day) {
                            $punch_time = $value->punch_time;
                        }

                        if ($value->punch_end_date == $day) {
                            $punch_end_time = $value->punch_end_time;
                        }
                    }
                }
            }
            $cellData[] = [$day, $start_time, $end_time, $punch_time, $punch_end_time];
        }
        //dd($cellData);
        Excel::create('打卡紀錄-'. $user_name .'-'. $year . $month,function ($excel) use ($cellData, $user_name, $year, $month)
        {
            $excel->sheet($user_name .'-'. $year . $month, function ($sheet) use ($cellData)
            {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

}
