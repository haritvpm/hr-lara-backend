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
                'title' => 'success_punching_create',
            ],
            [
                'id'    => 72,
                'title' => 'success_punching_edit',
            ],
            [
                'id'    => 73,
                'title' => 'success_punching_show',
            ],
            [
                'id'    => 74,
                'title' => 'success_punching_delete',
            ],
            [
                'id'    => 75,
                'title' => 'success_punching_access',
            ],
            [
                'id'    => 76,
                'title' => 'punching_device_create',
            ],
            [
                'id'    => 77,
                'title' => 'punching_device_edit',
            ],
            [
                'id'    => 78,
                'title' => 'punching_device_show',
            ],
            [
                'id'    => 79,
                'title' => 'punching_device_delete',
            ],
            [
                'id'    => 80,
                'title' => 'punching_device_access',
            ],
            [
                'id'    => 81,
                'title' => 'assembly_related_access',
            ],
            [
                'id'    => 82,
                'title' => 'exemption_create',
            ],
            [
                'id'    => 83,
                'title' => 'exemption_edit',
            ],
            [
                'id'    => 84,
                'title' => 'exemption_show',
            ],
            [
                'id'    => 85,
                'title' => 'exemption_delete',
            ],
            [
                'id'    => 86,
                'title' => 'exemption_access',
            ],
            [
                'id'    => 87,
                'title' => 'seniority_create',
            ],
            [
                'id'    => 88,
                'title' => 'seniority_edit',
            ],
            [
                'id'    => 89,
                'title' => 'seniority_show',
            ],
            [
                'id'    => 90,
                'title' => 'seniority_delete',
            ],
            [
                'id'    => 91,
                'title' => 'seniority_access',
            ],
            [
                'id'    => 92,
                'title' => 'dept_designation_create',
            ],
            [
                'id'    => 93,
                'title' => 'dept_designation_edit',
            ],
            [
                'id'    => 94,
                'title' => 'dept_designation_show',
            ],
            [
                'id'    => 95,
                'title' => 'dept_designation_delete',
            ],
            [
                'id'    => 96,
                'title' => 'dept_designation_access',
            ],
            [
                'id'    => 97,
                'title' => 'dept_employee_create',
            ],
            [
                'id'    => 98,
                'title' => 'dept_employee_edit',
            ],
            [
                'id'    => 99,
                'title' => 'dept_employee_show',
            ],
            [
                'id'    => 100,
                'title' => 'dept_employee_delete',
            ],
            [
                'id'    => 101,
                'title' => 'dept_employee_access',
            ],
            [
                'id'    => 102,
                'title' => 'ot_form_create',
            ],
            [
                'id'    => 103,
                'title' => 'ot_form_edit',
            ],
            [
                'id'    => 104,
                'title' => 'ot_form_show',
            ],
            [
                'id'    => 105,
                'title' => 'ot_form_delete',
            ],
            [
                'id'    => 106,
                'title' => 'ot_form_access',
            ],
            [
                'id'    => 107,
                'title' => 'ot_form_other_create',
            ],
            [
                'id'    => 108,
                'title' => 'ot_form_other_edit',
            ],
            [
                'id'    => 109,
                'title' => 'ot_form_other_show',
            ],
            [
                'id'    => 110,
                'title' => 'ot_form_other_delete',
            ],
            [
                'id'    => 111,
                'title' => 'ot_form_other_access',
            ],
            [
                'id'    => 112,
                'title' => 'overtime_create',
            ],
            [
                'id'    => 113,
                'title' => 'overtime_edit',
            ],
            [
                'id'    => 114,
                'title' => 'overtime_show',
            ],
            [
                'id'    => 115,
                'title' => 'overtime_delete',
            ],
            [
                'id'    => 116,
                'title' => 'overtime_access',
            ],
            [
                'id'    => 117,
                'title' => 'overtime_other_create',
            ],
            [
                'id'    => 118,
                'title' => 'overtime_other_edit',
            ],
            [
                'id'    => 119,
                'title' => 'overtime_other_show',
            ],
            [
                'id'    => 120,
                'title' => 'overtime_other_delete',
            ],
            [
                'id'    => 121,
                'title' => 'overtime_other_access',
            ],
            [
                'id'    => 122,
                'title' => 'overtime_sitting_create',
            ],
            [
                'id'    => 123,
                'title' => 'overtime_sitting_edit',
            ],
            [
                'id'    => 124,
                'title' => 'overtime_sitting_show',
            ],
            [
                'id'    => 125,
                'title' => 'overtime_sitting_delete',
            ],
            [
                'id'    => 126,
                'title' => 'overtime_sitting_access',
            ],
            [
                'id'    => 127,
                'title' => 'ot_routing_create',
            ],
            [
                'id'    => 128,
                'title' => 'ot_routing_edit',
            ],
            [
                'id'    => 129,
                'title' => 'ot_routing_show',
            ],
            [
                'id'    => 130,
                'title' => 'ot_routing_delete',
            ],
            [
                'id'    => 131,
                'title' => 'ot_routing_access',
            ],
            [
                'id'    => 132,
                'title' => 'attendance_routing_create',
            ],
            [
                'id'    => 133,
                'title' => 'attendance_routing_edit',
            ],
            [
                'id'    => 134,
                'title' => 'attendance_routing_show',
            ],
            [
                'id'    => 135,
                'title' => 'attendance_routing_delete',
            ],
            [
                'id'    => 136,
                'title' => 'attendance_routing_access',
            ],
            [
                'id'    => 137,
                'title' => 'office_location_create',
            ],
            [
                'id'    => 138,
                'title' => 'office_location_edit',
            ],
            [
                'id'    => 139,
                'title' => 'office_location_show',
            ],
            [
                'id'    => 140,
                'title' => 'office_location_access',
            ],
            [
                'id'    => 141,
                'title' => 'employee_seat_history_create',
            ],
            [
                'id'    => 142,
                'title' => 'employee_seat_history_edit',
            ],
            [
                'id'    => 143,
                'title' => 'employee_seat_history_show',
            ],
            [
                'id'    => 144,
                'title' => 'employee_seat_history_delete',
            ],
            [
                'id'    => 145,
                'title' => 'employee_seat_history_access',
            ],
            [
                'id'    => 146,
                'title' => 'employee_section_history_create',
            ],
            [
                'id'    => 147,
                'title' => 'employee_section_history_edit',
            ],
            [
                'id'    => 148,
                'title' => 'employee_section_history_show',
            ],
            [
                'id'    => 149,
                'title' => 'employee_section_history_delete',
            ],
            [
                'id'    => 150,
                'title' => 'employee_section_history_access',
            ],
            [
                'id'    => 151,
                'title' => 'employee_to_seat_create',
            ],
            [
                'id'    => 152,
                'title' => 'employee_to_seat_edit',
            ],
            [
                'id'    => 153,
                'title' => 'employee_to_seat_show',
            ],
            [
                'id'    => 154,
                'title' => 'employee_to_seat_delete',
            ],
            [
                'id'    => 155,
                'title' => 'employee_to_seat_access',
            ],
            [
                'id'    => 156,
                'title' => 'employee_to_section_create',
            ],
            [
                'id'    => 157,
                'title' => 'employee_to_section_edit',
            ],
            [
                'id'    => 158,
                'title' => 'employee_to_section_show',
            ],
            [
                'id'    => 159,
                'title' => 'employee_to_section_delete',
            ],
            [
                'id'    => 160,
                'title' => 'employee_to_section_access',
            ],
            [
                'id'    => 161,
                'title' => 'employee_detail_create',
            ],
            [
                'id'    => 162,
                'title' => 'employee_detail_edit',
            ],
            [
                'id'    => 163,
                'title' => 'employee_detail_show',
            ],
            [
                'id'    => 164,
                'title' => 'employee_detail_delete',
            ],
            [
                'id'    => 165,
                'title' => 'employee_detail_access',
            ],
            [
                'id'    => 166,
                'title' => 'employee_ot_data_create',
            ],
            [
                'id'    => 167,
                'title' => 'employee_ot_data_edit',
            ],
            [
                'id'    => 168,
                'title' => 'employee_ot_data_show',
            ],
            [
                'id'    => 169,
                'title' => 'employee_ot_data_delete',
            ],
            [
                'id'    => 170,
                'title' => 'employee_ot_data_access',
            ],
            [
                'id'    => 171,
                'title' => 'employee_designation_history_create',
            ],
            [
                'id'    => 172,
                'title' => 'employee_designation_history_edit',
            ],
            [
                'id'    => 173,
                'title' => 'employee_designation_history_show',
            ],
            [
                'id'    => 174,
                'title' => 'employee_designation_history_delete',
            ],
            [
                'id'    => 175,
                'title' => 'employee_designation_history_access',
            ],
            [
                'id'    => 176,
                'title' => 'employee_to_designation_create',
            ],
            [
                'id'    => 177,
                'title' => 'employee_to_designation_edit',
            ],
            [
                'id'    => 178,
                'title' => 'employee_to_designation_show',
            ],
            [
                'id'    => 179,
                'title' => 'employee_to_designation_delete',
            ],
            [
                'id'    => 180,
                'title' => 'employee_to_designation_access',
            ],
            [
                'id'    => 181,
                'title' => 'account_access',
            ],
            [
                'id'    => 182,
                'title' => 'acquittance_create',
            ],
            [
                'id'    => 183,
                'title' => 'acquittance_edit',
            ],
            [
                'id'    => 184,
                'title' => 'acquittance_show',
            ],
            [
                'id'    => 185,
                'title' => 'acquittance_delete',
            ],
            [
                'id'    => 186,
                'title' => 'acquittance_access',
            ],
            [
                'id'    => 187,
                'title' => 'employee_to_acquittance_create',
            ],
            [
                'id'    => 188,
                'title' => 'employee_to_acquittance_edit',
            ],
            [
                'id'    => 189,
                'title' => 'employee_to_acquittance_show',
            ],
            [
                'id'    => 190,
                'title' => 'employee_to_acquittance_delete',
            ],
            [
                'id'    => 191,
                'title' => 'employee_to_acquittance_access',
            ],
            [
                'id'    => 192,
                'title' => 'ddo_create',
            ],
            [
                'id'    => 193,
                'title' => 'ddo_edit',
            ],
            [
                'id'    => 194,
                'title' => 'ddo_show',
            ],
            [
                'id'    => 195,
                'title' => 'ddo_delete',
            ],
            [
                'id'    => 196,
                'title' => 'ddo_access',
            ],
            [
                'id'    => 197,
                'title' => 'shift_management_access',
            ],
            [
                'id'    => 198,
                'title' => 'shift_create',
            ],
            [
                'id'    => 199,
                'title' => 'shift_edit',
            ],
            [
                'id'    => 200,
                'title' => 'shift_show',
            ],
            [
                'id'    => 201,
                'title' => 'shift_delete',
            ],
            [
                'id'    => 202,
                'title' => 'shift_access',
            ],
            [
                'id'    => 203,
                'title' => 'employee_to_shift_create',
            ],
            [
                'id'    => 204,
                'title' => 'employee_to_shift_edit',
            ],
            [
                'id'    => 205,
                'title' => 'employee_to_shift_show',
            ],
            [
                'id'    => 206,
                'title' => 'employee_to_shift_delete',
            ],
            [
                'id'    => 207,
                'title' => 'employee_to_shift_access',
            ],
            [
                'id'    => 208,
                'title' => 'td_create',
            ],
            [
                'id'    => 209,
                'title' => 'td_edit',
            ],
            [
                'id'    => 210,
                'title' => 'td_show',
            ],
            [
                'id'    => 211,
                'title' => 'td_delete',
            ],
            [
                'id'    => 212,
                'title' => 'td_access',
            ],
            [
                'id'    => 213,
                'title' => 'tax_entry_create',
            ],
            [
                'id'    => 214,
                'title' => 'tax_entry_edit',
            ],
            [
                'id'    => 215,
                'title' => 'tax_entry_show',
            ],
            [
                'id'    => 216,
                'title' => 'tax_entry_delete',
            ],
            [
                'id'    => 217,
                'title' => 'tax_entry_access',
            ],
            [
                'id'    => 218,
                'title' => 'punching_create',
            ],
            [
                'id'    => 219,
                'title' => 'punching_edit',
            ],
            [
                'id'    => 220,
                'title' => 'punching_show',
            ],
            [
                'id'    => 221,
                'title' => 'punching_access',
            ],
            [
                'id'    => 222,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
