<?php

class PermissionsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('permissions')->delete();
        
		\DB::table('permissions')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'admin_view_all',
				'display_name' => 'View All Admin',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'admins_view_all',
				'display_name' => 'View All Admins',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			2 => 
			array (
				'id' => 3,
				'name' => 'admins_view_owner',
				'display_name' => 'View Owner Admins',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			3 => 
			array (
				'id' => 4,
				'name' => 'admins_create_owner',
				'display_name' => 'Create Owner Admins',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			4 => 
			array (
				'id' => 5,
				'name' => 'admins_edit_all',
				'display_name' => 'Edit All Admins',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			5 => 
			array (
				'id' => 6,
				'name' => 'admins_edit_owner',
				'display_name' => 'Edit Owner Admins',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			6 => 
			array (
				'id' => 7,
				'name' => 'admins_delete_all',
				'display_name' => 'Delete All Admins',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			7 => 
			array (
				'id' => 8,
				'name' => 'admins_delete_owner',
				'display_name' => 'Delete Owner Admins',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			8 => 
			array (
				'id' => 9,
				'name' => 'banners_view_all',
				'display_name' => 'View All Banners',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			9 => 
			array (
				'id' => 10,
				'name' => 'banners_view_owner',
				'display_name' => 'View Owner Banners',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			10 => 
			array (
				'id' => 11,
				'name' => 'banners_create_owner',
				'display_name' => 'Create Owner Banners',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			11 => 
			array (
				'id' => 12,
				'name' => 'banners_edit_all',
				'display_name' => 'Edit All Banners',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			12 => 
			array (
				'id' => 13,
				'name' => 'banners_edit_owner',
				'display_name' => 'Edit Owner Banners',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			13 => 
			array (
				'id' => 14,
				'name' => 'banners_delete_all',
				'display_name' => 'Delete All Banners',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			14 => 
			array (
				'id' => 15,
				'name' => 'banners_delete_owner',
				'display_name' => 'Delete Owner Banners',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			15 => 
			array (
				'id' => 16,
				'name' => 'configures_view_all',
				'display_name' => 'View All Configures',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			16 => 
			array (
				'id' => 17,
				'name' => 'configures_view_owner',
				'display_name' => 'View Owner Configures',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			17 => 
			array (
				'id' => 18,
				'name' => 'configures_create_owner',
				'display_name' => 'Create Owner Configures',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			18 => 
			array (
				'id' => 19,
				'name' => 'configures_edit_all',
				'display_name' => 'Edit All Configures',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			19 => 
			array (
				'id' => 20,
				'name' => 'configures_edit_owner',
				'display_name' => 'Edit Owner Configures',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			20 => 
			array (
				'id' => 21,
				'name' => 'configures_delete_all',
				'display_name' => 'Delete All Configures',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			21 => 
			array (
				'id' => 22,
				'name' => 'configures_delete_owner',
				'display_name' => 'Delete Owner Configures',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			22 => 
			array (
				'id' => 23,
				'name' => 'contacts_view_all',
				'display_name' => 'View All Contacts',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			23 => 
			array (
				'id' => 24,
				'name' => 'contacts_view_owner',
				'display_name' => 'View Owner Contacts',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			24 => 
			array (
				'id' => 25,
				'name' => 'contacts_create_owner',
				'display_name' => 'Create Owner Contacts',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			25 => 
			array (
				'id' => 26,
				'name' => 'contacts_edit_all',
				'display_name' => 'Edit All Contacts',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			26 => 
			array (
				'id' => 27,
				'name' => 'contacts_edit_owner',
				'display_name' => 'Edit Owner Contacts',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			27 => 
			array (
				'id' => 28,
				'name' => 'contacts_delete_all',
				'display_name' => 'Delete All Contacts',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			28 => 
			array (
				'id' => 29,
				'name' => 'contacts_delete_owner',
				'display_name' => 'Delete Owner Contacts',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			29 => 
			array (
				'id' => 30,
				'name' => 'dashboards_view_all',
				'display_name' => 'View All Dashboards',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			30 => 
			array (
				'id' => 31,
				'name' => 'dashboards_view_owner',
				'display_name' => 'View Owner Dashboards',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			31 => 
			array (
				'id' => 32,
				'name' => 'dashboards_create_owner',
				'display_name' => 'Create Owner Dashboards',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			32 => 
			array (
				'id' => 33,
				'name' => 'dashboards_edit_all',
				'display_name' => 'Edit All Dashboards',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			33 => 
			array (
				'id' => 34,
				'name' => 'dashboards_edit_owner',
				'display_name' => 'Edit Owner Dashboards',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			34 => 
			array (
				'id' => 35,
				'name' => 'dashboards_delete_all',
				'display_name' => 'Delete All Dashboards',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			35 => 
			array (
				'id' => 36,
				'name' => 'dashboards_delete_owner',
				'display_name' => 'Delete Owner Dashboards',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			36 => 
			array (
				'id' => 37,
				'name' => 'emailtemplates_view_all',
				'display_name' => 'View All Emailtemplates',
				'created_at' => '2015-04-29 02:13:36',
				'updated_at' => '2015-04-29 02:13:36',
			),
			37 => 
			array (
				'id' => 38,
				'name' => 'emailtemplates_view_owner',
				'display_name' => 'View Owner Emailtemplates',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			38 => 
			array (
				'id' => 39,
				'name' => 'emailtemplates_create_owner',
				'display_name' => 'Create Owner Emailtemplates',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			39 => 
			array (
				'id' => 40,
				'name' => 'emailtemplates_edit_all',
				'display_name' => 'Edit All Emailtemplates',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			40 => 
			array (
				'id' => 41,
				'name' => 'emailtemplates_edit_owner',
				'display_name' => 'Edit Owner Emailtemplates',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			41 => 
			array (
				'id' => 42,
				'name' => 'emailtemplates_delete_all',
				'display_name' => 'Delete All Emailtemplates',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			42 => 
			array (
				'id' => 43,
				'name' => 'emailtemplates_delete_owner',
				'display_name' => 'Delete Owner Emailtemplates',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			43 => 
			array (
				'id' => 44,
				'name' => 'images_view_all',
				'display_name' => 'View All Images',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			44 => 
			array (
				'id' => 45,
				'name' => 'images_view_owner',
				'display_name' => 'View Owner Images',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			45 => 
			array (
				'id' => 46,
				'name' => 'images_create_owner',
				'display_name' => 'Create Owner Images',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			46 => 
			array (
				'id' => 47,
				'name' => 'images_edit_all',
				'display_name' => 'Edit All Images',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			47 => 
			array (
				'id' => 48,
				'name' => 'images_edit_owner',
				'display_name' => 'Edit Owner Images',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			48 => 
			array (
				'id' => 49,
				'name' => 'images_delete_all',
				'display_name' => 'Delete All Images',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			49 => 
			array (
				'id' => 50,
				'name' => 'images_delete_owner',
				'display_name' => 'Delete Owner Images',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			50 => 
			array (
				'id' => 51,
				'name' => 'menus_view_all',
				'display_name' => 'View All Menus',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			51 => 
			array (
				'id' => 52,
				'name' => 'menus_view_owner',
				'display_name' => 'View Owner Menus',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			52 => 
			array (
				'id' => 53,
				'name' => 'menus_create_owner',
				'display_name' => 'Create Owner Menus',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			53 => 
			array (
				'id' => 54,
				'name' => 'menus_edit_all',
				'display_name' => 'Edit All Menus',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			54 => 
			array (
				'id' => 55,
				'name' => 'menus_edit_owner',
				'display_name' => 'Edit Owner Menus',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			55 => 
			array (
				'id' => 56,
				'name' => 'menus_delete_all',
				'display_name' => 'Delete All Menus',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			56 => 
			array (
				'id' => 57,
				'name' => 'menus_delete_owner',
				'display_name' => 'Delete Owner Menus',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			57 => 
			array (
				'id' => 58,
				'name' => 'orders_view_all',
				'display_name' => 'View All Orders',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			58 => 
			array (
				'id' => 59,
				'name' => 'orders_view_owner',
				'display_name' => 'View Owner Orders',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			59 => 
			array (
				'id' => 60,
				'name' => 'orders_create_owner',
				'display_name' => 'Create Owner Orders',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			60 => 
			array (
				'id' => 61,
				'name' => 'orders_edit_all',
				'display_name' => 'Edit All Orders',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			61 => 
			array (
				'id' => 62,
				'name' => 'orders_edit_owner',
				'display_name' => 'Edit Owner Orders',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			62 => 
			array (
				'id' => 63,
				'name' => 'orders_delete_all',
				'display_name' => 'Delete All Orders',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			63 => 
			array (
				'id' => 64,
				'name' => 'orders_delete_owner',
				'display_name' => 'Delete Owner Orders',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			64 => 
			array (
				'id' => 65,
				'name' => 'pages_view_all',
				'display_name' => 'View All Pages',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			65 => 
			array (
				'id' => 66,
				'name' => 'pages_view_owner',
				'display_name' => 'View Owner Pages',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			66 => 
			array (
				'id' => 67,
				'name' => 'pages_create_owner',
				'display_name' => 'Create Owner Pages',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			67 => 
			array (
				'id' => 68,
				'name' => 'pages_edit_all',
				'display_name' => 'Edit All Pages',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			68 => 
			array (
				'id' => 69,
				'name' => 'pages_edit_owner',
				'display_name' => 'Edit Owner Pages',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			69 => 
			array (
				'id' => 70,
				'name' => 'pages_delete_all',
				'display_name' => 'Delete All Pages',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			70 => 
			array (
				'id' => 71,
				'name' => 'pages_delete_owner',
				'display_name' => 'Delete Owner Pages',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			71 => 
			array (
				'id' => 72,
				'name' => 'roles_view_all',
				'display_name' => 'View All Roles',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			72 => 
			array (
				'id' => 73,
				'name' => 'roles_view_owner',
				'display_name' => 'View Owner Roles',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			73 => 
			array (
				'id' => 74,
				'name' => 'roles_create_owner',
				'display_name' => 'Create Owner Roles',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			74 => 
			array (
				'id' => 75,
				'name' => 'roles_edit_all',
				'display_name' => 'Edit All Roles',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			75 => 
			array (
				'id' => 76,
				'name' => 'roles_edit_owner',
				'display_name' => 'Edit Owner Roles',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			76 => 
			array (
				'id' => 77,
				'name' => 'roles_delete_all',
				'display_name' => 'Delete All Roles',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			77 => 
			array (
				'id' => 78,
				'name' => 'roles_delete_owner',
				'display_name' => 'Delete Owner Roles',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			78 => 
			array (
				'id' => 79,
				'name' => 'users_view_all',
				'display_name' => 'View All Users',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			79 => 
			array (
				'id' => 80,
				'name' => 'users_view_owner',
				'display_name' => 'View Owner Users',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			80 => 
			array (
				'id' => 81,
				'name' => 'users_create_owner',
				'display_name' => 'Create Owner Users',
				'created_at' => '2015-04-29 02:13:37',
				'updated_at' => '2015-04-29 02:13:37',
			),
			81 => 
			array (
				'id' => 82,
				'name' => 'users_edit_all',
				'display_name' => 'Edit All Users',
				'created_at' => '2015-04-29 02:13:38',
				'updated_at' => '2015-04-29 02:13:38',
			),
			82 => 
			array (
				'id' => 83,
				'name' => 'users_edit_owner',
				'display_name' => 'Edit Owner Users',
				'created_at' => '2015-04-29 02:13:38',
				'updated_at' => '2015-04-29 02:13:38',
			),
			83 => 
			array (
				'id' => 84,
				'name' => 'users_delete_all',
				'display_name' => 'Delete All Users',
				'created_at' => '2015-04-29 02:13:38',
				'updated_at' => '2015-04-29 02:13:38',
			),
			84 => 
			array (
				'id' => 85,
				'name' => 'users_delete_owner',
				'display_name' => 'Delete Owner Users',
				'created_at' => '2015-04-29 02:13:38',
				'updated_at' => '2015-04-29 02:13:38',
			),
			85 => 
			array (
				'id' => 86,
				'name' => 'menusfrontend_view_all',
				'display_name' => 'View All Menusfrontend',
				'created_at' => '2015-04-29 02:13:38',
				'updated_at' => '2015-04-29 02:13:38',
			),
			86 => 
			array (
				'id' => 87,
				'name' => 'menusfrontend_create_all',
				'display_name' => 'Create All Menusfrontend',
				'created_at' => '2015-04-29 02:13:38',
				'updated_at' => '2015-04-29 02:13:38',
			),
			87 => 
			array (
				'id' => 88,
				'name' => 'menusfrontend_edit_all',
				'display_name' => 'Edit All Menusfrontend',
				'created_at' => '2015-04-29 02:13:38',
				'updated_at' => '2015-04-29 02:13:38',
			),
			88 => 
			array (
				'id' => 89,
				'name' => 'menusbackend_view_all',
				'display_name' => 'View All Menusbackend',
				'created_at' => '2015-04-29 02:13:38',
				'updated_at' => '2015-04-29 02:13:38',
			),
			89 => 
			array (
				'id' => 90,
				'name' => 'menusbackend_create_all',
				'display_name' => 'Create All Menusbackend',
				'created_at' => '2015-04-29 02:13:38',
				'updated_at' => '2015-04-29 02:13:38',
			),
			90 => 
			array (
				'id' => 91,
				'name' => 'menusbackend_edit_all',
				'display_name' => 'Edit All Menusbackend',
				'created_at' => '2015-04-29 02:13:38',
				'updated_at' => '2015-04-29 02:13:38',
			),
			91 => 
			array (
				'id' => 92,
				'name' => 'menusfrontend_delete_all',
				'display_name' => 'Delete All Menusfrontend',
				'created_at' => '2015-04-29 02:17:08',
				'updated_at' => '2015-04-29 02:17:08',
			),
			92 => 
			array (
				'id' => 93,
				'name' => 'menusbackend_delete_all',
				'display_name' => 'Delete All Menusbackend',
				'created_at' => '2015-04-29 02:17:08',
				'updated_at' => '2015-04-29 02:17:08',
			),
			93 => 
			array (
				'id' => 94,
				'name' => 'categories_view_all',
				'display_name' => 'View All Categories',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			94 => 
			array (
				'id' => 95,
				'name' => 'categories_view_owner',
				'display_name' => 'View Owner Categories',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			95 => 
			array (
				'id' => 96,
				'name' => 'categories_create_owner',
				'display_name' => 'Create Owner Categories',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			96 => 
			array (
				'id' => 97,
				'name' => 'categories_edit_all',
				'display_name' => 'Edit All Categories',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			97 => 
			array (
				'id' => 98,
				'name' => 'categories_edit_owner',
				'display_name' => 'Edit Owner Categories',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			98 => 
			array (
				'id' => 99,
				'name' => 'categories_delete_all',
				'display_name' => 'Delete All Categories',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			99 => 
			array (
				'id' => 100,
				'name' => 'categories_delete_owner',
				'display_name' => 'Delete Owner Categories',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			100 => 
			array (
				'id' => 101,
				'name' => 'types_view_all',
				'display_name' => 'View All Types',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			101 => 
			array (
				'id' => 102,
				'name' => 'types_view_owner',
				'display_name' => 'View Owner Types',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			102 => 
			array (
				'id' => 103,
				'name' => 'types_create_owner',
				'display_name' => 'Create Owner Types',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			103 => 
			array (
				'id' => 104,
				'name' => 'types_edit_all',
				'display_name' => 'Edit All Types',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			104 => 
			array (
				'id' => 105,
				'name' => 'types_edit_owner',
				'display_name' => 'Edit Owner Types',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			105 => 
			array (
				'id' => 106,
				'name' => 'types_delete_all',
				'display_name' => 'Delete All Types',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			106 => 
			array (
				'id' => 107,
				'name' => 'types_delete_owner',
				'display_name' => 'Delete Owner Types',
				'created_at' => '2015-05-07 20:41:37',
				'updated_at' => '2015-05-07 20:41:37',
			),
			107 => 
			array (
				'id' => 108,
				'name' => 'collections_view_all',
				'display_name' => 'View All Collections',
				'created_at' => '2015-05-10 21:44:38',
				'updated_at' => '2015-05-10 21:44:38',
			),
			108 => 
			array (
				'id' => 109,
				'name' => 'collections_view_owner',
				'display_name' => 'View Owner Collections',
				'created_at' => '2015-05-10 21:44:38',
				'updated_at' => '2015-05-10 21:44:38',
			),
			109 => 
			array (
				'id' => 110,
				'name' => 'collections_create_owner',
				'display_name' => 'Create Owner Collections',
				'created_at' => '2015-05-10 21:44:38',
				'updated_at' => '2015-05-10 21:44:38',
			),
			110 => 
			array (
				'id' => 111,
				'name' => 'collections_edit_all',
				'display_name' => 'Edit All Collections',
				'created_at' => '2015-05-10 21:44:38',
				'updated_at' => '2015-05-10 21:44:38',
			),
			111 => 
			array (
				'id' => 112,
				'name' => 'collections_edit_owner',
				'display_name' => 'Edit Owner Collections',
				'created_at' => '2015-05-10 21:44:38',
				'updated_at' => '2015-05-10 21:44:38',
			),
			112 => 
			array (
				'id' => 113,
				'name' => 'collections_delete_all',
				'display_name' => 'Delete All Collections',
				'created_at' => '2015-05-10 21:44:38',
				'updated_at' => '2015-05-10 21:44:38',
			),
			113 => 
			array (
				'id' => 114,
				'name' => 'collections_delete_owner',
				'display_name' => 'Delete Owner Collections',
				'created_at' => '2015-05-10 21:44:38',
				'updated_at' => '2015-05-10 21:44:38',
			),
			114 => 
			array (
				'id' => 115,
				'name' => 'productcategories_view_all',
				'display_name' => 'View All Productcategories',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			115 => 
			array (
				'id' => 116,
				'name' => 'productcategories_view_owner',
				'display_name' => 'View Owner Productcategories',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			116 => 
			array (
				'id' => 117,
				'name' => 'productcategories_create_owner',
				'display_name' => 'Create Owner Productcategories',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			117 => 
			array (
				'id' => 118,
				'name' => 'productcategories_edit_all',
				'display_name' => 'Edit All Productcategories',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			118 => 
			array (
				'id' => 119,
				'name' => 'productcategories_edit_owner',
				'display_name' => 'Edit Owner Productcategories',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			119 => 
			array (
				'id' => 120,
				'name' => 'productcategories_delete_all',
				'display_name' => 'Delete All Productcategories',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			120 => 
			array (
				'id' => 121,
				'name' => 'productcategories_delete_owner',
				'display_name' => 'Delete Owner Productcategories',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			121 => 
			array (
				'id' => 122,
				'name' => 'productoptiongroups_view_all',
				'display_name' => 'View All Productoptiongroups',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			122 => 
			array (
				'id' => 123,
				'name' => 'productoptiongroups_view_owner',
				'display_name' => 'View Owner Productoptiongroups',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			123 => 
			array (
				'id' => 124,
				'name' => 'productoptiongroups_create_owner',
				'display_name' => 'Create Owner Productoptiongroups',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			124 => 
			array (
				'id' => 125,
				'name' => 'productoptiongroups_edit_all',
				'display_name' => 'Edit All Productoptiongroups',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			125 => 
			array (
				'id' => 126,
				'name' => 'productoptiongroups_edit_owner',
				'display_name' => 'Edit Owner Productoptiongroups',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			126 => 
			array (
				'id' => 127,
				'name' => 'productoptiongroups_delete_all',
				'display_name' => 'Delete All Productoptiongroups',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			127 => 
			array (
				'id' => 128,
				'name' => 'productoptiongroups_delete_owner',
				'display_name' => 'Delete Owner Productoptiongroups',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			128 => 
			array (
				'id' => 129,
				'name' => 'productoptions_view_all',
				'display_name' => 'View All Productoptions',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			129 => 
			array (
				'id' => 130,
				'name' => 'productoptions_view_owner',
				'display_name' => 'View Owner Productoptions',
				'created_at' => '2015-06-19 22:45:09',
				'updated_at' => '2015-06-19 22:45:09',
			),
			130 => 
			array (
				'id' => 131,
				'name' => 'productoptions_create_owner',
				'display_name' => 'Create Owner Productoptions',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			131 => 
			array (
				'id' => 132,
				'name' => 'productoptions_edit_all',
				'display_name' => 'Edit All Productoptions',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			132 => 
			array (
				'id' => 133,
				'name' => 'productoptions_edit_owner',
				'display_name' => 'Edit Owner Productoptions',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			133 => 
			array (
				'id' => 134,
				'name' => 'productoptions_delete_all',
				'display_name' => 'Delete All Productoptions',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			134 => 
			array (
				'id' => 135,
				'name' => 'productoptions_delete_owner',
				'display_name' => 'Delete Owner Productoptions',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			135 => 
			array (
				'id' => 136,
				'name' => 'producttypes_view_all',
				'display_name' => 'View All Producttypes',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			136 => 
			array (
				'id' => 137,
				'name' => 'producttypes_view_owner',
				'display_name' => 'View Owner Producttypes',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			137 => 
			array (
				'id' => 138,
				'name' => 'producttypes_create_owner',
				'display_name' => 'Create Owner Producttypes',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			138 => 
			array (
				'id' => 139,
				'name' => 'producttypes_edit_all',
				'display_name' => 'Edit All Producttypes',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			139 => 
			array (
				'id' => 140,
				'name' => 'producttypes_edit_owner',
				'display_name' => 'Edit Owner Producttypes',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			140 => 
			array (
				'id' => 141,
				'name' => 'producttypes_delete_all',
				'display_name' => 'Delete All Producttypes',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			141 => 
			array (
				'id' => 142,
				'name' => 'producttypes_delete_owner',
				'display_name' => 'Delete Owner Producttypes',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			142 => 
			array (
				'id' => 143,
				'name' => 'products_view_all',
				'display_name' => 'View All Products',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			143 => 
			array (
				'id' => 144,
				'name' => 'products_view_owner',
				'display_name' => 'View Owner Products',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			144 => 
			array (
				'id' => 145,
				'name' => 'products_create_owner',
				'display_name' => 'Create Owner Products',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			145 => 
			array (
				'id' => 146,
				'name' => 'products_edit_all',
				'display_name' => 'Edit All Products',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			146 => 
			array (
				'id' => 147,
				'name' => 'products_edit_owner',
				'display_name' => 'Edit Owner Products',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			147 => 
			array (
				'id' => 148,
				'name' => 'products_delete_all',
				'display_name' => 'Delete All Products',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
			148 => 
			array (
				'id' => 149,
				'name' => 'products_delete_owner',
				'display_name' => 'Delete Owner Products',
				'created_at' => '2015-06-19 22:45:10',
				'updated_at' => '2015-06-19 22:45:10',
			),
		));
	}

}
