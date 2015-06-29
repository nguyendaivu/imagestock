<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		Cache::flush();
		$this->call('AdminsTableSeeder');
		$this->call('MenusTableSeeder');
		$this->call('PermissionsTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('PermissionRoleTableSeeder');
		$this->call('AssignedRolesTableSeeder');
		$this->call('BannersTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('ConfiguresTableSeeder');
		$this->call('ContactsTableSeeder');
		$this->call('EmailTemplatesTableSeeder');
		$this->call('ImagesTableSeeder');
		$this->call('ImagesCategoriesTableSeeder');
		$this->call('NotificationsTableSeeder');
		$this->call('TypesTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('StatisticImageTableSeeder');
		$this->call('LightboxTableSeeder');
		$this->call('CollectionsTableSeeder');
		$this->call('CollectionImagesTableSeeder');
		$this->call('PopularSearchImagesTableSeeder');
		$this->call('CountriesTableSeeder');
		$this->call('StatesTableSeeder');
		$this->call('DownloadsTableSeeder');
		$this->call('ProductsTableSeeder');
		$this->call('OptionGroupsTableSeeder');
		$this->call('ProductsCategoriesTableSeeder');
		$this->call('ImageablesTableSeeder');
		$this->call('OptionablesTableSeeder');
		$this->call('OptionsTableSeeder');
		$this->call('ImageDetailsTableSeeder');
	}

}
