<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'employee_management_access',
            ],
            [
                'id'    => 18,
                'title' => 'designation_line_create',
            ],
            [
                'id'    => 19,
                'title' => 'designation_line_edit',
            ],
            [
                'id'    => 20,
                'title' => 'designation_line_show',
            ],
            [
                'id'    => 21,
                'title' => 'designation_line_delete',
            ],
            [
                'id'    => 22,
                'title' => 'designation_line_access',
            ],
            [
                'id'    => 23,
                'title' => 'designation_create',
            ],
            [
                'id'    => 24,
                'title' => 'designation_edit',
            ],
            [
                'id'    => 25,
                'title' => 'designation_show',
            ],
            [
                'id'    => 26,
                'title' => 'designation_delete',
            ],
            [
                'id'    => 27,
                'title' => 'designation_access',
            ],
            [
                'id'    => 28,
                'title' => 'overtime_related_access',
            ],
            [
                'id'    => 29,
                'title' => 'ot_category_create',
            ],
            [
                'id'    => 30,
                'title' => 'ot_category_edit',
            ],
            [
                'id'    => 31,
                'title' => 'ot_category_show',
            ],
            [
                'id'    => 32,
                'title' => 'ot_category_delete',
            ],
            [
                'id'    => 33,
                'title' => 'ot_category_access',
            ],
            [
                'id'    => 34,
                'title' => 'employee_create',
            ],
            [
                'id'    => 35,
                'title' => 'employee_edit',
            ],
            [
                'id'    => 36,
                'title' => 'employee_show',
            ],
            [
                'id'    => 37,
                'title' => 'employee_delete',
            ],
            [
                'id'    => 38,
                'title' => 'employee_access',
            ],
            [
                'id'    => 39,
                'title' => 'punching_management_access',
            ],
            [
                'id'    => 40,
                'title' => 'punching_trace_access',
            ],
            [
                'id'    => 41,
                'title' => 'attendance_access',
            ],
            [
                'id'    => 42,
                'title' => 'session_create',
            ],
            [
                'id'    => 43,
                'title' => 'session_edit',
            ],
            [
                'id'    => 44,
                'title' => 'session_show',
            ],
            [
                'id'    => 45,
                'title' => 'session_delete',
            ],
            [
                'id'    => 46,
                'title' => 'session_access',
            ],
            [
                'id'    => 47,
                'title' => 'govt_calendar_edit',
            ],
            [
                'id'    => 48,
                'title' => 'govt_calendar_show',
            ],
            [
                'id'    => 49,
                'title' => 'govt_calendar_access',
            ],
            [
                'id'    => 50,
                'title' => 'office_related_access',
            ],
            [
                'id'    => 51,
                'title' => 'administrative_office_create',
            ],
            [
                'id'    => 52,
                'title' => 'administrative_office_edit',
            ],
            [
                'id'    => 53,
                'title' => 'administrative_office_show',
            ],
            [
                'id'    => 54,
                'title' => 'administrative_office_delete',
            ],
            [
                'id'    => 55,
                'title' => 'administrative_office_access',
            ],
            [
                'id'    => 56,
                'title' => 'seat_create',
            ],
            [
                'id'    => 57,
                'title' => 'seat_edit',
            ],
            [
                'id'    => 58,
                'title' => 'seat_show',
            ],
            [
                'id'    => 59,
                'title' => 'seat_delete',
            ],
            [
                'id'    => 60,
                'title' => 'seat_access',
            ],
            [
                'id'    => 61,
                'title' => 'section_create',
            ],
            [
                'id'    => 62,
                'title' => 'section_edit',
            ],
            [
                'id'    => 63,
                'title' => 'section_show',
            ],
            [
                'id'    => 64,
                'title' => 'section_delete',
            ],
            [
                'id'    => 65,
                'title' => 'section_access',
            ],
            [
                'id'    => 66,
                'title' => 'attendance_book_create',
            ],
            [
                'id'    => 67,
                'title' => 'attendance_book_edit',
            ],
            [
                'id'    => 68,
                'title' => 'attendance_book_show',
            ],
            [
                'id'    => 69,
                'title' => 'attendance_book_delete',
            ],
            [
                'id'    => 70,
                'title' => 'attendance_book_access',
            ],
            [
                'id'    => 71,
                'title' => 'section_employee_create',
            ],
            [
                'id'    => 72,
                'title' => 'section_employee_edit',
            ],
            [
                'id'    => 73,
                'title' => 'section_employee_show',
            ],
            [
                'id'    => 74,
                'title' => 'section_employee_delete',
            ],
            [
                'id'    => 75,
                'title' => 'section_employee_access',
            ],
            [
                'id'    => 76,
                'title' => 'success_punching_create',
            ],
            [
                'id'    => 77,
                'title' => 'success_punching_edit',
            ],
            [
                'id'    => 78,
                'title' => 'success_punching_show',
            ],
            [
                'id'    => 79,
                'title' => 'success_punching_delete',
            ],
            [
                'id'    => 80,
                'title' => 'success_punching_access',
            ],
            [
                'id'    => 81,
                'title' => 'punching_register_create',
            ],
            [
                'id'    => 82,
                'title' => 'punching_register_edit',
            ],
            [
                'id'    => 83,
                'title' => 'punching_register_show',
            ],
            [
                'id'    => 84,
                'title' => 'punching_register_access',
            ],
            [
                'id'    => 85,
                'title' => 'punching_device_create',
            ],
            [
                'id'    => 86,
                'title' => 'punching_device_edit',
            ],
            [
                'id'    => 87,
                'title' => 'punching_device_show',
            ],
            [
                'id'    => 88,
                'title' => 'punching_device_delete',
            ],
            [
                'id'    => 89,
                'title' => 'punching_device_access',
            ],
            [
                'id'    => 90,
                'title' => 'assembly_related_access',
            ],
            [
                'id'    => 91,
                'title' => 'exemption_create',
            ],
            [
                'id'    => 92,
                'title' => 'exemption_edit',
            ],
            [
                'id'    => 93,
                'title' => 'exemption_show',
            ],
            [
                'id'    => 94,
                'title' => 'exemption_delete',
            ],
            [
                'id'    => 95,
                'title' => 'exemption_access',
            ],
            [
                'id'    => 96,
                'title' => 'seniority_create',
            ],
            [
                'id'    => 97,
                'title' => 'seniority_edit',
            ],
            [
                'id'    => 98,
                'title' => 'seniority_show',
            ],
            [
                'id'    => 99,
                'title' => 'seniority_delete',
            ],
            [
                'id'    => 100,
                'title' => 'seniority_access',
            ],
            [
                'id'    => 101,
                'title' => 'employee_at_seat_create',
            ],
            [
                'id'    => 102,
                'title' => 'employee_at_seat_edit',
            ],
            [
                'id'    => 103,
                'title' => 'employee_at_seat_show',
            ],
            [
                'id'    => 104,
                'title' => 'employee_at_seat_delete',
            ],
            [
                'id'    => 105,
                'title' => 'employee_at_seat_access',
            ],
            [
                'id'    => 106,
                'title' => 'dept_designation_create',
            ],
            [
                'id'    => 107,
                'title' => 'dept_designation_edit',
            ],
            [
                'id'    => 108,
                'title' => 'dept_designation_show',
            ],
            [
                'id'    => 109,
                'title' => 'dept_designation_delete',
            ],
            [
                'id'    => 110,
                'title' => 'dept_designation_access',
            ],
            [
                'id'    => 111,
                'title' => 'dept_employee_create',
            ],
            [
                'id'    => 112,
                'title' => 'dept_employee_edit',
            ],
            [
                'id'    => 113,
                'title' => 'dept_employee_show',
            ],
            [
                'id'    => 114,
                'title' => 'dept_employee_delete',
            ],
            [
                'id'    => 115,
                'title' => 'dept_employee_access',
            ],
            [
                'id'    => 116,
                'title' => 'ot_form_create',
            ],
            [
                'id'    => 117,
                'title' => 'ot_form_edit',
            ],
            [
                'id'    => 118,
                'title' => 'ot_form_show',
            ],
            [
                'id'    => 119,
                'title' => 'ot_form_delete',
            ],
            [
                'id'    => 120,
                'title' => 'ot_form_access',
            ],
            [
                'id'    => 121,
                'title' => 'ot_form_other_create',
            ],
            [
                'id'    => 122,
                'title' => 'ot_form_other_edit',
            ],
            [
                'id'    => 123,
                'title' => 'ot_form_other_show',
            ],
            [
                'id'    => 124,
                'title' => 'ot_form_other_delete',
            ],
            [
                'id'    => 125,
                'title' => 'ot_form_other_access',
            ],
            [
                'id'    => 126,
                'title' => 'overtime_create',
            ],
            [
                'id'    => 127,
                'title' => 'overtime_edit',
            ],
            [
                'id'    => 128,
                'title' => 'overtime_show',
            ],
            [
                'id'    => 129,
                'title' => 'overtime_delete',
            ],
            [
                'id'    => 130,
                'title' => 'overtime_access',
            ],
            [
                'id'    => 131,
                'title' => 'overtime_other_create',
            ],
            [
                'id'    => 132,
                'title' => 'overtime_other_edit',
            ],
            [
                'id'    => 133,
                'title' => 'overtime_other_show',
            ],
            [
                'id'    => 134,
                'title' => 'overtime_other_delete',
            ],
            [
                'id'    => 135,
                'title' => 'overtime_other_access',
            ],
            [
                'id'    => 136,
                'title' => 'overtime_sitting_create',
            ],
            [
                'id'    => 137,
                'title' => 'overtime_sitting_edit',
            ],
            [
                'id'    => 138,
                'title' => 'overtime_sitting_show',
            ],
            [
                'id'    => 139,
                'title' => 'overtime_sitting_delete',
            ],
            [
                'id'    => 140,
                'title' => 'overtime_sitting_access',
            ],
            [
                'id'    => 141,
                'title' => 'ot_routing_create',
            ],
            [
                'id'    => 142,
                'title' => 'ot_routing_edit',
            ],
            [
                'id'    => 143,
                'title' => 'ot_routing_show',
            ],
            [
                'id'    => 144,
                'title' => 'ot_routing_delete',
            ],
            [
                'id'    => 145,
                'title' => 'ot_routing_access',
            ],
            [
                'id'    => 146,
                'title' => 'attendance_routing_create',
            ],
            [
                'id'    => 147,
                'title' => 'attendance_routing_edit',
            ],
            [
                'id'    => 148,
                'title' => 'attendance_routing_show',
            ],
            [
                'id'    => 149,
                'title' => 'attendance_routing_delete',
            ],
            [
                'id'    => 150,
                'title' => 'attendance_routing_access',
            ],
            [
                'id'    => 151,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
