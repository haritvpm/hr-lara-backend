<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLeafRequest;
use App\Http\Requests\StoreLeafRequest;
use App\Http\Requests\UpdateLeafRequest;
use App\Models\Employee;
use App\Models\Leaf;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\AebasFetchService;
use App\Services\LeaveFetchService;
use App\Jobs\ProcessLeavesJob; // Import the missing class

class LeaveControllerCustom extends Controller
{
    public function aebasdownload()
    {

    $list =  (new AebasFetchService())->fetchApi(9, offset: 0);

       $callback = function() use ($list)
        {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
        ,   'Content-type'        => 'text/csv'
        ,   'Content-Disposition' => 'attachment; filename=leave_all.csv'
        ,   'Expires'             => '0'
        ,   'Pragma'              => 'public'
        ];
        return response()->stream($callback, 200, $headers);
    }


    public function aebasfetch()
    {


        \Log::info("fetch all leaving!. " );
        $insertedcount = (new LeaveFetchService())->fetchLeave();

        \Session::flash('message', 'Fetched Leaves ' . $insertedcount );
        return redirect()->back();

    }
    public function calc()
    {
       // (new \App\Services\LeaveFetchService())->processLeaves();
        ProcessLeavesJob::dispatch();
        \Session::flash('message', 'Processing Leaves in the background. check after 2 minutes');
        return redirect()->back();

    }
}
