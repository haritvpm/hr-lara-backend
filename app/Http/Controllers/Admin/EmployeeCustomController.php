<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Services\EmployeeService;

class EmployeeCustomController extends Controller
{

    public function aebasfetch()
    {
       $list =  (new EmployeeService())->syncEmployeeDataFromAebas();

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
        ,   'Content-Disposition' => 'attachment; filename=employees_in_aebas.csv'
        ,   'Expires'             => '0'
        ,   'Pragma'              => 'public'
        ];
        return response()->stream($callback, 200, $headers);

    }

}
