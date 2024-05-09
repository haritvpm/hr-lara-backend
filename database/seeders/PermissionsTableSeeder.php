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
                'title' => 'govt_calendar_edit',
            ],
            [
                'id'    => 37,
                'title' => 'govt_calendar_show',
            ],
            [
                'id'    => 38,
                'title' => 'govt_calendar_access',
            ],
            [
                'id'    => 39,
                'title' => 'office_related_access',
            ],
            [
                'id'    => 40,
                'title' => 'administrative_office_create',
            ],
            [
                'id'    => 41,
                'title' => 'administrative_office_edit',
            ],
            [
                'id'    => 42,
                'title' => 'administrative_office_show',
            ],
            [
                'id'    => 43,
                'title' => 'administrative_office_delete',
            ],
            [
                'id'    => 44,
                'title' => 'administrative_office_access',
            ],
            [
                'id'    => 45,
                'title' => 'seat_create',
            ],
            [
                'id'    => 46,
                'title' => 'seat_edit',
            ],
            [
                'id'    => 47,
                'title' => 'seat_show',
            ],
            [
                'id'    => 48,
                'title' => 'seat_delete',
            ],
            [
                'id'    => 49,
                'title' => 'seat_access',
            ],
            [
                'id'    => 50,
                'title' => 'section_create',
            ],
            [
                'id'    => 51,
                'title' => 'section_edit',
            ],
            [
                'id'    => 52,
                'title' => 'section_show',
            ],
            [
                'id'    => 53,
                'title' => 'section_delete',
            ],
            [
                'id'    => 54,
                'title' => 'section_access',
            ],
            [
                'id'    => 55,
                'title' => 'attendance_book_create',
            ],
            [
                'id'    => 56,
                'title' => 'attendance_book_edit',
            ],
            [
                'id'    => 57,
                'title' => 'attendance_book_show',
            ],
            [
                'id'    => 58,
                'title' => 'attendance_book_delete',
            ],
            [
                'id'    => 59,
                'title' => 'attendance_book_access',
            ],
            [
                'id'    => 60,
                'title' => 'success_punching_create',
            ],
            [
                'id'    => 61,
                'title' => 'success_punching_edit',
            ],
            [
                'id'    => 62,
                'title' => 'success_punching_show',
            ],
            [
                'id'    => 63,
                'title' => 'success_punching_delete',
            ],
            [
                'id'    => 64,
                'title' => 'success_punching_access',
            ],
            [
                'id'    => 65,
                'title' => 'punching_device_create',
            ],
            [
                'id'    => 66,
                'title' => 'punching_device_edit',
            ],
            [
                'id'    => 67,
                'title' => 'punching_device_show',
            ],
            [
                'id'    => 68,
                'title' => 'punching_device_delete',
            ],
            [
                'id'    => 69,
                'title' => 'punching_device_access',
            ],
            [
                'id'    => 70,
                'title' => 'assembly_related_access',
            ],
            [
                'id'    => 71,
                'title' => 'exemption_create',
            ],
            [
                'id'    => 72,
                'title' => 'exemption_edit',
            ],
            [
                'id'    => 73,
                'title' => 'exemption_show',
            ],
            [
                'id'    => 74,
                'title' => 'exemption_delete',
            ],
            [
                'id'    => 75,
                'title' => 'exemption_access',
            ],
            [
                'id'    => 76,
                'title' => 'seniority_create',
            ],
            [
                'id'    => 77,
                'title' => 'seniority_edit',
            ],
            [
                'id'    => 78,
                'title' => 'seniority_show',
            ],
            [
                'id'    => 79,
                'title' => 'seniority_delete',
            ],
            [
                'id'    => 80,
                'title' => 'seniority_access',
            ],
            [
                'id'    => 81,
                'title' => 'dept_designation_create',
            ],
            [
                'id'    => 82,
                'title' => 'dept_designation_edit',
            ],
            [
                'id'    => 83,
                'title' => 'dept_designation_show',
            ],
            [
                'id'    => 84,
                'title' => 'dept_designation_delete',
            ],
            [
                'id'    => 85,
                'title' => 'dept_designation_access',
            ],
            [
                'id'    => 86,
                'title' => 'dept_employee_create',
            ],
            [
                'id'    => 87,
                'title' => 'dept_employee_edit',
            ],
            [
                'id'    => 88,
                'title' => 'dept_employee_show',
            ],
            [
                'id'    => 89,
                'title' => 'dept_employee_delete',
            ],
            [
                'id'    => 90,
                'title' => 'dept_employee_access',
            ],
            [
                'id'    => 91,
                'title' => 'ot_form_create',
            ],
            [
                'id'    => 92,
                'title' => 'ot_form_edit',
            ],
            [
                'id'    => 93,
                'title' => 'ot_form_show',
            ],
            [
                'id'    => 94,
                'title' => 'ot_form_delete',
            ],
            [
                'id'    => 95,
                'title' => 'ot_form_access',
            ],
            [
                'id'    => 96,
                'title' => 'ot_form_other_create',
            ],
            [
                'id'    => 97,
                'title' => 'ot_form_other_edit',
            ],
            [
                'id'    => 98,
                'title' => 'ot_form_other_show',
            ],
            [
                'id'    => 99,
                'title' => 'ot_form_other_delete',
            ],
            [
                'id'    => 100,
                'title' => 'ot_form_other_access',
            ],
            [
                'id'    => 101,
                'title' => 'overtime_create',
            ],
            [
                'id'    => 102,
                'title' => 'overtime_edit',
            ],
            [
                'id'    => 103,
                'title' => 'overtime_show',
            ],
            [
                'id'    => 104,
                'title' => 'overtime_delete',
            ],
            [
                'id'    => 105,
                'title' => 'overtime_access',
            ],
            [
                'id'    => 106,
                'title' => 'overtime_other_create',
            ],
            [
                'id'    => 107,
                'title' => 'overtime_other_edit',
            ],
            [
                'id'    => 108,
                'title' => 'overtime_other_show',
            ],
            [
                'id'    => 109,
                'title' => 'overtime_other_delete',
            ],
            [
                'id'    => 110,
                'title' => 'overtime_other_access',
            ],
            [
                'id'    => 111,
                'title' => 'overtime_sitting_access',
            ],
            [
                'id'    => 112,
                'title' => 'ot_routing_create',
            ],
            [
                'id'    => 113,
                'title' => 'ot_routing_edit',
            ],
            [
                'id'    => 114,
                'title' => 'ot_routing_show',
            ],
            [
                'id'    => 115,
                'title' => 'ot_routing_delete',
            ],
            [
                'id'    => 116,
                'title' => 'ot_routing_access',
            ],
            [
                'id'    => 117,
                'title' => 'attendance_routing_create',
            ],
            [
                'id'    => 118,
                'title' => 'attendance_routing_edit',
            ],
            [
                'id'    => 119,
                'title' => 'attendance_routing_show',
            ],
            [
                'id'    => 120,
                'title' => 'attendance_routing_delete',
            ],
            [
                'id'    => 121,
                'title' => 'attendance_routing_access',
            ],
            [
                'id'    => 122,
                'title' => 'office_location_create',
            ],
            [
                'id'    => 123,
                'title' => 'office_location_edit',
            ],
            [
                'id'    => 124,
                'title' => 'office_location_show',
            ],
            [
                'id'    => 125,
                'title' => 'office_location_access',
            ],
            [
                'id'    => 126,
                'title' => 'employee_to_seat_create',
            ],
            [
                'id'    => 127,
                'title' => 'employee_to_seat_edit',
            ],
            [
                'id'    => 128,
                'title' => 'employee_to_seat_show',
            ],
            [
                'id'    => 129,
                'title' => 'employee_to_seat_delete',
            ],
            [
                'id'    => 130,
                'title' => 'employee_to_seat_access',
            ],
            [
                'id'    => 131,
                'title' => 'employee_to_section_create',
            ],
            [
                'id'    => 132,
                'title' => 'employee_to_section_edit',
            ],
            [
                'id'    => 133,
                'title' => 'employee_to_section_show',
            ],
            [
                'id'    => 134,
                'title' => 'employee_to_section_delete',
            ],
            [
                'id'    => 135,
                'title' => 'employee_to_section_access',
            ],
            [
                'id'    => 136,
                'title' => 'employee_to_designation_create',
            ],
            [
                'id'    => 137,
                'title' => 'employee_to_designation_edit',
            ],
            [
                'id'    => 138,
                'title' => 'employee_to_designation_show',
            ],
            [
                'id'    => 139,
                'title' => 'employee_to_designation_delete',
            ],
            [
                'id'    => 140,
                'title' => 'employee_to_designation_access',
            ],
            [
                'id'    => 141,
                'title' => 'account_access',
            ],
            [
                'id'    => 142,
                'title' => 'acquittance_create',
            ],
            [
                'id'    => 143,
                'title' => 'acquittance_edit',
            ],
            [
                'id'    => 144,
                'title' => 'acquittance_show',
            ],
            [
                'id'    => 145,
                'title' => 'acquittance_delete',
            ],
            [
                'id'    => 146,
                'title' => 'acquittance_access',
            ],
            [
                'id'    => 147,
                'title' => 'employee_to_acquittance_create',
            ],
            [
                'id'    => 148,
                'title' => 'employee_to_acquittance_edit',
            ],
            [
                'id'    => 149,
                'title' => 'employee_to_acquittance_show',
            ],
            [
                'id'    => 150,
                'title' => 'employee_to_acquittance_delete',
            ],
            [
                'id'    => 151,
                'title' => 'employee_to_acquittance_access',
            ],
            [
                'id'    => 152,
                'title' => 'ddo_create',
            ],
            [
                'id'    => 153,
                'title' => 'ddo_edit',
            ],
            [
                'id'    => 154,
                'title' => 'ddo_show',
            ],
            [
                'id'    => 155,
                'title' => 'ddo_delete',
            ],
            [
                'id'    => 156,
                'title' => 'ddo_access',
            ],
            [
                'id'    => 157,
                'title' => 'shift_create',
            ],
            [
                'id'    => 158,
                'title' => 'shift_edit',
            ],
            [
                'id'    => 159,
                'title' => 'shift_show',
            ],
            [
                'id'    => 160,
                'title' => 'shift_delete',
            ],
            [
                'id'    => 161,
                'title' => 'shift_access',
            ],
            [
                'id'    => 162,
                'title' => 'employee_to_shift_create',
            ],
            [
                'id'    => 163,
                'title' => 'employee_to_shift_edit',
            ],
            [
                'id'    => 164,
                'title' => 'employee_to_shift_show',
            ],
            [
                'id'    => 165,
                'title' => 'employee_to_shift_delete',
            ],
            [
                'id'    => 166,
                'title' => 'employee_to_shift_access',
            ],
            [
                'id'    => 167,
                'title' => 'td_create',
            ],
            [
                'id'    => 168,
                'title' => 'td_edit',
            ],
            [
                'id'    => 169,
                'title' => 'td_show',
            ],
            [
                'id'    => 170,
                'title' => 'td_delete',
            ],
            [
                'id'    => 171,
                'title' => 'td_access',
            ],
            [
                'id'    => 172,
                'title' => 'tax_entry_create',
            ],
            [
                'id'    => 173,
                'title' => 'tax_entry_edit',
            ],
            [
                'id'    => 174,
                'title' => 'tax_entry_show',
            ],
            [
                'id'    => 175,
                'title' => 'tax_entry_delete',
            ],
            [
                'id'    => 176,
                'title' => 'tax_entry_access',
            ],
            [
                'id'    => 177,
                'title' => 'punching_edit',
            ],
            [
                'id'    => 178,
                'title' => 'punching_show',
            ],
            [
                'id'    => 179,
                'title' => 'punching_access',
            ],
            [
                'id'    => 180,
                'title' => 'assembly_session_create',
            ],
            [
                'id'    => 181,
                'title' => 'assembly_session_edit',
            ],
            [
                'id'    => 182,
                'title' => 'assembly_session_show',
            ],
            [
                'id'    => 183,
                'title' => 'assembly_session_delete',
            ],
            [
                'id'    => 184,
                'title' => 'assembly_session_access',
            ],
            [
                'id'    => 185,
                'title' => 'leaf_edit',
            ],
            [
                'id'    => 186,
                'title' => 'leaf_show',
            ],
            [
                'id'    => 187,
                'title' => 'leaf_delete',
            ],
            [
                'id'    => 188,
                'title' => 'leaf_access',
            ],
            [
                'id'    => 189,
                'title' => 'time_management_access',
            ],
            [
                'id'    => 190,
                'title' => 'office_time_create',
            ],
            [
                'id'    => 191,
                'title' => 'office_time_edit',
            ],
            [
                'id'    => 192,
                'title' => 'office_time_show',
            ],
            [
                'id'    => 193,
                'title' => 'office_time_delete',
            ],
            [
                'id'    => 194,
                'title' => 'office_time_access',
            ],
            [
                'id'    => 195,
                'title' => 'seat_to_js_as_ss_create',
            ],
            [
                'id'    => 196,
                'title' => 'seat_to_js_as_ss_edit',
            ],
            [
                'id'    => 197,
                'title' => 'seat_to_js_as_ss_show',
            ],
            [
                'id'    => 198,
                'title' => 'seat_to_js_as_ss_delete',
            ],
            [
                'id'    => 199,
                'title' => 'seat_to_js_as_ss_access',
            ],
            [
                'id'    => 200,
                'title' => 'employee_ot_setting_create',
            ],
            [
                'id'    => 201,
                'title' => 'employee_ot_setting_edit',
            ],
            [
                'id'    => 202,
                'title' => 'employee_ot_setting_show',
            ],
            [
                'id'    => 203,
                'title' => 'employee_ot_setting_delete',
            ],
            [
                'id'    => 204,
                'title' => 'employee_ot_setting_access',
            ],
            [
                'id'    => 205,
                'title' => 'monthly_attendance_create',
            ],
            [
                'id'    => 206,
                'title' => 'monthly_attendance_edit',
            ],
            [
                'id'    => 207,
                'title' => 'monthly_attendance_show',
            ],
            [
                'id'    => 208,
                'title' => 'monthly_attendance_delete',
            ],
            [
                'id'    => 209,
                'title' => 'monthly_attendance_access',
            ],
            [
                'id'    => 210,
                'title' => 'yearly_attendance_create',
            ],
            [
                'id'    => 211,
                'title' => 'yearly_attendance_edit',
            ],
            [
                'id'    => 212,
                'title' => 'yearly_attendance_show',
            ],
            [
                'id'    => 213,
                'title' => 'yearly_attendance_delete',
            ],
            [
                'id'    => 214,
                'title' => 'yearly_attendance_access',
            ],
            [
                'id'    => 215,
                'title' => 'setting_create',
            ],
            [
                'id'    => 216,
                'title' => 'setting_edit',
            ],
            [
                'id'    => 217,
                'title' => 'setting_show',
            ],
            [
                'id'    => 218,
                'title' => 'setting_delete',
            ],
            [
                'id'    => 219,
                'title' => 'setting_access',
            ],
            [
                'id'    => 220,
                'title' => 'employee_extra_create',
            ],
            [
                'id'    => 221,
                'title' => 'employee_extra_edit',
            ],
            [
                'id'    => 222,
                'title' => 'employee_extra_show',
            ],
            [
                'id'    => 223,
                'title' => 'employee_extra_delete',
            ],
            [
                'id'    => 224,
                'title' => 'employee_extra_access',
            ],
            [
                'id'    => 225,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
