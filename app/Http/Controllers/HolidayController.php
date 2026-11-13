<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use DataTables;
use App\Holiday;

class HolidayController extends Controller
{
    //===== ADD HOLIDAY & UPDATE HOLIDAY =====//
    public function add_holiday(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();
        // return $data;

        if (!isset($request->holiday_id)) {
            $rules = [
                'holiday_name' => 'required|string|max:255',
                'holiday_month' => 'required|string|max:255',
                'holiday_day' => 'required|string|max:255'
            ];

            $validator = Validator::make($data, $rules);

            if ($validator->passes()) {
                if (Holiday::where('name', $request->holiday_name)->where('logdel', 0)->exists()) {
                    return response()->json(['result' => "2"]);
                } else {
                    $insert_holiday = [
                        'name' => $request->holiday_name,
                        'month' => $request->holiday_month,
                        'day' => $request->holiday_day,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    Holiday::insert(
                        $insert_holiday
                    );
                    return response()->json(['result' => "1"]);
                }
            } else {
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        } else {
            $rules = [
                'holiday_name' => 'required|string|max:255',
                'holiday_month' => 'required|string|max:255',
                'holiday_day' => 'required|string|max:255'
            ];

            $validator = Validator::make($data, $rules);

            if ($validator->passes()) {
                // if (Holiday::where('name', $request->holiday_name)->where('logdel', 0)->exists()) {
                //     return response()->json(['result' => "2"]);
                // } else {

                    $update_holiday = [
                        'name' => $request->holiday_name,
                        'month' => $request->holiday_month,
                        'day' => $request->holiday_day,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];


                    if (isset($request->holiday_id)) {
                        Holiday::where('id', $request->holiday_id)->update(
                            $update_holiday
                        );
                        return response()->json(['result' => "1"]);
                    }

                    return response()->json(['result' => "1"]);
                // }
            } else {
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        }
    }

    public function get_holiday_by_id(Request $request)
    {
        $holiday_details = Holiday::where('id', $request->holidayId)->get();
        return response()->json(['result' => $holiday_details]);
    }

    public function delete_holiday(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all(); // collect all input fields

        $validator = Validator::make($data, [
            'holiday_id' => 'required'
        ]);

        if ($validator->passes()) {

            Holiday::where('id', $request->holiday_id)
                ->update(
                    [
                        'logdel' => 1
                    ]
                );
            return response()->json(['result' => "1"]);
        } else {
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }

    public function view_holiday()
    {
        $holiday_details = Holiday::where('logdel', 0)->get();

        return DataTables::of($holiday_details)
            ->addColumn('holiday_status', function ($holiday_details) {
                $result = "";
                if ($holiday_details->logdel == 0) {
                    $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
                } else {
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Inactive</span></center>';
                }
                return $result;
            })
            ->addColumn('holiday_date', function ($holiday_details) {
                $result = "";

                $holiday_month =  $holiday_details->month;
                $holiday_day = $holiday_details->day;

                if ($holiday_month == 1) {
                    $result = 'January ' . $holiday_day;
                } elseif ($holiday_month == 2) {
                    $result = 'February ' . $holiday_day;
                } elseif ($holiday_month == 3) {
                    $result = 'March ' . $holiday_day;
                } elseif ($holiday_month == 4) {
                    $result = 'April ' . $holiday_day;
                } elseif ($holiday_month == 5) {
                    $result = 'May ' . $holiday_day;
                } elseif ($holiday_month == 6) {
                    $result = 'June ' . $holiday_day;
                } elseif ($holiday_month == 7) {
                    $result = 'July ' . $holiday_day;
                } elseif ($holiday_month == 8) {
                    $result = 'August ' . $holiday_day;
                } elseif ($holiday_month == 9) {
                    $result = 'September ' . $holiday_day;
                } elseif ($holiday_month == 10) {
                    $result = 'October ' . $holiday_day;
                } elseif ($holiday_month == 11) {
                    $result = 'November ' . $holiday_day;
                } elseif ($holiday_month == 12) {
                    $result = 'December ' . $holiday_day;
                }

                return $result;
            })
            ->addColumn('action', function ($holiday_details) {

                $result = '<center><button type="button" class="btn btn-primary btn-xs text-center actionEditHoliday mr-1" type="button" holiday-id="' . $holiday_details->id . '" data-toggle="modal" data-target="#modalAddHoliday" aria-haspopup="true" aria-expanded="false" title="Edit Holiday Details">
                                    <i class="fa fa-lg fa-edit"></i> 
                                </button>';
                $result .= '<button type="button" class="btn btn-danger btn-xs text-center actionDeleteHoliday mr-1" type="button" holiday-id="' . $holiday_details->id . '" data-toggle="modal" data-target="#modalDeleteHoliday" aria-haspopup="true" aria-expanded="false" title="Delete Holiday">
                                    <i class="fas fa-lg fa-trash-alt"></i>
                                </button>';
                '</center>';

                return $result;
            })
            ->rawColumns(['holiday_status', 'holiday_date', 'action']) // to format columns as html format
            ->make(true);
    }
}
