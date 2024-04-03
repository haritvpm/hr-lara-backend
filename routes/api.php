<?php
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class,'login']);
    Route::get('me', [AuthController::class,'me']);
  //  Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
 //   Route::post('me', [AuthController::class, 'me']);

});


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    
        // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Designation Line
    Route::apiResource('designation-lines', 'DesignationLineApiController');

    // Designation
    Route::apiResource('designations', 'DesignationApiController');

    // Ot Category
    Route::apiResource('ot-categories', 'OtCategoryApiController');

    // Employee
    Route::apiResource('employees', 'EmployeeApiController');

    // Punching Trace
    Route::apiResource('punching-traces', 'PunchingTraceApiController', ['except' => ['store', 'show', 'update', 'destroy']]);

    // Session
    Route::apiResource('sessions', 'SessionApiController');

    // Govt Calendar
    Route::apiResource('govt-calendars', 'GovtCalendarApiController', ['except' => ['store', 'destroy']]);

    // Administrative Office
    Route::apiResource('administrative-offices', 'AdministrativeOfficeApiController');

    // Seat
    Route::apiResource('seats', 'SeatApiController');

    // Section
    Route::apiResource('sections', 'SectionApiController');

    // Attendance Book
    Route::apiResource('attendance-books', 'AttendanceBookApiController');



    // Success Punching
    Route::apiResource('success-punchings', 'SuccessPunchingApiController');

    // Punching Register
    Route::apiResource('punching-registers', 'PunchingRegisterApiController', ['except' => ['destroy']]);

    // Punching Device
    Route::apiResource('punching-devices', 'PunchingDeviceApiController');

    // Exemption
    Route::apiResource('exemptions', 'ExemptionApiController');

    // Seniority
    Route::apiResource('seniorities', 'SeniorityApiController');

    // Dept Designations
    Route::apiResource('dept-designations', 'DeptDesignationsApiController');

    // Dept Employees
    Route::apiResource('dept-employees', 'DeptEmployeesApiController');

    // Ot Form
    Route::apiResource('ot-forms', 'OtFormApiController');

    // Ot Form Other
    Route::apiResource('ot-form-others', 'OtFormOtherApiController');

    // Overtime
    Route::apiResource('overtimes', 'OvertimeApiController');

    // Overtime Other
    Route::apiResource('overtime-others', 'OvertimeOtherApiController');

    // Overtime Sitting
    Route::apiResource('overtime-sittings', 'OvertimeSittingApiController');

    // Ot Routing
    Route::apiResource('ot-routings', 'OtRoutingApiController');

    // Attendance Routing
    Route::apiResource('attendance-routings', 'AttendanceRoutingApiController');

    // Office Location
    Route::apiResource('office-locations', 'OfficeLocationApiController', ['except' => ['destroy']]);

    // Employee Seat History
    Route::apiResource('employee-seat-histories', 'EmployeeSeatHistoryApiController');

    // Employee Section History
    Route::apiResource('employee-section-histories', 'EmployeeSectionHistoryApiController');

    // Employee To Seat
    Route::apiResource('employee-to-seats', 'EmployeeToSeatApiController');

    // Employee To Section
    Route::apiResource('employee-to-sections', 'EmployeeToSectionApiController');

    // Employee Details
    Route::apiResource('employee-details', 'EmployeeDetailsApiController');

    // Employee Ot Data
    Route::apiResource('employee-ot-datas', 'EmployeeOtDataApiController');

    // Employee Designation History
    Route::apiResource('employee-designation-histories', 'EmployeeDesignationHistoryApiController');

    // Employee To Designation
    Route::apiResource('employee-to-designations', 'EmployeeToDesignationApiController');

    // Employee Status
    Route::apiResource('employee-statuses', 'EmployeeStatusApiController');

    // Acquittance
    Route::apiResource('acquittances', 'AcquittanceApiController');

    // Employee To Acquittance
    Route::apiResource('employee-to-acquittances', 'EmployeeToAcquittanceApiController');

    // Ddo
    Route::apiResource('ddos', 'DdoApiController');

    // Shifts
    Route::apiResource('shifts', 'ShiftsApiController');

    // Employee To Shift
    Route::apiResource('employee-to-shifts', 'EmployeeToShiftApiController');

    // Tds
    Route::apiResource('tds', 'TdsApiController');

    // Tax Entries
    Route::apiResource('tax-entries', 'TaxEntriesApiController');
});
