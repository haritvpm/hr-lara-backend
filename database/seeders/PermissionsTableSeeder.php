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
                'title' => 'designation_create',
            ],
            [
                'id'    => 19,
                'title' => 'designation_edit',
            ],
            [
                'id'    => 20,
                'title' => 'designation_show',
            ],
            [
                'id'    => 21,
                'title' => 'designation_delete',
            ],
            [
                'id'    => 22,
                'title' => 'designation_access',
            ],
            [
                'id'    => 23,
                'title' => 'overtime_related_access',
            ],
            [
                'id'    => 24,
                'title' => 'ot_category_create',
            ],
            [
                'id'    => 25,
                'title' => 'ot_category_edit',
            ],
            [
                'id'    => 26,
                'title' => 'ot_category_show',
            ],
            [
                'id'    => 27,
                'title' => 'ot_category_delete',
            ],
            [
                'id'    => 28,
                'title' => 'ot_category_access',
            ],
            [
                'id'    => 29,
                'title' => 'employee_create',
            ],
            [
                'id'    => 30,
                'title' => 'employee_edit',
            ],
            [
                'id'    => 31,
                'title' => 'employee_show',
            ],
            [
                'id'    => 32,
                'title' => 'employee_delete',
            ],
            [
                'id'    => 33,
                'title' => 'employee_access',
            ],
            [
                'id'    => 34,
                'title' => 'punching_management_access',
            ],
            [
                'id'    => 35,
                'title' => 'punching_trace_access',
            ],
            [
                'id'    => 36,
                'title' => 'attendance_access',
            ],
            [
                'id'    => 37,
                'title' => 'govt_calendar_edit',
            ],
            [
                'id'    => 38,
                'title' => 'govt_calendar_show',
            ],
            [
                'id'    => 39,
                'title' => 'govt_calendar_access',
            ],
            [
                'id'    => 40,
                'title' => 'office_related_access',
            ],
            [
                'id'    => 41,
                'title' => 'administrative_office_create',
            ],
            [
                'id'    => 42,
                'title' => 'administrative_office_edit',
            ],
            [
                'id'    => 43,
                'title' => 'administrative_office_show',
            ],
            [
                'id'    => 44,
                'title' => 'administrative_office_delete',
            ],
            [
                'id'    => 45,
                'title' => 'administrative_office_access',
            ],
            [
                'id'    => 46,
                'title' => 'seat_create',
            ],
            [
                'id'    => 47,
                'title' => 'seat_edit',
            ],
            [
                'id'    => 48,
                'title' => 'seat_show',
            ],
            [
                'id'    => 49,
                'title' => 'seat_delete',
            ],
            [
                'id'    => 50,
                'title' => 'seat_access',
            ],
            [
                'id'    => 51,
                'title' => 'section_create',
            ],
            [
                'id'    => 52,
                'title' => 'section_edit',
            ],
            [
                'id'    => 53,
                'title' => 'section_show',
            ],
            [
                'id'    => 54,
                'title' => 'section_delete',
            ],
            [
                'id'    => 55,
                'title' => 'section_access',
            ],
            [
                'id'    => 56,
                'title' => 'attendance_book_create',
            ],
            [
                'id'    => 57,
                'title' => 'attendance_book_edit',
            ],
            [
                'id'    => 58,
                'title' => 'attendance_book_show',
            ],
            [
                'id'    => 59,
                'title' => 'attendance_book_delete',
            ],
            [
                'id'    => 60,
                'title' => 'attendance_book_access',
            ],
            [
                'id'    => 61,
                'title' => 'success_punching_create',
            ],
            [
                'id'    => 62,
                'title' => 'success_punching_edit',
            ],
            [
                'id'    => 63,
                'title' => 'success_punching_show',
            ],
            [
                'id'    => 64,
                'title' => 'success_punching_delete',
            ],
            [
                'id'    => 65,
                'title' => 'success_punching_access',
            ],
            [
                'id'    => 66,
                'title' => 'punching_device_create',
            ],
            [
                'id'    => 67,
                'title' => 'punching_device_edit',
            ],
            [
                'id'    => 68,
                'title' => 'punching_device_show',
            ],
            [
                'id'    => 69,
                'title' => 'punching_device_delete',
            ],
            [
                'id'    => 70,
                'title' => 'punching_device_access',
            ],
            [
                'id'    => 71,
                'title' => 'assembly_related_access',
            ],
            [
                'id'    => 72,
                'title' => 'exemption_create',
            ],
            [
                'id'    => 73,
                'title' => 'exemption_edit',
            ],
            [
                'id'    => 74,
                'title' => 'exemption_show',
            ],
            [
                'id'    => 75,
                'title' => 'exemption_delete',
            ],
            [
                'id'    => 76,
                'title' => 'exemption_access',
            ],
            [
                'id'    => 77,
                'title' => 'seniority_create',
            ],
            [
                'id'    => 78,
                'title' => 'seniority_edit',
            ],
            [
                'id'    => 79,
                'title' => 'seniority_show',
            ],
            [
                'id'    => 80,
                'title' => 'seniority_delete',
            ],
            [
                'id'    => 81,
                'title' => 'seniority_access',
            ],
            [
                'id'    => 82,
                'title' => 'dept_designation_create',
            ],
            [
                'id'    => 83,
                'title' => 'dept_designation_edit',
            ],
            [
                'id'    => 84,
                'title' => 'dept_designation_show',
            ],
            [
                'id'    => 85,
                'title' => 'dept_designation_delete',
            ],
            [
                'id'    => 86,
                'title' => 'dept_designation_access',
            ],
            [
                'id'    => 87,
                'title' => 'dept_employee_create',
            ],
            [
                'id'    => 88,
                'title' => 'dept_employee_edit',
            ],
            [
                'id'    => 89,
                'title' => 'dept_employee_show',
            ],
            [
                'id'    => 90,
                'title' => 'dept_employee_delete',
            ],
            [
                'id'    => 91,
                'title' => 'dept_employee_access',
            ],
            [
                'id'    => 92,
                'title' => 'ot_form_create',
            ],
            [
                'id'    => 93,
                'title' => 'ot_form_edit',
            ],
            [
                'id'    => 94,
                'title' => 'ot_form_show',
            ],
            [
                'id'    => 95,
                'title' => 'ot_form_delete',
            ],
            [
                'id'    => 96,
                'title' => 'ot_form_access',
            ],
            [
                'id'    => 97,
                'title' => 'ot_form_other_create',
            ],
            [
                'id'    => 98,
                'title' => 'ot_form_other_edit',
            ],
            [
                'id'    => 99,
                'title' => 'ot_form_other_show',
            ],
            [
                'id'    => 100,
                'title' => 'ot_form_other_delete',
            ],
            [
                'id'    => 101,
                'title' => 'ot_form_other_access',
            ],
            [
                'id'    => 102,
                'title' => 'overtime_create',
            ],
            [
                'id'    => 103,
                'title' => 'overtime_edit',
            ],
            [
                'id'    => 104,
                'title' => 'overtime_show',
            ],
            [
                'id'    => 105,
                'title' => 'overtime_delete',
            ],
            [
                'id'    => 106,
                'title' => 'overtime_access',
            ],
            [
                'id'    => 107,
                'title' => 'overtime_other_create',
            ],
            [
                'id'    => 108,
                'title' => 'overtime_other_edit',
            ],
            [
                'id'    => 109,
                'title' => 'overtime_other_show',
            ],
            [
                'id'    => 110,
                'title' => 'overtime_other_delete',
            ],
            [
                'id'    => 111,
                'title' => 'overtime_other_access',
            ],
            [
                'id'    => 112,
                'title' => 'overtime_sitting_access',
            ],
            [
                'id'    => 113,
                'title' => 'ot_routing_create',
            ],
            [
                'id'    => 114,
                'title' => 'ot_routing_edit',
            ],
            [
                'id'    => 115,
                'title' => 'ot_routing_show',
            ],
            [
                'id'    => 116,
                'title' => 'ot_routing_delete',
            ],
            [
                'id'    => 117,
                'title' => 'ot_routing_access',
            ],
            [
                'id'    => 118,
                'title' => 'attendance_routing_create',
            ],
            [
                'id'    => 119,
                'title' => 'attendance_routing_edit',
            ],
            [
                'id'    => 120,
                'title' => 'attendance_routing_show',
            ],
            [
                'id'    => 121,
                'title' => 'attendance_routing_delete',
            ],
            [
                'id'    => 122,
                'title' => 'attendance_routing_access',
            ],
            [
                'id'    => 123,
                'title' => 'office_location_create',
            ],
            [
                'id'    => 124,
                'title' => 'office_location_edit',
            ],
            [
                'id'    => 125,
                'title' => 'office_location_show',
            ],
            [
                'id'    => 126,
                'title' => 'office_location_access',
            ],
            [
                'id'    => 127,
                'title' => 'employee_to_seat_create',
            ],
            [
                'id'    => 128,
                'title' => 'employee_to_seat_edit',
            ],
            [
                'id'    => 129,
                'title' => 'employee_to_seat_show',
            ],
            [
                'id'    => 130,
                'title' => 'employee_to_seat_delete',
            ],
            [
                'id'    => 131,
                'title' => 'employee_to_seat_access',
            ],
            [
                'id'    => 132,
                'title' => 'employee_to_section_create',
            ],
            [
                'id'    => 133,
                'title' => 'employee_to_section_edit',
            ],
            [
                'id'    => 134,
                'title' => 'employee_to_section_show',
            ],
            [
                'id'    => 135,
                'title' => 'employee_to_section_delete',
            ],
            [
                'id'    => 136,
                'title' => 'employee_to_section_access',
            ],
            [
                'id'    => 137,
                'title' => 'employee_to_designation_create',
            ],
            [
                'id'    => 138,
                'title' => 'employee_to_designation_edit',
            ],
            [
                'id'    => 139,
                'title' => 'employee_to_designation_show',
            ],
            [
                'id'    => 140,
                'title' => 'employee_to_designation_delete',
            ],
            [
                'id'    => 141,
                'title' => 'employee_to_designation_access',
            ],
            [
                'id'    => 142,
                'title' => 'account_access',
            ],
            [
                'id'    => 143,
                'title' => 'acquittance_create',
            ],
            [
                'id'    => 144,
                'title' => 'acquittance_edit',
            ],
            [
                'id'    => 145,
                'title' => 'acquittance_show',
            ],
            [
                'id'    => 146,
                'title' => 'acquittance_delete',
            ],
            [
                'id'    => 147,
                'title' => 'acquittance_access',
            ],
            [
                'id'    => 148,
                'title' => 'employee_to_acquittance_create',
            ],
            [
                'id'    => 149,
                'title' => 'employee_to_acquittance_edit',
            ],
            [
                'id'    => 150,
                'title' => 'employee_to_acquittance_show',
            ],
            [
                'id'    => 151,
                'title' => 'employee_to_acquittance_delete',
            ],
            [
                'id'    => 152,
                'title' => 'employee_to_acquittance_access',
            ],
            [
                'id'    => 153,
                'title' => 'ddo_create',
            ],
            [
                'id'    => 154,
                'title' => 'ddo_edit',
            ],
            [
                'id'    => 155,
                'title' => 'ddo_show',
            ],
            [
                'id'    => 156,
                'title' => 'ddo_delete',
            ],
            [
                'id'    => 157,
                'title' => 'ddo_access',
            ],
            [
                'id'    => 158,
                'title' => 'shift_create',
            ],
            [
                'id'    => 159,
                'title' => 'shift_edit',
            ],
            [
                'id'    => 160,
                'title' => 'shift_show',
            ],
            [
                'id'    => 161,
                'title' => 'shift_delete',
            ],
            [
                'id'    => 162,
                'title' => 'shift_access',
            ],
            [
                'id'    => 163,
                'title' => 'employee_to_shift_create',
            ],
            [
                'id'    => 164,
                'title' => 'employee_to_shift_edit',
            ],
            [
                'id'    => 165,
                'title' => 'employee_to_shift_show',
            ],
            [
                'id'    => 166,
                'title' => 'employee_to_shift_delete',
            ],
            [
                'id'    => 167,
                'title' => 'employee_to_shift_access',
            ],
            [
                'id'    => 168,
                'title' => 'td_create',
            ],
            [
                'id'    => 169,
                'title' => 'td_edit',
            ],
            [
                'id'    => 170,
                'title' => 'td_show',
            ],
            [
                'id'    => 171,
                'title' => 'td_delete',
            ],
            [
                'id'    => 172,
                'title' => 'td_access',
            ],
            [
                'id'    => 173,
                'title' => 'tax_entry_create',
            ],
            [
                'id'    => 174,
                'title' => 'tax_entry_edit',
            ],
            [
                'id'    => 175,
                'title' => 'tax_entry_show',
            ],
            [
                'id'    => 176,
                'title' => 'tax_entry_delete',
            ],
            [
                'id'    => 177,
                'title' => 'tax_entry_access',
            ],
            [
                'id'    => 178,
                'title' => 'punching_create',
            ],
            [
                'id'    => 179,
                'title' => 'punching_edit',
            ],
            [
                'id'    => 180,
                'title' => 'punching_show',
            ],
            [
                'id'    => 181,
                'title' => 'punching_access',
            ],
            [
                'id'    => 182,
                'title' => 'assembly_session_create',
            ],
            [
                'id'    => 183,
                'title' => 'assembly_session_edit',
            ],
            [
                'id'    => 184,
                'title' => 'assembly_session_show',
            ],
            [
                'id'    => 185,
                'title' => 'assembly_session_delete',
            ],
            [
                'id'    => 186,
                'title' => 'assembly_session_access',
            ],
            [
                'id'    => 187,
                'title' => 'leaf_create',
            ],
            [
                'id'    => 188,
                'title' => 'leaf_edit',
            ],
            [
                'id'    => 189,
                'title' => 'leaf_show',
            ],
            [
                'id'    => 190,
                'title' => 'leaf_delete',
            ],
            [
                'id'    => 191,
                'title' => 'leaf_access',
            ],
            [
                'id'    => 192,
                'title' => 'time_management_access',
            ],
            [
                'id'    => 193,
                'title' => 'office_time_create',
            ],
            [
                'id'    => 194,
                'title' => 'office_time_edit',
            ],
            [
                'id'    => 195,
                'title' => 'office_time_show',
            ],
            [
                'id'    => 196,
                'title' => 'office_time_delete',
            ],
            [
                'id'    => 197,
                'title' => 'office_time_access',
            ],
            [
                'id'    => 198,
                'title' => 'seat_to_js_as_ss_create',
            ],
            [
                'id'    => 199,
                'title' => 'seat_to_js_as_ss_edit',
            ],
            [
                'id'    => 200,
                'title' => 'seat_to_js_as_ss_show',
            ],
            [
                'id'    => 201,
                'title' => 'seat_to_js_as_ss_delete',
            ],
            [
                'id'    => 202,
                'title' => 'seat_to_js_as_ss_access',
            ],
            [
                'id'    => 203,
                'title' => 'employee_ot_setting_create',
            ],
            [
                'id'    => 204,
                'title' => 'employee_ot_setting_edit',
            ],
            [
                'id'    => 205,
                'title' => 'employee_ot_setting_show',
            ],
            [
                'id'    => 206,
                'title' => 'employee_ot_setting_delete',
            ],
            [
                'id'    => 207,
                'title' => 'employee_ot_setting_access',
            ],
            [
                'id'    => 208,
                'title' => 'monthly_attendance_create',
            ],
            [
                'id'    => 209,
                'title' => 'monthly_attendance_edit',
            ],
            [
                'id'    => 210,
                'title' => 'monthly_attendance_show',
            ],
            [
                'id'    => 211,
                'title' => 'monthly_attendance_delete',
            ],
            [
                'id'    => 212,
                'title' => 'monthly_attendance_access',
            ],
            [
                'id'    => 213,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
