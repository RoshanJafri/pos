<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
	/**
	 * Run the database seeders.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('categories')->insert([
			'id' => "1",
			'order' => "1",
			'name' => "Breads & Sides",
			'created_at' => "2025-04-10 06:52:56",
			'updated_at' => "2025-04-10 06:52:56",
		]);

		DB::table('categories')->insert([
			'id' => "2",
			'order' => "2",
			'name' => "Curries & Gravies",
			'created_at' => "2025-04-10 06:53:43",
			'updated_at' => "2025-04-10 06:53:43",
		]);

		DB::table('categories')->insert([
			'id' => "3",
			'order' => "3",
			'name' => "Grilled & Rolls",
			'created_at' => "2025-04-10 06:54:08",
			'updated_at' => "2025-04-10 06:54:08",
		]);

		DB::table('categories')->insert([
			'id' => "4",
			'order' => "4",
			'name' => "Rice Dishes",
			'created_at' => "2025-04-10 06:54:18",
			'updated_at' => "2025-04-10 06:54:18",
		]);

		DB::table('categories')->insert([
			'id' => "5",
			'order' => "5",
			'name' => "Drinks & Sweets",
			'created_at' => "2025-04-10 06:54:27",
			'updated_at' => "2025-04-10 06:54:27",
		]);

		DB::table('categories')->insert([
			'id' => "6",
			'order' => "6",
			'name' => "Snacks & Street Food",
			'created_at' => "2025-04-10 06:54:38",
			'updated_at' => "2025-04-10 06:54:38",
		]);
	}
}
