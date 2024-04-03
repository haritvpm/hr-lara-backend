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
                'title' => 'punching_register_create',
            ],
            [
                'id'    => 77,
                'title' => 'punching_register_edit',
            ],
            [
                'id'    => 78,
                'title' => 'punching_register_show',
            ],
            [
                'id'    => 79,
                'title' => 'punching_register_access',
            ],
            [
                'id'    => 80,
                'title' => 'punching_device_create',
            ],
            [
                'id'    => 81,
                'title' => 'punching_device_edit',
            ],
            [
                'id'    => 82,
                'title' => 'punching_device_show',
            ],
            [
                'id'    => 83,
                'title' => 'punching_device_delete',
            ],
            [
                'id'    => 84,
                'title' => 'punching_device_access',
            ],
            [
                'id'    => 85,
                'title' => 'assembly_related_access',
            ],
            [
                'id'    => 86,
                'title' => 'exemption_create',
            ],
            [
                'id'    => 87,
                'title' => 'exemption_edit',
            ],
            [
                'id'    => 88,
                'title' => 'exemption_show',
            ],
            [
                'id'    => 89,
                'title' => 'exemption_delete',
            ],
            [
                'id'    => 90,
                'title' => 'exemption_access',
            ],
            [
                'id'    => 91,
                'title' => 'seniority_create',
            ],
            [
                'id'    => 92,
                'title' => 'seniority_edit',
            ],
            [
                'id'    => 93,
                'title' => 'seniority_show',
            ],
            [
                'id'    => 94,
                'title' => 'seniority_delete',
            ],
            [
                'id'    => 95,
                'title' => 'seniority_access',
            ],
            [
                'id'    => 96,
                'title' => 'dept_designation_create',
            ],
            [
                'id'    => 97,
                'title' => 'dept_designation_edit',
            ],
            [
                'id'    => 98,
                'title' => 'dept_designation_show',
            ],
            [
                'id'    => 99,
                'title' => 'dept_designation_delete',
            ],
            [
                'id'    => 100,
                'title' => 'dept_designation_access',
            ],
            [
                'id'    => 101,
                'title' => 'dept_employee_create',
            ],
            [
                'id'    => 102,
                'title' => 'dept_employee_edit',
            ],
            [
                'id'    => 103,
                'title' => 'dept_employee_show',
            ],
            [
                'id'    => 104,
                'title' => 'dept_employee_delete',
            ],
            [
                'id'    => 105,
                'title' => 'dept_employee_access',
            ],
            [
                'id'    => 106,
                'title' => 'ot_form_create',
            ],
            [
                'id'    => 107,
                'title' => 'ot_form_edit',
            ],
            [
                'id'    => 108,
                'title' => 'ot_form_show',
            ],
            [
                'id'    => 109,
                'title' => 'ot_form_delete',
            ],
            [
                'id'    => 110,
                'title' => 'ot_form_access',
            ],
            [
                'id'    => 111,
                'title' => 'ot_form_other_create',
            ],
            [
                'id'    => 112,
                'title' => 'ot_form_other_edit',
            ],
            [
                'id'    => 113,
                'title' => 'ot_form_other_show',
            ],
            [
                'id'    => 114,
                'title' => 'ot_form_other_delete',
            ],
            [
                'id'    => 115,
                'title' => 'ot_form_other_access',
            ],
            [
                'id'    => 116,
                'title' => 'overtime_create',
            ],
            [
                'id'    => 117,
                'title' => 'overtime_edit',
            ],
            [
                'id'    => 118,
                'title' => 'overtime_show',
            ],
            [
                'id'    => 119,
                'title' => 'overtime_delete',
            ],
            [
                'id'    => 120,
                'title' => 'overtime_access',
            ],
            [
                'id'    => 121,
                'title' => 'overtime_other_create',
            ],
            [
                'id'    => 122,
                'title' => 'overtime_other_edit',
            ],
            [
                'id'    => 123,
                'title' => 'overtime_other_show',
            ],
            [
                'id'    => 124,
                'title' => 'overtime_other_delete',
            ],
            [
                'id'    => 125,
                'title' => 'overtime_other_access',
            ],
            [
                'id'    => 126,
                'title' => 'overtime_sitting_create',
            ],
            [
                'id'    => 127,
                'title' => 'overtime_sitting_edit',
            ],
            [
                'id'    => 128,
                'title' => 'overtime_sitting_show',
            ],
            [
                'id'    => 129,
                'title' => 'overtime_sitting_delete',
            ],
            [
                'id'    => 130,
                'title' => 'overtime_sitting_access',
            ],
            [
                'id'    => 131,
                'title' => 'ot_routing_create',
            ],
            [
                'id'    => 132,
                'title' => 'ot_routing_edit',
            ],
            [
                'id'    => 133,
                'title' => 'ot_routing_show',
            ],
            [
                'id'    => 134,
                'title' => 'ot_routing_delete',
            ],
            [
                'id'    => 135,
                'title' => 'ot_routing_access',
            ],
            [
                'id'    => 136,
                'title' => 'attendance_routing_create',
            ],
            [
                'id'    => 137,
                'title' => 'attendance_routing_edit',
            ],
            [
                'id'    => 138,
                'title' => 'attendance_routing_show',
            ],
            [
                'id'    => 139,
                'title' => 'attendance_routing_delete',
            ],
            [
                'id'    => 140,
                'title' => 'attendance_routing_access',
            ],
            [
                'id'    => 141,
                'title' => 'office_location_create',
            ],
            [
                'id'    => 142,
                'title' => 'office_location_edit',
            ],
            [
                'id'    => 143,
                'title' => 'office_location_show',
            ],
            [
                'id'    => 144,
                'title' => 'office_location_access',
            ],
            [
                'id'    => 145,
                'title' => 'employee_seat_history_create',
            ],
            [
                'id'    => 146,
                'title' => 'employee_seat_history_edit',
            ],
            [
                'id'    => 147,
                'title' => 'employee_seat_history_show',
            ],
            [
                'id'    => 148,
                'title' => 'employee_seat_history_delete',
            ],
            [
                'id'    => 149,
                'title' => 'employee_seat_history_access',
            ],
            [
                'id'    => 150,
                'title' => 'employee_section_history_create',
            ],
            [
                'id'    => 151,
                'title' => 'employee_section_history_edit',
            ],
            [
                'id'    => 152,
                'title' => 'employee_section_history_show',
            ],
            [
                'id'    => 153,
                'title' => 'employee_section_history_delete',
            ],
            [
                'id'    => 154,
                'title' => 'employee_section_history_access',
            ],
            [
                'id'    => 155,
                'title' => 'employee_to_seat_create',
            ],
            [
                'id'    => 156,
                'title' => 'employee_to_seat_edit',
            ],
            [
                'id'    => 157,
                'title' => 'employee_to_seat_show',
            ],
            [
                'id'    => 158,
                'title' => 'employee_to_seat_delete',
            ],
            [
                'id'    => 159,
                'title' => 'employee_to_seat_access',
            ],
            [
                'id'    => 160,
                'title' => 'employee_to_section_create',
            ],
            [
                'id'    => 161,
                'title' => 'employee_to_section_edit',
            ],
            [
                'id'    => 162,
                'title' => 'employee_to_section_show',
            ],
            [
                'id'    => 163,
                'title' => 'employee_to_section_delete',
            ],
            [
                'id'    => 164,
                'title' => 'employee_to_section_access',
            ],
            [
                'id'    => 165,
                'title' => 'employee_detail_create',
            ],
            [
                'id'    => 166,
                'title' => 'employee_detail_edit',
            ],
            [
                'id'    => 167,
                'title' => 'employee_detail_show',
            ],
            [
                'id'    => 168,
                'title' => 'employee_detail_delete',
            ],
            [
                'id'    => 169,
                'title' => 'employee_detail_access',
            ],
            [
                'id'    => 170,
                'title' => 'employee_ot_data_create',
            ],
            [
                'id'    => 171,
                'title' => 'employee_ot_data_edit',
            ],
            [
                'id'    => 172,
                'title' => 'employee_ot_data_show',
            ],
            [
                'id'    => 173,
                'title' => 'employee_ot_data_delete',
            ],
            [
                'id'    => 174,
                'title' => 'employee_ot_data_access',
            ],
            [
                'id'    => 175,
                'title' => 'employee_designation_history_create',
            ],
            [
                'id'    => 176,
                'title' => 'employee_designation_history_edit',
            ],
            [
                'id'    => 177,
                'title' => 'employee_designation_history_show',
            ],
            [
                'id'    => 178,
                'title' => 'employee_designation_history_delete',
            ],
            [
                'id'    => 179,
                'title' => 'employee_designation_history_access',
            ],
            [
                'id'    => 180,
                'title' => 'employee_to_designation_create',
            ],
            [
                'id'    => 181,
                'title' => 'employee_to_designation_edit',
            ],
            [
                'id'    => 182,
                'title' => 'employee_to_designation_show',
            ],
            [
                'id'    => 183,
                'title' => 'employee_to_designation_delete',
            ],
            [
                'id'    => 184,
                'title' => 'employee_to_designation_access',
            ],
            [
                'id'    => 185,
                'title' => 'employee_status_create',
            ],
            [
                'id'    => 186,
                'title' => 'employee_status_edit',
            ],
            [
                'id'    => 187,
                'title' => 'employee_status_show',
            ],
            [
                'id'    => 188,
                'title' => 'employee_status_delete',
            ],
            [
                'id'    => 189,
                'title' => 'employee_status_access',
            ],
            [
                'id'    => 190,
                'title' => 'account_access',
            ],
            [
                'id'    => 191,
                'title' => 'acquittance_create',
            ],
            [
                'id'    => 192,
                'title' => 'acquittance_edit',
            ],
            [
                'id'    => 193,
                'title' => 'acquittance_show',
            ],
            [
                'id'    => 194,
                'title' => 'acquittance_delete',
            ],
            [
                'id'    => 195,
                'title' => 'acquittance_access',
            ],
            [
                'id'    => 196,
                'title' => 'employee_to_acquittance_create',
            ],
            [
                'id'    => 197,
                'title' => 'employee_to_acquittance_edit',
            ],
            [
                'id'    => 198,
                'title' => 'employee_to_acquittance_show',
            ],
            [
                'id'    => 199,
                'title' => 'employee_to_acquittance_delete',
            ],
            [
                'id'    => 200,
                'title' => 'employee_to_acquittance_access',
            ],
            [
                'id'    => 201,
                'title' => 'ddo_create',
            ],
            [
                'id'    => 202,
                'title' => 'ddo_edit',
            ],
            [
                'id'    => 203,
                'title' => 'ddo_show',
            ],
            [
                'id'    => 204,
                'title' => 'ddo_delete',
            ],
            [
                'id'    => 205,
                'title' => 'ddo_access',
            ],
            [
                'id'    => 206,
                'title' => 'shift_management_access',
            ],
            [
                'id'    => 207,
                'title' => 'shift_create',
            ],
            [
                'id'    => 208,
                'title' => 'shift_edit',
            ],
            [
                'id'    => 209,
                'title' => 'shift_show',
            ],
            [
                'id'    => 210,
                'title' => 'shift_delete',
            ],
            [
                'id'    => 211,
                'title' => 'shift_access',
            ],
            [
                'id'    => 212,
                'title' => 'employee_to_shift_create',
            ],
            [
                'id'    => 213,
                'title' => 'employee_to_shift_edit',
            ],
            [
                'id'    => 214,
                'title' => 'employee_to_shift_show',
            ],
            [
                'id'    => 215,
                'title' => 'employee_to_shift_delete',
            ],
            [
                'id'    => 216,
                'title' => 'employee_to_shift_access',
            ],
            [
                'id'    => 217,
                'title' => 'td_create',
            ],
            [
                'id'    => 218,
                'title' => 'td_edit',
            ],
            [
                'id'    => 219,
                'title' => 'td_show',
            ],
            [
                'id'    => 220,
                'title' => 'td_delete',
            ],
            [
                'id'    => 221,
                'title' => 'td_access',
            ],
            [
                'id'    => 222,
                'title' => 'tax_entry_create',
            ],
            [
                'id'    => 223,
                'title' => 'tax_entry_edit',
            ],
            [
                'id'    => 224,
                'title' => 'tax_entry_show',
            ],
            [
                'id'    => 225,
                'title' => 'tax_entry_delete',
            ],
            [
                'id'    => 226,
                'title' => 'tax_entry_access',
            ],
            [
                'id'    => 227,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
