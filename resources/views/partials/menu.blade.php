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
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/seats*") ? "c-show" : "" }} {{ request()->is("admin/employee-at-seats*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
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
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.seat.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_at_seat_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-at-seats.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-at-seats") || request()->is("admin/employee-at-seats/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeAtSeat.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('punching_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/punching-traces*") ? "c-show" : "" }} {{ request()->is("admin/punching-devices*") ? "c-show" : "" }} {{ request()->is("admin/success-punchings*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-address-card c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.punchingManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('punching_trace_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.punching-traces.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/punching-traces") || request()->is("admin/punching-traces/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.punchingTrace.title') }}
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
                    @can('success_punching_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.success-punchings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/success-punchings") || request()->is("admin/success-punchings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.successPunching.title') }}
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
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.attendanceBook.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('employee_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/designations*") ? "c-show" : "" }} {{ request()->is("admin/employees*") ? "c-show" : "" }} {{ request()->is("admin/section-employees*") ? "c-show" : "" }} {{ request()->is("admin/seniorities*") ? "c-show" : "" }} {{ request()->is("admin/designation-lines*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.employeeManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('designation_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.designations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/designations") || request()->is("admin/designations/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.designation.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employees.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employees") || request()->is("admin/employees/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employee.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('section_employee_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.section-employees.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/section-employees") || request()->is("admin/section-employees/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-plus c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.sectionEmployee.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('seniority_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.seniorities.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/seniorities") || request()->is("admin/seniorities/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

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
                </ul>
            </li>
        @endcan
        @can('assembly_related_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/exemptions*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.assemblyRelated.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('exemption_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.exemptions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/exemptions") || request()->is("admin/exemptions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.exemption.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('office_related_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/sections*") ? "c-show" : "" }} {{ request()->is("admin/administrative-offices*") ? "c-show" : "" }} {{ request()->is("admin/attendance-routings*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

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
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.administrativeOffice.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('attendance_routing_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.attendance-routings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/attendance-routings") || request()->is("admin/attendance-routings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.attendanceRouting.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('overtime_related_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/sessions*") ? "c-show" : "" }} {{ request()->is("admin/ot-categories*") ? "c-show" : "" }} {{ request()->is("admin/dept-employees*") ? "c-show" : "" }} {{ request()->is("admin/dept-designations*") ? "c-show" : "" }} {{ request()->is("admin/ot-forms*") ? "c-show" : "" }} {{ request()->is("admin/ot-form-others*") ? "c-show" : "" }} {{ request()->is("admin/overtimes*") ? "c-show" : "" }} {{ request()->is("admin/overtime-others*") ? "c-show" : "" }} {{ request()->is("admin/overtime-sittings*") ? "c-show" : "" }} {{ request()->is("admin/ot-routings*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.overtimeRelated.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('session_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sessions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sessions") || request()->is("admin/sessions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

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
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.otRouting.title') }}
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