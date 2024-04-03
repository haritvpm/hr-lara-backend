<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/seats*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/permissions*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('seat_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.seats.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/seats") || request()->is("admin/seats/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-chess-king c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.seat.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('punching_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/punching-traces*") ? "c-show" : "" }} {{ request()->is("admin/success-punchings*") ? "c-show" : "" }} {{ request()->is("admin/punching-devices*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-address-card c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.punchingManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('punching_trace_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.punching-traces.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/punching-traces") || request()->is("admin/punching-traces/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-check c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.punchingTrace.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('success_punching_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.success-punchings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/success-punchings") || request()->is("admin/success-punchings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-check-double c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.successPunching.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('punching_device_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.punching-devices.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/punching-devices") || request()->is("admin/punching-devices/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-laptop c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.punchingDevice.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('attendance_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/govt-calendars*") ? "c-show" : "" }} {{ request()->is("admin/punching-registers*") ? "c-show" : "" }} {{ request()->is("admin/attendance-books*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw far fa-calendar-check c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.attendance.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('govt_calendar_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.govt-calendars.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/govt-calendars") || request()->is("admin/govt-calendars/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-calendar-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.govtCalendar.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('punching_register_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.punching-registers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/punching-registers") || request()->is("admin/punching-registers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.punchingRegister.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('attendance_book_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.attendance-books.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/attendance-books") || request()->is("admin/attendance-books/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-fingerprint c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.attendanceBook.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('employee_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/employees*") ? "c-show" : "" }} {{ request()->is("admin/employee-to-designations*") ? "c-show" : "" }} {{ request()->is("admin/employee-to-sections*") ? "c-show" : "" }} {{ request()->is("admin/employee-to-seats*") ? "c-show" : "" }} {{ request()->is("admin/designations*") ? "c-show" : "" }} {{ request()->is("admin/seniorities*") ? "c-show" : "" }} {{ request()->is("admin/designation-lines*") ? "c-show" : "" }} {{ request()->is("admin/employee-seat-histories*") ? "c-show" : "" }} {{ request()->is("admin/employee-section-histories*") ? "c-show" : "" }} {{ request()->is("admin/employee-designation-histories*") ? "c-show" : "" }} {{ request()->is("admin/employee-details*") ? "c-show" : "" }} {{ request()->is("admin/employee-statuses*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.employeeManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('employee_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employees.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employees") || request()->is("admin/employees/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employee.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_to_designation_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-to-designations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-to-designations") || request()->is("admin/employee-to-designations/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-address-book c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeToDesignation.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_to_section_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-to-sections.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-to-sections") || request()->is("admin/employee-to-sections/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-plus c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeToSection.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_to_seat_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-to-seats.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-to-seats") || request()->is("admin/employee-to-seats/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-chess-king c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeToSeat.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('designation_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.designations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/designations") || request()->is("admin/designations/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-id-card c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.designation.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('seniority_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.seniorities.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/seniorities") || request()->is("admin/seniorities/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-up c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.seniority.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('designation_line_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.designation-lines.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/designation-lines") || request()->is("admin/designation-lines/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.designationLine.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_seat_history_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-seat-histories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-seat-histories") || request()->is("admin/employee-seat-histories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-monument c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeSeatHistory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_section_history_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-section-histories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-section-histories") || request()->is("admin/employee-section-histories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-monument c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeSectionHistory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_designation_history_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-designation-histories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-designation-histories") || request()->is("admin/employee-designation-histories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-monument c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeDesignationHistory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_detail_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-details.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-details") || request()->is("admin/employee-details/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeDetail.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_status_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-statuses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-statuses") || request()->is("admin/employee-statuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-battery-three-quarters c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeStatus.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('assembly_related_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/exemptions*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-archway c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.assemblyRelated.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('exemption_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.exemptions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/exemptions") || request()->is("admin/exemptions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-minus c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.exemption.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('office_related_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/sections*") ? "c-show" : "" }} {{ request()->is("admin/administrative-offices*") ? "c-show" : "" }} {{ request()->is("admin/attendance-routings*") ? "c-show" : "" }} {{ request()->is("admin/office-locations*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw far fa-building c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.officeRelated.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('section_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sections.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sections") || request()->is("admin/sections/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-puzzle-piece c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.section.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('administrative_office_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.administrative-offices.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/administrative-offices") || request()->is("admin/administrative-offices/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-globe-asia c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.administrativeOffice.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('attendance_routing_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.attendance-routings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/attendance-routings") || request()->is("admin/attendance-routings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-hand-point-right c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.attendanceRouting.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('office_location_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.office-locations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/office-locations") || request()->is("admin/office-locations/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-map-marker-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.officeLocation.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('overtime_related_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/employee-ot-datas*") ? "c-show" : "" }} {{ request()->is("admin/sessions*") ? "c-show" : "" }} {{ request()->is("admin/ot-categories*") ? "c-show" : "" }} {{ request()->is("admin/dept-employees*") ? "c-show" : "" }} {{ request()->is("admin/dept-designations*") ? "c-show" : "" }} {{ request()->is("admin/ot-forms*") ? "c-show" : "" }} {{ request()->is("admin/ot-form-others*") ? "c-show" : "" }} {{ request()->is("admin/overtimes*") ? "c-show" : "" }} {{ request()->is("admin/overtime-others*") ? "c-show" : "" }} {{ request()->is("admin/overtime-sittings*") ? "c-show" : "" }} {{ request()->is("admin/ot-routings*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-money-bill-wave c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.overtimeRelated.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('employee_ot_data_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-ot-datas.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-ot-datas") || request()->is("admin/employee-ot-datas/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-circle c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeOtData.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('session_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sessions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sessions") || request()->is("admin/sessions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-asterisk c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.session.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('ot_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.ot-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/ot-categories") || request()->is("admin/ot-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.otCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('dept_employee_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.dept-employees.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/dept-employees") || request()->is("admin/dept-employees/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.deptEmployee.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('dept_designation_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.dept-designations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/dept-designations") || request()->is("admin/dept-designations/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.deptDesignation.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('ot_form_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.ot-forms.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/ot-forms") || request()->is("admin/ot-forms/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.otForm.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('ot_form_other_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.ot-form-others.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/ot-form-others") || request()->is("admin/ot-form-others/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.otFormOther.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('overtime_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.overtimes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/overtimes") || request()->is("admin/overtimes/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.overtime.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('overtime_other_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.overtime-others.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/overtime-others") || request()->is("admin/overtime-others/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.overtimeOther.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('overtime_sitting_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.overtime-sittings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/overtime-sittings") || request()->is("admin/overtime-sittings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.overtimeSitting.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('ot_routing_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.ot-routings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/ot-routings") || request()->is("admin/ot-routings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-hand-point-right c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.otRouting.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('account_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/ddos*") ? "c-show" : "" }} {{ request()->is("admin/acquittances*") ? "c-show" : "" }} {{ request()->is("admin/employee-to-acquittances*") ? "c-show" : "" }} {{ request()->is("admin/tax-entries*") ? "c-show" : "" }} {{ request()->is("admin/tds*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-dollar-sign c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.account.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('ddo_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.ddos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/ddos") || request()->is("admin/ddos/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.ddo.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('acquittance_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.acquittances.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/acquittances") || request()->is("admin/acquittances/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-align-center c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.acquittance.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_to_acquittance_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-to-acquittances.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-to-acquittances") || request()->is("admin/employee-to-acquittances/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeToAcquittance.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('tax_entry_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.tax-entries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tax-entries") || request()->is("admin/tax-entries/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.taxEntry.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('td_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.tds.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tds") || request()->is("admin/tds/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.td.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('shift_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/shifts*") ? "c-show" : "" }} {{ request()->is("admin/employee-to-shifts*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw far fa-clock c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.shiftManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('shift_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.shifts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/shifts") || request()->is("admin/shifts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.shift.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_to_shift_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-to-shifts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-to-shifts") || request()->is("admin/employee-to-shifts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeToShift.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>