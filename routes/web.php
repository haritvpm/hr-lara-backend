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
    Route::resource('punching-traces', 'PunchingTraceController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Session
    Route::delete('sessions/destroy', 'SessionController@massDestroy')->name('sessions.massDestroy');
    Route::resource('sessions', 'SessionController');

    // Govt Calendar
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

    // Section Employee
    Route::delete('section-employees/destroy', 'SectionEmployeeController@massDestroy')->name('section-employees.massDestroy');
    Route::post('section-employees/parse-csv-import', 'SectionEmployeeController@parseCsvImport')->name('section-employees.parseCsvImport');
    Route::post('section-employees/process-csv-import', 'SectionEmployeeController@processCsvImport')->name('section-employees.processCsvImport');
    Route::resource('section-employees', 'SectionEmployeeController');

    // Success Punching
    Route::delete('success-punchings/destroy', 'SuccessPunchingController@massDestroy')->name('success-punchings.massDestroy');
    Route::resource('success-punchings', 'SuccessPunchingController');

    // Punching Register
    Route::resource('punching-registers', 'PunchingRegisterController', ['except' => ['destroy']]);

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

    // Employee At Seat
    Route::delete('employee-at-seats/destroy', 'EmployeeAtSeatController@massDestroy')->name('employee-at-seats.massDestroy');
    Route::resource('employee-at-seats', 'EmployeeAtSeatController');

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
    Route::resource('ot-routings', 'OtRoutingController');

    // Attendance Routing
    Route::delete('attendance-routings/destroy', 'AttendanceRoutingController@massDestroy')->name('attendance-routings.massDestroy');
    Route::resource('attendance-routings', 'AttendanceRoutingController');
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
