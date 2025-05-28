<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategoriesSeeder extends Seeder
{
	/**
	 * Run the database seeders.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('subcategories')->insert([
			'id' => "1",
			'category_id' => "1",
			'name' => "Roti, Naan & Parathas",
			'created_at' => "2025-04-10 07:00:01",
			'updated_at' => "2025-04-10 07:00:01",
		]);

		DB::table('subcategories')->insert([
			'id' => "2",
			'category_id' => "1",
			'name' => "Raita & Salad",
			'created_at' => "2025-04-10 07:00:10",
			'updated_at' => "2025-04-10 07:00:10",
		]);

		DB::table('subcategories')->insert([
			'id' => "3",
			'category_id' => "2",
			'name' => "Specials",
			'created_at' => "2025-04-10 07:00:45",
			'updated_at' => "2025-04-10 07:00:45",
		]);

		DB::table('subcategories')->insert([
			'id' => "4",
			'category_id' => "2",
			'name' => "Qorma",
			'created_at' => "2025-04-10 07:01:10",
			'updated_at' => "2025-04-10 07:01:10",
		]);

		DB::table('subcategories')->insert([
			'id' => "5",
			'category_id' => "2",
			'name' => "Qeema Dishes",
			'created_at' => "2025-04-10 07:01:25",
			'updated_at' => "2025-04-10 07:01:25",
		]);

		DB::table('subcategories')->insert([
			'id' => "6",
			'category_id' => "2",
			'name' => "Aalu Gosht Specials",
			'created_at' => "2025-04-10 07:01:54",
			'updated_at' => "2025-04-10 07:01:54",
		]);

		DB::table('subcategories')->insert([
			'id' => "7",
			'category_id' => "3",
			'name' => "BBQ",
			'created_at' => "2025-04-10 07:03:34",
			'updated_at' => "2025-04-10 07:03:34",
		]);

		DB::table('subcategories')->insert([
			'id' => "8",
			'category_id' => "3",
			'name' => "Rolls & Bun Kebabs",
			'created_at' => "2025-04-10 07:25:32",
			'updated_at' => "2025-04-10 07:25:32",
		]);

		DB::table('subcategories')->insert([
			'id' => "10",
			'category_id' => "4",
			'name' => "Biryani",
			'created_at' => "2025-04-10 07:36:05",
			'updated_at' => "2025-04-10 07:36:05",
		]);

		DB::table('subcategories')->insert([
			'id' => "11",
			'category_id' => "4",
			'name' => "Pualo",
			'created_at' => "2025-04-10 07:36:10",
			'updated_at' => "2025-04-10 07:36:10",
		]);

		DB::table('subcategories')->insert([
			'id' => "12",
			'category_id' => "4",
			'name' => "Sawaan Platters",
			'created_at' => "2025-04-10 07:36:39",
			'updated_at' => "2025-04-10 07:36:39",
		]);

		DB::table('subcategories')->insert([
			'id' => "13",
			'category_id' => "5",
			'name' => "Cold Drinks",
			'created_at' => "2025-04-10 07:37:09",
			'updated_at' => "2025-04-10 07:37:09",
		]);

		DB::table('subcategories')->insert([
			'id' => "14",
			'category_id' => "5",
			'name' => "Chai",
			'created_at' => "2025-04-10 07:37:27",
			'updated_at' => "2025-04-10 07:37:27",
		]);

		DB::table('subcategories')->insert([
			'id' => "15",
			'category_id' => "5",
			'name' => "Dessert",
			'created_at' => "2025-04-10 07:37:37",
			'updated_at' => "2025-04-10 07:37:37",
		]);

		DB::table('subcategories')->insert([
			'id' => "16",
			'category_id' => "6",
			'name' => "Snacks",
			'created_at' => "2025-04-10 11:42:31",
			'updated_at' => "2025-04-10 11:42:31",
		]);
	}
}
