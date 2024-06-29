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
                'title' => 'success_punching_show',
            ],
            [
                'id'    => 61,
                'title' => 'success_punching_delete',
            ],
            [
                'id'    => 62,
                'title' => 'success_punching_access',
            ],
            [
                'id'    => 63,
                'title' => 'punching_device_create',
            ],
            [
                'id'    => 64,
                'title' => 'punching_device_edit',
            ],
            [
                'id'    => 65,
                'title' => 'punching_device_show',
            ],
            [
                'id'    => 66,
                'title' => 'punching_device_delete',
            ],
            [
                'id'    => 67,
                'title' => 'punching_device_access',
            ],
            [
                'id'    => 68,
                'title' => 'assembly_related_access',
            ],
            [
                'id'    => 69,
                'title' => 'exemption_create',
            ],
            [
                'id'    => 70,
                'title' => 'exemption_edit',
            ],
            [
                'id'    => 71,
                'title' => 'exemption_show',
            ],
            [
                'id'    => 72,
                'title' => 'exemption_delete',
            ],
            [
                'id'    => 73,
                'title' => 'exemption_access',
            ],
            [
                'id'    => 74,
                'title' => 'seniority_create',
            ],
            [
                'id'    => 75,
                'title' => 'seniority_edit',
            ],
            [
                'id'    => 76,
                'title' => 'seniority_show',
            ],
            [
                'id'    => 77,
                'title' => 'seniority_delete',
            ],
            [
                'id'    => 78,
                'title' => 'seniority_access',
            ],
            [
                'id'    => 79,
                'title' => 'dept_designation_create',
            ],
            [
                'id'    => 80,
                'title' => 'dept_designation_edit',
            ],
            [
                'id'    => 81,
                'title' => 'dept_designation_show',
            ],
            [
                'id'    => 82,
                'title' => 'dept_designation_delete',
            ],
            [
                'id'    => 83,
                'title' => 'dept_designation_access',
            ],
            [
                'id'    => 84,
                'title' => 'dept_employee_create',
            ],
            [
                'id'    => 85,
                'title' => 'dept_employee_edit',
            ],
            [
                'id'    => 86,
                'title' => 'dept_employee_show',
            ],
            [
                'id'    => 87,
                'title' => 'dept_employee_delete',
            ],
            [
                'id'    => 88,
                'title' => 'dept_employee_access',
            ],
            [
                'id'    => 89,
                'title' => 'ot_form_create',
            ],
            [
                'id'    => 90,
                'title' => 'ot_form_edit',
            ],
            [
                'id'    => 91,
                'title' => 'ot_form_show',
            ],
            [
                'id'    => 92,
                'title' => 'ot_form_delete',
            ],
            [
                'id'    => 93,
                'title' => 'ot_form_access',
            ],
            [
                'id'    => 94,
                'title' => 'ot_form_other_create',
            ],
            [
                'id'    => 95,
                'title' => 'ot_form_other_edit',
            ],
            [
                'id'    => 96,
                'title' => 'ot_form_other_show',
            ],
            [
                'id'    => 97,
                'title' => 'ot_form_other_delete',
            ],
            [
                'id'    => 98,
                'title' => 'ot_form_other_access',
            ],
            [
                'id'    => 99,
                'title' => 'overtime_create',
            ],
            [
                'id'    => 100,
                'title' => 'overtime_edit',
            ],
            [
                'id'    => 101,
                'title' => 'overtime_show',
            ],
            [
                'id'    => 102,
                'title' => 'overtime_delete',
            ],
            [
                'id'    => 103,
                'title' => 'overtime_access',
            ],
            [
                'id'    => 104,
                'title' => 'overtime_other_create',
            ],
            [
                'id'    => 105,
                'title' => 'overtime_other_edit',
            ],
            [
                'id'    => 106,
                'title' => 'overtime_other_show',
            ],
            [
                'id'    => 107,
                'title' => 'overtime_other_delete',
            ],
            [
                'id'    => 108,
                'title' => 'overtime_other_access',
            ],
            [
                'id'    => 109,
                'title' => 'overtime_sitting_access',
            ],
            [
                'id'    => 110,
                'title' => 'ot_routing_create',
            ],
            [
                'id'    => 111,
                'title' => 'ot_routing_edit',
            ],
            [
                'id'    => 112,
                'title' => 'ot_routing_show',
            ],
            [
                'id'    => 113,
                'title' => 'ot_routing_delete',
            ],
            [
                'id'    => 114,
                'title' => 'ot_routing_access',
            ],
            [
                'id'    => 115,
                'title' => 'attendance_routing_create',
            ],
            [
                'id'    => 116,
                'title' => 'attendance_routing_edit',
            ],
            [
                'id'    => 117,
                'title' => 'attendance_routing_show',
            ],
            [
                'id'    => 118,
                'title' => 'attendance_routing_delete',
            ],
            [
                'id'    => 119,
                'title' => 'attendance_routing_access',
            ],
            [
                'id'    => 120,
                'title' => 'office_location_create',
            ],
            [
                'id'    => 121,
                'title' => 'office_location_edit',
            ],
            [
                'id'    => 122,
                'title' => 'office_location_show',
            ],
            [
                'id'    => 123,
                'title' => 'office_location_access',
            ],
            [
                'id'    => 124,
                'title' => 'employee_to_seat_create',
            ],
            [
                'id'    => 125,
                'title' => 'employee_to_seat_edit',
            ],
            [
                'id'    => 126,
                'title' => 'employee_to_seat_show',
            ],
            [
                'id'    => 127,
                'title' => 'employee_to_seat_delete',
            ],
            [
                'id'    => 128,
                'title' => 'employee_to_seat_access',
            ],
            [
                'id'    => 129,
                'title' => 'employee_to_section_create',
            ],
            [
                'id'    => 130,
                'title' => 'employee_to_section_edit',
            ],
            [
                'id'    => 131,
                'title' => 'employee_to_section_show',
            ],
            [
                'id'    => 132,
                'title' => 'employee_to_section_delete',
            ],
            [
                'id'    => 133,
                'title' => 'employee_to_section_access',
            ],
            [
                'id'    => 134,
                'title' => 'employee_to_designation_create',
            ],
            [
                'id'    => 135,
                'title' => 'employee_to_designation_edit',
            ],
            [
                'id'    => 136,
                'title' => 'employee_to_designation_show',
            ],
            [
                'id'    => 137,
                'title' => 'employee_to_designation_delete',
            ],
            [
                'id'    => 138,
                'title' => 'employee_to_designation_access',
            ],
            [
                'id'    => 139,
                'title' => 'account_access',
            ],
            [
                'id'    => 140,
                'title' => 'acquittance_create',
            ],
            [
                'id'    => 141,
                'title' => 'acquittance_edit',
            ],
            [
                'id'    => 142,
                'title' => 'acquittance_show',
            ],
            [
                'id'    => 143,
                'title' => 'acquittance_delete',
            ],
            [
                'id'    => 144,
                'title' => 'acquittance_access',
            ],
            [
                'id'    => 145,
                'title' => 'employee_to_acquittance_create',
            ],
            [
                'id'    => 146,
                'title' => 'employee_to_acquittance_edit',
            ],
            [
                'id'    => 147,
                'title' => 'employee_to_acquittance_show',
            ],
            [
                'id'    => 148,
                'title' => 'employee_to_acquittance_delete',
            ],
            [
                'id'    => 149,
                'title' => 'employee_to_acquittance_access',
            ],
            [
                'id'    => 150,
                'title' => 'ddo_create',
            ],
            [
                'id'    => 151,
                'title' => 'ddo_edit',
            ],
            [
                'id'    => 152,
                'title' => 'ddo_show',
            ],
            [
                'id'    => 153,
                'title' => 'ddo_delete',
            ],
            [
                'id'    => 154,
                'title' => 'ddo_access',
            ],
            [
                'id'    => 155,
                'title' => 'shift_create',
            ],
            [
                'id'    => 156,
                'title' => 'shift_edit',
            ],
            [
                'id'    => 157,
                'title' => 'shift_show',
            ],
            [
                'id'    => 158,
                'title' => 'shift_delete',
            ],
            [
                'id'    => 159,
                'title' => 'shift_access',
            ],
            [
                'id'    => 160,
                'title' => 'employee_to_shift_create',
            ],
            [
                'id'    => 161,
                'title' => 'employee_to_shift_edit',
            ],
            [
                'id'    => 162,
                'title' => 'employee_to_shift_show',
            ],
            [
                'id'    => 163,
                'title' => 'employee_to_shift_delete',
            ],
            [
                'id'    => 164,
                'title' => 'employee_to_shift_access',
            ],
            [
                'id'    => 165,
                'title' => 'td_create',
            ],
            [
                'id'    => 166,
                'title' => 'td_edit',
            ],
            [
                'id'    => 167,
                'title' => 'td_show',
            ],
            [
                'id'    => 168,
                'title' => 'td_delete',
            ],
            [
                'id'    => 169,
                'title' => 'td_access',
            ],
            [
                'id'    => 170,
                'title' => 'tax_entry_create',
            ],
            [
                'id'    => 171,
                'title' => 'tax_entry_edit',
            ],
            [
                'id'    => 172,
                'title' => 'tax_entry_show',
            ],
            [
                'id'    => 173,
                'title' => 'tax_entry_delete',
            ],
            [
                'id'    => 174,
                'title' => 'tax_entry_access',
            ],
            [
                'id'    => 175,
                'title' => 'punching_edit',
            ],
            [
                'id'    => 176,
                'title' => 'punching_show',
            ],
            [
                'id'    => 177,
                'title' => 'punching_access',
            ],
            [
                'id'    => 178,
                'title' => 'assembly_session_create',
            ],
            [
                'id'    => 179,
                'title' => 'assembly_session_edit',
            ],
            [
                'id'    => 180,
                'title' => 'assembly_session_show',
            ],
            [
                'id'    => 181,
                'title' => 'assembly_session_delete',
            ],
            [
                'id'    => 182,
                'title' => 'assembly_session_access',
            ],
            [
                'id'    => 183,
                'title' => 'leaf_edit',
            ],
            [
                'id'    => 184,
                'title' => 'leaf_show',
            ],
            [
                'id'    => 185,
                'title' => 'leaf_delete',
            ],
            [
                'id'    => 186,
                'title' => 'leaf_access',
            ],
            [
                'id'    => 187,
                'title' => 'time_management_access',
            ],
            [
                'id'    => 188,
                'title' => 'office_time_create',
            ],
            [
                'id'    => 189,
                'title' => 'office_time_edit',
            ],
            [
                'id'    => 190,
                'title' => 'office_time_show',
            ],
            [
                'id'    => 191,
                'title' => 'office_time_delete',
            ],
            [
                'id'    => 192,
                'title' => 'office_time_access',
            ],
            [
                'id'    => 193,
                'title' => 'employee_ot_setting_create',
            ],
            [
                'id'    => 194,
                'title' => 'employee_ot_setting_edit',
            ],
            [
                'id'    => 195,
                'title' => 'employee_ot_setting_show',
            ],
            [
                'id'    => 196,
                'title' => 'employee_ot_setting_delete',
            ],
            [
                'id'    => 197,
                'title' => 'employee_ot_setting_access',
            ],
            [
                'id'    => 198,
                'title' => 'monthly_attendance_edit',
            ],
            [
                'id'    => 199,
                'title' => 'monthly_attendance_show',
            ],
            [
                'id'    => 200,
                'title' => 'monthly_attendance_delete',
            ],
            [
                'id'    => 201,
                'title' => 'monthly_attendance_access',
            ],
            [
                'id'    => 202,
                'title' => 'yearly_attendance_edit',
            ],
            [
                'id'    => 203,
                'title' => 'yearly_attendance_show',
            ],
            [
                'id'    => 204,
                'title' => 'yearly_attendance_delete',
            ],
            [
                'id'    => 205,
                'title' => 'yearly_attendance_access',
            ],
            [
                'id'    => 206,
                'title' => 'setting_create',
            ],
            [
                'id'    => 207,
                'title' => 'setting_edit',
            ],
            [
                'id'    => 208,
                'title' => 'setting_show',
            ],
            [
                'id'    => 209,
                'title' => 'setting_delete',
            ],
            [
                'id'    => 210,
                'title' => 'setting_access',
            ],
            [
                'id'    => 211,
                'title' => 'employee_extra_create',
            ],
            [
                'id'    => 212,
                'title' => 'employee_extra_edit',
            ],
            [
                'id'    => 213,
                'title' => 'employee_extra_show',
            ],
            [
                'id'    => 214,
                'title' => 'employee_extra_delete',
            ],
            [
                'id'    => 215,
                'title' => 'employee_extra_access',
            ],
            [
                'id'    => 216,
                'title' => 'grace_time_create',
            ],
            [
                'id'    => 217,
                'title' => 'grace_time_edit',
            ],
            [
                'id'    => 218,
                'title' => 'grace_time_delete',
            ],
            [
                'id'    => 219,
                'title' => 'grace_time_access',
            ],
            [
                'id'    => 220,
                'title' => 'compen_granted_create',
            ],
            [
                'id'    => 221,
                'title' => 'compen_granted_edit',
            ],
            [
                'id'    => 222,
                'title' => 'compen_granted_delete',
            ],
            [
                'id'    => 223,
                'title' => 'compen_granted_access',
            ],
            [
                'id'    => 224,
                'title' => 'database_access',
            ],
            [
                'id'    => 225,
                'title' => 'casual_leaf_access',
            ],
            [
                'id'    => 226,
                'title' => 'employee_to_flexi_create',
            ],
            [
                'id'    => 227,
                'title' => 'employee_to_flexi_edit',
            ],
            [
                'id'    => 228,
                'title' => 'employee_to_flexi_show',
            ],
            [
                'id'    => 229,
                'title' => 'employee_to_flexi_delete',
            ],
            [
                'id'    => 230,
                'title' => 'employee_to_flexi_access',
            ],
            [
                'id'    => 231,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert(
            $permissions
        );
    }
}
