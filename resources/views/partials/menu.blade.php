<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/seats*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/permissions*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/users*") ? "active" : "" }} {{ request()->is("admin/seats*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/permissions*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('seat_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.seats.index") }}" class="nav-link {{ request()->is("admin/seats") || request()->is("admin/seats/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-chess-king">

                                        </i>
                                        <p>
                                            {{ trans('cruds.seat.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('punching_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/govt-calendars*") ? "menu-open" : "" }} {{ request()->is("admin/attendance-routings*") ? "menu-open" : "" }} {{ request()->is("admin/settings*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/govt-calendars*") ? "active" : "" }} {{ request()->is("admin/attendance-routings*") ? "active" : "" }} {{ request()->is("admin/settings*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-address-card">

                            </i>
                            <p>
                                {{ trans('cruds.punchingManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('govt_calendar_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.govt-calendars.index") }}" class="nav-link {{ request()->is("admin/govt-calendars") || request()->is("admin/govt-calendars/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-calendar-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.govtCalendar.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('attendance_routing_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.attendance-routings.index") }}" class="nav-link {{ request()->is("admin/attendance-routings") || request()->is("admin/attendance-routings/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-hand-point-right">

                                        </i>
                                        <p>
                                            {{ trans('cruds.attendanceRouting.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('govt_calendar_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.settings.index") }}" class="nav-link {{ request()->is("admin/settings") || request()->is("admin/settings/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.setting.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('employee_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/employees*") ? "menu-open" : "" }} {{ request()->is("admin/employee-to-seats*") ? "menu-open" : "" }} {{ request()->is("admin/employee-to-sections*") ? "menu-open" : "" }} {{ request()->is("admin/employee-to-designations*") ? "menu-open" : "" }} {{ request()->is("admin/designations*") ? "menu-open" : "" }} {{ request()->is("admin/seniorities*") ? "menu-open" : "" }} {{ request()->is("admin/employee-extras*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/employees*") ? "active" : "" }} {{ request()->is("admin/employee-to-seats*") ? "active" : "" }} {{ request()->is("admin/employee-to-sections*") ? "active" : "" }} {{ request()->is("admin/employee-to-designations*") ? "active" : "" }} {{ request()->is("admin/designations*") ? "active" : "" }} {{ request()->is("admin/seniorities*") ? "active" : "" }} {{ request()->is("admin/employee-extras*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.employeeManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('employee_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.employees.index") }}" class="nav-link {{ request()->is("admin/employees") || request()->is("admin/employees/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.employee.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('employee_to_seat_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.employee-to-seats.index") }}" class="nav-link {{ request()->is("admin/employee-to-seats") || request()->is("admin/employee-to-seats/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-chess-king">

                                        </i>
                                        <p>
                                            {{ trans('cruds.employeeToSeat.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('employee_to_section_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.employee-to-sections.index") }}" class="nav-link {{ request()->is("admin/employee-to-sections") || request()->is("admin/employee-to-sections/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user-plus">

                                        </i>
                                        <p>
                                            {{ trans('cruds.employeeToSection.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('employee_to_designation_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.employee-to-designations.index") }}" class="nav-link {{ request()->is("admin/employee-to-designations") || request()->is("admin/employee-to-designations/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-address-book">

                                        </i>
                                        <p>
                                            {{ trans('cruds.employeeToDesignation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('designation_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.designations.index") }}" class="nav-link {{ request()->is("admin/designations") || request()->is("admin/designations/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-id-card">

                                        </i>
                                        <p>
                                            {{ trans('cruds.designation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('seniority_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.seniorities.index") }}" class="nav-link {{ request()->is("admin/seniorities") || request()->is("admin/seniorities/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-angle-double-up">

                                        </i>
                                        <p>
                                            {{ trans('cruds.seniority.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('employee_extra_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.employee-extras.index") }}" class="nav-link {{ request()->is("admin/employee-extras") || request()->is("admin/employee-extras/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.employeeExtra.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('assembly_related_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/exemptions*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/exemptions*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-archway">

                            </i>
                            <p>
                                {{ trans('cruds.assemblyRelated.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('exemption_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.exemptions.index") }}" class="nav-link {{ request()->is("admin/exemptions") || request()->is("admin/exemptions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user-minus">

                                        </i>
                                        <p>
                                            {{ trans('cruds.exemption.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('office_related_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/attendance-books*") ? "menu-open" : "" }} {{ request()->is("admin/sections*") ? "menu-open" : "" }} {{ request()->is("admin/administrative-offices*") ? "menu-open" : "" }} {{ request()->is("admin/office-locations*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/attendance-books*") ? "active" : "" }} {{ request()->is("admin/sections*") ? "active" : "" }} {{ request()->is("admin/administrative-offices*") ? "active" : "" }} {{ request()->is("admin/office-locations*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon far fa-building">

                            </i>
                            <p>
                                {{ trans('cruds.officeRelated.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('attendance_book_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.attendance-books.index") }}" class="nav-link {{ request()->is("admin/attendance-books") || request()->is("admin/attendance-books/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-fingerprint">

                                        </i>
                                        <p>
                                            {{ trans('cruds.attendanceBook.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('section_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.sections.index") }}" class="nav-link {{ request()->is("admin/sections") || request()->is("admin/sections/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-puzzle-piece">

                                        </i>
                                        <p>
                                            {{ trans('cruds.section.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('administrative_office_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.administrative-offices.index") }}" class="nav-link {{ request()->is("admin/administrative-offices") || request()->is("admin/administrative-offices/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-globe-asia">

                                        </i>
                                        <p>
                                            {{ trans('cruds.administrativeOffice.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('office_location_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.office-locations.index") }}" class="nav-link {{ request()->is("admin/office-locations") || request()->is("admin/office-locations/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-map-marker-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.officeLocation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('overtime_related_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/ot-categories*") ? "menu-open" : "" }} {{ request()->is("admin/dept-employees*") ? "menu-open" : "" }} {{ request()->is("admin/dept-designations*") ? "menu-open" : "" }} {{ request()->is("admin/ot-forms*") ? "menu-open" : "" }} {{ request()->is("admin/ot-form-others*") ? "menu-open" : "" }} {{ request()->is("admin/overtimes*") ? "menu-open" : "" }} {{ request()->is("admin/overtime-others*") ? "menu-open" : "" }} {{ request()->is("admin/overtime-sittings*") ? "menu-open" : "" }} {{ request()->is("admin/ot-routings*") ? "menu-open" : "" }} {{ request()->is("admin/assembly-sessions*") ? "menu-open" : "" }} {{ request()->is("admin/employee-ot-settings*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/ot-categories*") ? "active" : "" }} {{ request()->is("admin/dept-employees*") ? "active" : "" }} {{ request()->is("admin/dept-designations*") ? "active" : "" }} {{ request()->is("admin/ot-forms*") ? "active" : "" }} {{ request()->is("admin/ot-form-others*") ? "active" : "" }} {{ request()->is("admin/overtimes*") ? "active" : "" }} {{ request()->is("admin/overtime-others*") ? "active" : "" }} {{ request()->is("admin/overtime-sittings*") ? "active" : "" }} {{ request()->is("admin/ot-routings*") ? "active" : "" }} {{ request()->is("admin/assembly-sessions*") ? "active" : "" }} {{ request()->is("admin/employee-ot-settings*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-money-bill-wave">

                            </i>
                            <p>
                                {{ trans('cruds.overtimeRelated.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('ot_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.ot-categories.index") }}" class="nav-link {{ request()->is("admin/ot-categories") || request()->is("admin/ot-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.otCategory.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('dept_employee_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.dept-employees.index") }}" class="nav-link {{ request()->is("admin/dept-employees") || request()->is("admin/dept-employees/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.deptEmployee.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('dept_designation_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.dept-designations.index") }}" class="nav-link {{ request()->is("admin/dept-designations") || request()->is("admin/dept-designations/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.deptDesignation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ot_form_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.ot-forms.index") }}" class="nav-link {{ request()->is("admin/ot-forms") || request()->is("admin/ot-forms/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.otForm.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ot_form_other_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.ot-form-others.index") }}" class="nav-link {{ request()->is("admin/ot-form-others") || request()->is("admin/ot-form-others/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.otFormOther.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('overtime_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.overtimes.index") }}" class="nav-link {{ request()->is("admin/overtimes") || request()->is("admin/overtimes/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.overtime.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('overtime_other_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.overtime-others.index") }}" class="nav-link {{ request()->is("admin/overtime-others") || request()->is("admin/overtime-others/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.overtimeOther.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('overtime_sitting_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.overtime-sittings.index") }}" class="nav-link {{ request()->is("admin/overtime-sittings") || request()->is("admin/overtime-sittings/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.overtimeSitting.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ot_routing_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.ot-routings.index") }}" class="nav-link {{ request()->is("admin/ot-routings") || request()->is("admin/ot-routings/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-hand-point-right">

                                        </i>
                                        <p>
                                            {{ trans('cruds.otRouting.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('assembly_session_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.assembly-sessions.index") }}" class="nav-link {{ request()->is("admin/assembly-sessions") || request()->is("admin/assembly-sessions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-asterisk">

                                        </i>
                                        <p>
                                            {{ trans('cruds.assemblySession.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('employee_ot_setting_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.employee-ot-settings.index") }}" class="nav-link {{ request()->is("admin/employee-ot-settings") || request()->is("admin/employee-ot-settings/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user-circle">

                                        </i>
                                        <p>
                                            {{ trans('cruds.employeeOtSetting.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('account_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/ddos*") ? "menu-open" : "" }} {{ request()->is("admin/acquittances*") ? "menu-open" : "" }} {{ request()->is("admin/employee-to-acquittances*") ? "menu-open" : "" }} {{ request()->is("admin/tax-entries*") ? "menu-open" : "" }} {{ request()->is("admin/tds*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/ddos*") ? "active" : "" }} {{ request()->is("admin/acquittances*") ? "active" : "" }} {{ request()->is("admin/employee-to-acquittances*") ? "active" : "" }} {{ request()->is("admin/tax-entries*") ? "active" : "" }} {{ request()->is("admin/tds*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-dollar-sign">

                            </i>
                            <p>
                                {{ trans('cruds.account.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('ddo_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.ddos.index") }}" class="nav-link {{ request()->is("admin/ddos") || request()->is("admin/ddos/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ddo.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('acquittance_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.acquittances.index") }}" class="nav-link {{ request()->is("admin/acquittances") || request()->is("admin/acquittances/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-align-center">

                                        </i>
                                        <p>
                                            {{ trans('cruds.acquittance.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('employee_to_acquittance_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.employee-to-acquittances.index") }}" class="nav-link {{ request()->is("admin/employee-to-acquittances") || request()->is("admin/employee-to-acquittances/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.employeeToAcquittance.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('tax_entry_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.tax-entries.index") }}" class="nav-link {{ request()->is("admin/tax-entries") || request()->is("admin/tax-entries/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.taxEntry.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('td_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.tds.index") }}" class="nav-link {{ request()->is("admin/tds") || request()->is("admin/tds/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.td.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('time_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/office-times*") ? "menu-open" : "" }} {{ request()->is("admin/shifts*") ? "menu-open" : "" }} {{ request()->is("admin/employee-to-shifts*") ? "menu-open" : "" }} {{ request()->is("admin/grace-times*") ? "menu-open" : "" }} {{ request()->is("admin/employee-to-flexis*") ? "menu-open" : "" }} {{ request()->is("admin/leave-groups*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/office-times*") ? "active" : "" }} {{ request()->is("admin/shifts*") ? "active" : "" }} {{ request()->is("admin/employee-to-shifts*") ? "active" : "" }} {{ request()->is("admin/grace-times*") ? "active" : "" }} {{ request()->is("admin/employee-to-flexis*") ? "active" : "" }} {{ request()->is("admin/leave-groups*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon far fa-clock">

                            </i>
                            <p>
                                {{ trans('cruds.timeManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('office_time_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.office-times.index") }}" class="nav-link {{ request()->is("admin/office-times") || request()->is("admin/office-times/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.officeTime.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('shift_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.shifts.index") }}" class="nav-link {{ request()->is("admin/shifts") || request()->is("admin/shifts/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.shift.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('employee_to_shift_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.employee-to-shifts.index") }}" class="nav-link {{ request()->is("admin/employee-to-shifts") || request()->is("admin/employee-to-shifts/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.employeeToShift.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('time_management_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.grace-times.index") }}" class="nav-link {{ request()->is("admin/grace-times") || request()->is("admin/grace-times/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.graceTime.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('time_management_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.employee-to-flexis.index") }}" class="nav-link {{ request()->is("admin/employee-to-flexis") || request()->is("admin/employee-to-flexis/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.employeeToFlexi.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('time_management_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.leave-groups.index") }}" class="nav-link {{ request()->is("admin/leave-groups") || request()->is("admin/leave-groups/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.leaveGroup.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/punching-traces*") ? "menu-open" : "" }} {{ request()->is("admin/success-punchings*") ? "menu-open" : "" }} {{ request()->is("admin/punching-devices*") ? "menu-open" : "" }} {{ request()->is("admin/punchings*") ? "menu-open" : "" }} {{ request()->is("admin/monthly-attendances*") ? "menu-open" : "" }} {{ request()->is("admin/leaves*") ? "menu-open" : "" }} {{ request()->is("admin/yearly-attendances*") ? "menu-open" : "" }} {{ request()->is("admin/compen-granteds*") ? "menu-open" : "" }} {{ request()->is("admin/flexi-applications*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/punching-traces*") ? "active" : "" }} {{ request()->is("admin/success-punchings*") ? "active" : "" }} {{ request()->is("admin/punching-devices*") ? "active" : "" }} {{ request()->is("admin/punchings*") ? "active" : "" }} {{ request()->is("admin/monthly-attendances*") ? "active" : "" }} {{ request()->is("admin/leaves*") ? "active" : "" }} {{ request()->is("admin/yearly-attendances*") ? "active" : "" }} {{ request()->is("admin/compen-granteds*") ? "active" : "" }} {{ request()->is("admin/flexi-applications*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-database">

                            </i>
                            <p>
                                {{ trans('cruds.database.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('punching_trace_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.punching-traces.index") }}" class="nav-link {{ request()->is("admin/punching-traces") || request()->is("admin/punching-traces/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-check">

                                        </i>
                                        <p>
                                            {{ trans('cruds.punchingTrace.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('success_punching_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.success-punchings.index") }}" class="nav-link {{ request()->is("admin/success-punchings") || request()->is("admin/success-punchings/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-check-double">

                                        </i>
                                        <p>
                                            {{ trans('cruds.successPunching.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('punching_device_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.punching-devices.index") }}" class="nav-link {{ request()->is("admin/punching-devices") || request()->is("admin/punching-devices/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-laptop">

                                        </i>
                                        <p>
                                            {{ trans('cruds.punchingDevice.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('punching_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.punchings.index") }}" class="nav-link {{ request()->is("admin/punchings") || request()->is("admin/punchings/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-fingerprint">

                                        </i>
                                        <p>
                                            {{ trans('cruds.punching.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('monthly_attendance_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.monthly-attendances.index") }}" class="nav-link {{ request()->is("admin/monthly-attendances") || request()->is("admin/monthly-attendances/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-moon">

                                        </i>
                                        <p>
                                            {{ trans('cruds.monthlyAttendance.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('leaf_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.leaves.index") }}" class="nav-link {{ request()->is("admin/leaves") || request()->is("admin/leaves/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-hospital-symbol">

                                        </i>
                                        <p>
                                            {{ trans('cruds.leaf.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('yearly_attendance_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.yearly-attendances.index") }}" class="nav-link {{ request()->is("admin/yearly-attendances") || request()->is("admin/yearly-attendances/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-calendar-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.yearlyAttendance.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('leaf_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.compen-granteds.index") }}" class="nav-link {{ request()->is("admin/compen-granteds") || request()->is("admin/compen-granteds/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.compenGranted.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('leaf_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.flexi-applications.index") }}" class="nav-link {{ request()->is("admin/flexi-applications") || request()->is("admin/flexi-applications/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.flexiApplication.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route("admin.systemCalendar") }}" class="nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "active" : "" }}">
                        <i class="fas fa-fw fa-calendar nav-icon">

                        </i>
                        <p>
                            {{ trans('global.systemCalendar') }}
                        </p>
                    </a>
                </li>
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
