<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::post('permissions/parse-csv-import', 'PermissionsController@parseCsvImport')->name('permissions.parseCsvImport');
    Route::post('permissions/process-csv-import', 'PermissionsController@processCsvImport')->name('permissions.processCsvImport');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // Designation Line
    Route::delete('designation-lines/destroy', 'DesignationLineController@massDestroy')->name('designation-lines.massDestroy');
    Route::post('designation-lines/parse-csv-import', 'DesignationLineController@parseCsvImport')->name('designation-lines.parseCsvImport');
    Route::post('designation-lines/process-csv-import', 'DesignationLineController@processCsvImport')->name('designation-lines.processCsvImport');
    Route::resource('designation-lines', 'DesignationLineController');

    // Designation
    Route::delete('designations/destroy', 'DesignationController@massDestroy')->name('designations.massDestroy');
    Route::post('designations/parse-csv-import', 'DesignationController@parseCsvImport')->name('designations.parseCsvImport');
    Route::post('designations/process-csv-import', 'DesignationController@processCsvImport')->name('designations.processCsvImport');
    Route::resource('designations', 'DesignationController');

    // Ot Category
    Route::delete('ot-categories/destroy', 'OtCategoryController@massDestroy')->name('ot-categories.massDestroy');
    Route::resource('ot-categories', 'OtCategoryController');

    // Employee
    Route::delete('employees/destroy', 'EmployeeController@massDestroy')->name('employees.massDestroy');
    Route::post('employees/parse-csv-import', 'EmployeeController@parseCsvImport')->name('employees.parseCsvImport');
    Route::post('employees/process-csv-import', 'EmployeeController@processCsvImport')->name('employees.processCsvImport');
    Route::resource('employees', 'EmployeeController');

    // Punching Trace
    Route::post('punching-traces/parse-csv-import', 'PunchingTraceController@parseCsvImport')->name('punching-traces.parseCsvImport');
    Route::post('punching-traces/process-csv-import', 'PunchingTraceController@processCsvImport')->name('punching-traces.processCsvImport');
    Route::resource('punching-traces', 'PunchingTraceController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Session
    Route::delete('sessions/destroy', 'SessionController@massDestroy')->name('sessions.massDestroy');
    Route::resource('sessions', 'SessionController');

    // Govt Calendar
    Route::post('govt-calendars/fetchmonth', 'GovtCalendarController@fetchmonth')->name('govt-calendars.fetchmonth');
    Route::resource('govt-calendars', 'GovtCalendarController', ['except' => ['create', 'store', 'destroy']]);

    // Administrative Office
    Route::delete('administrative-offices/destroy', 'AdministrativeOfficeController@massDestroy')->name('administrative-offices.massDestroy');
    Route::resource('administrative-offices', 'AdministrativeOfficeController');

    // Seat
    Route::delete('seats/destroy', 'SeatController@massDestroy')->name('seats.massDestroy');
    Route::resource('seats', 'SeatController');

    // Section
    Route::delete('sections/destroy', 'SectionController@massDestroy')->name('sections.massDestroy');
    Route::post('sections/parse-csv-import', 'SectionController@parseCsvImport')->name('sections.parseCsvImport');
    Route::post('sections/process-csv-import', 'SectionController@processCsvImport')->name('sections.processCsvImport');
    Route::resource('sections', 'SectionController');

    // Attendance Book
    Route::delete('attendance-books/destroy', 'AttendanceBookController@massDestroy')->name('attendance-books.massDestroy');
    Route::resource('attendance-books', 'AttendanceBookController');

    // Success Punching
    Route::delete('success-punchings/destroy', 'SuccessPunchingController@massDestroy')->name('success-punchings.massDestroy');
    Route::resource('success-punchings', 'SuccessPunchingController');

    // Punching Device
    Route::delete('punching-devices/destroy', 'PunchingDeviceController@massDestroy')->name('punching-devices.massDestroy');
    Route::post('punching-devices/parse-csv-import', 'PunchingDeviceController@parseCsvImport')->name('punching-devices.parseCsvImport');
    Route::post('punching-devices/process-csv-import', 'PunchingDeviceController@processCsvImport')->name('punching-devices.processCsvImport');
    Route::resource('punching-devices', 'PunchingDeviceController');

    // Exemption
    Route::delete('exemptions/destroy', 'ExemptionController@massDestroy')->name('exemptions.massDestroy');
    Route::resource('exemptions', 'ExemptionController');

    // Seniority
    Route::delete('seniorities/destroy', 'SeniorityController@massDestroy')->name('seniorities.massDestroy');
    Route::resource('seniorities', 'SeniorityController');

    // Dept Designations
    Route::delete('dept-designations/destroy', 'DeptDesignationsController@massDestroy')->name('dept-designations.massDestroy');
    Route::post('dept-designations/parse-csv-import', 'DeptDesignationsController@parseCsvImport')->name('dept-designations.parseCsvImport');
    Route::post('dept-designations/process-csv-import', 'DeptDesignationsController@processCsvImport')->name('dept-designations.processCsvImport');
    Route::resource('dept-designations', 'DeptDesignationsController');

    // Dept Employees
    Route::delete('dept-employees/destroy', 'DeptEmployeesController@massDestroy')->name('dept-employees.massDestroy');
    Route::post('dept-employees/parse-csv-import', 'DeptEmployeesController@parseCsvImport')->name('dept-employees.parseCsvImport');
    Route::post('dept-employees/process-csv-import', 'DeptEmployeesController@processCsvImport')->name('dept-employees.processCsvImport');
    Route::resource('dept-employees', 'DeptEmployeesController');

    // Ot Form
    Route::delete('ot-forms/destroy', 'OtFormController@massDestroy')->name('ot-forms.massDestroy');
    Route::resource('ot-forms', 'OtFormController');

    // Ot Form Other
    Route::delete('ot-form-others/destroy', 'OtFormOtherController@massDestroy')->name('ot-form-others.massDestroy');
    Route::resource('ot-form-others', 'OtFormOtherController');

    // Overtime
    Route::delete('overtimes/destroy', 'OvertimeController@massDestroy')->name('overtimes.massDestroy');
    Route::resource('overtimes', 'OvertimeController');

    // Overtime Other
    Route::delete('overtime-others/destroy', 'OvertimeOtherController@massDestroy')->name('overtime-others.massDestroy');
    Route::resource('overtime-others', 'OvertimeOtherController');

    // Overtime Sitting
    Route::delete('overtime-sittings/destroy', 'OvertimeSittingController@massDestroy')->name('overtime-sittings.massDestroy');
    Route::resource('overtime-sittings', 'OvertimeSittingController');

    // Ot Routing
    Route::delete('ot-routings/destroy', 'OtRoutingController@massDestroy')->name('ot-routings.massDestroy');
    Route::post('ot-routings/parse-csv-import', 'OtRoutingController@parseCsvImport')->name('ot-routings.parseCsvImport');
    Route::post('ot-routings/process-csv-import', 'OtRoutingController@processCsvImport')->name('ot-routings.processCsvImport');
    Route::resource('ot-routings', 'OtRoutingController');

    // Attendance Routing
    Route::delete('attendance-routings/destroy', 'AttendanceRoutingController@massDestroy')->name('attendance-routings.massDestroy');
    Route::resource('attendance-routings', 'AttendanceRoutingController');

    // Office Location
    Route::post('office-locations/parse-csv-import', 'OfficeLocationController@parseCsvImport')->name('office-locations.parseCsvImport');
    Route::post('office-locations/process-csv-import', 'OfficeLocationController@processCsvImport')->name('office-locations.processCsvImport');
    Route::resource('office-locations', 'OfficeLocationController', ['except' => ['destroy']]);

    // Employee Seat History
    Route::delete('employee-seat-histories/destroy', 'EmployeeSeatHistoryController@massDestroy')->name('employee-seat-histories.massDestroy');
    Route::resource('employee-seat-histories', 'EmployeeSeatHistoryController');

    // Employee Section History
    Route::delete('employee-section-histories/destroy', 'EmployeeSectionHistoryController@massDestroy')->name('employee-section-histories.massDestroy');
    Route::post('employee-section-histories/parse-csv-import', 'EmployeeSectionHistoryController@parseCsvImport')->name('employee-section-histories.parseCsvImport');
    Route::post('employee-section-histories/process-csv-import', 'EmployeeSectionHistoryController@processCsvImport')->name('employee-section-histories.processCsvImport');
    Route::resource('employee-section-histories', 'EmployeeSectionHistoryController');

    // Employee To Seat
    Route::delete('employee-to-seats/destroy', 'EmployeeToSeatController@massDestroy')->name('employee-to-seats.massDestroy');
    Route::post('employee-to-seats/parse-csv-import', 'EmployeeToSeatController@parseCsvImport')->name('employee-to-seats.parseCsvImport');
    Route::post('employee-to-seats/process-csv-import', 'EmployeeToSeatController@processCsvImport')->name('employee-to-seats.processCsvImport');
    Route::resource('employee-to-seats', 'EmployeeToSeatController');

    // Employee To Section
    Route::delete('employee-to-sections/destroy', 'EmployeeToSectionController@massDestroy')->name('employee-to-sections.massDestroy');
    Route::post('employee-to-sections/parse-csv-import', 'EmployeeToSectionController@parseCsvImport')->name('employee-to-sections.parseCsvImport');
    Route::post('employee-to-sections/process-csv-import', 'EmployeeToSectionController@processCsvImport')->name('employee-to-sections.processCsvImport');
    Route::resource('employee-to-sections', 'EmployeeToSectionController');

    // Employee Details
    Route::delete('employee-details/destroy', 'EmployeeDetailsController@massDestroy')->name('employee-details.massDestroy');
    Route::post('employee-details/parse-csv-import', 'EmployeeDetailsController@parseCsvImport')->name('employee-details.parseCsvImport');
    Route::post('employee-details/process-csv-import', 'EmployeeDetailsController@processCsvImport')->name('employee-details.processCsvImport');
    Route::resource('employee-details', 'EmployeeDetailsController');

    // Employee Ot Data
    Route::delete('employee-ot-datas/destroy', 'EmployeeOtDataController@massDestroy')->name('employee-ot-datas.massDestroy');
    Route::post('employee-ot-datas/parse-csv-import', 'EmployeeOtDataController@parseCsvImport')->name('employee-ot-datas.parseCsvImport');
    Route::post('employee-ot-datas/process-csv-import', 'EmployeeOtDataController@processCsvImport')->name('employee-ot-datas.processCsvImport');
    Route::resource('employee-ot-datas', 'EmployeeOtDataController');

    // Employee Designation History
    Route::delete('employee-designation-histories/destroy', 'EmployeeDesignationHistoryController@massDestroy')->name('employee-designation-histories.massDestroy');
    Route::resource('employee-designation-histories', 'EmployeeDesignationHistoryController');

    // Employee To Designation
    Route::delete('employee-to-designations/destroy', 'EmployeeToDesignationController@massDestroy')->name('employee-to-designations.massDestroy');
    Route::post('employee-to-designations/parse-csv-import', 'EmployeeToDesignationController@parseCsvImport')->name('employee-to-designations.parseCsvImport');
    Route::post('employee-to-designations/process-csv-import', 'EmployeeToDesignationController@processCsvImport')->name('employee-to-designations.processCsvImport');
    Route::resource('employee-to-designations', 'EmployeeToDesignationController');

    // Acquittance
    Route::delete('acquittances/destroy', 'AcquittanceController@massDestroy')->name('acquittances.massDestroy');
    Route::post('acquittances/parse-csv-import', 'AcquittanceController@parseCsvImport')->name('acquittances.parseCsvImport');
    Route::post('acquittances/process-csv-import', 'AcquittanceController@processCsvImport')->name('acquittances.processCsvImport');
    Route::resource('acquittances', 'AcquittanceController');

    // Employee To Acquittance
    Route::delete('employee-to-acquittances/destroy', 'EmployeeToAcquittanceController@massDestroy')->name('employee-to-acquittances.massDestroy');
    Route::post('employee-to-acquittances/parse-csv-import', 'EmployeeToAcquittanceController@parseCsvImport')->name('employee-to-acquittances.parseCsvImport');
    Route::post('employee-to-acquittances/process-csv-import', 'EmployeeToAcquittanceController@processCsvImport')->name('employee-to-acquittances.processCsvImport');
    Route::resource('employee-to-acquittances', 'EmployeeToAcquittanceController');

    // Ddo
    Route::delete('ddos/destroy', 'DdoController@massDestroy')->name('ddos.massDestroy');
    Route::resource('ddos', 'DdoController');

    // Shifts
    Route::delete('shifts/destroy', 'ShiftsController@massDestroy')->name('shifts.massDestroy');
    Route::resource('shifts', 'ShiftsController');

    // Employee To Shift
    Route::delete('employee-to-shifts/destroy', 'EmployeeToShiftController@massDestroy')->name('employee-to-shifts.massDestroy');
    Route::resource('employee-to-shifts', 'EmployeeToShiftController');

    // Tds
    Route::delete('tds/destroy', 'TdsController@massDestroy')->name('tds.massDestroy');
    Route::resource('tds', 'TdsController');

    // Tax Entries
    Route::delete('tax-entries/destroy', 'TaxEntriesController@massDestroy')->name('tax-entries.massDestroy');
    Route::resource('tax-entries', 'TaxEntriesController');

    // Punching
    Route::resource('punchings', 'PunchingController', ['except' => ['destroy']]);
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
