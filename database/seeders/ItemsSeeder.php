<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsSeeder extends Seeder
{
	/**
	 * Run the database seeders.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('items')->insert([
			'id' => "79",
			'subcategory_id' => "1",
			'name' => "Chapati",
			'cost' => "200",
			'created_at' =>  NULL,
			'updated_at' => "2025-04-10 15:00:31",
		]);

		DB::table('items')->insert([
			'id' => "80",
			'subcategory_id' => "1",
			'name' => "Paratha",
			'cost' => "300",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "81",
			'subcategory_id' => "1",
			'name' => "Qeema Paratha",
			'cost' => "800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "82",
			'subcategory_id' => "1",
			'name' => "Aalu Paratha",
			'cost' => "600",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "83",
			'subcategory_id' => "1",
			'name' => "Daal Paratha",
			'cost' => "600",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "84",
			'subcategory_id' => "1",
			'name' => "Cheese Paratha",
			'cost' => "800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "85",
			'subcategory_id' => "1",
			'name' => "Sweet Paratha",
			'cost' => "600",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "86",
			'subcategory_id' => "2",
			'name' => "Raita",
			'cost' => "150",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "87",
			'subcategory_id' => "2",
			'name' => "Salaad",
			'cost' => "150",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "88",
			'subcategory_id' => "3",
			'name' => "Nihari",
			'cost' => "1800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "89",
			'subcategory_id' => "3",
			'name' => "Haleem",
			'cost' => "1800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "90",
			'subcategory_id' => "3",
			'name' => "Paaya",
			'cost' => "1800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "91",
			'subcategory_id' => "5",
			'name' => "Aalu Qeema",
			'cost' => "1800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "92",
			'subcategory_id' => "5",
			'name' => "Aalu Qeema with Green Peas",
			'cost' => "1800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "93",
			'subcategory_id' => "5",
			'name' => "Chana Daal Qeema",
			'cost' => "1800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "94",
			'subcategory_id' => "5",
			'name' => "Dum ka Qeema",
			'cost' => "2000",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "95",
			'subcategory_id' => "4",
			'name' => "Chicken Qorma",
			'cost' => "1500",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "96",
			'subcategory_id' => "4",
			'name' => "Beef Qorma",
			'cost' => "1800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "97",
			'subcategory_id' => "4",
			'name' => "Mutton Qorma",
			'cost' => "2600",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "98",
			'subcategory_id' => "6",
			'name' => "Chicken Karahi",
			'cost' => "1500",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "99",
			'subcategory_id' => "6",
			'name' => "Beef Karahi",
			'cost' => "1800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "100",
			'subcategory_id' => "6",
			'name' => "Mutton Karahi",
			'cost' => "2600",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "101",
			'subcategory_id' => "6",
			'name' => "Fish Karahi",
			'cost' => "2400",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "102",
			'subcategory_id' => "8",
			'name' => "Chicken Bun Kebab",
			'cost' => "700",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "103",
			'subcategory_id' => "8",
			'name' => "Chicken Bun Kebab with Egg",
			'cost' => "800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "104",
			'subcategory_id' => "8",
			'name' => "Chicken Roll Paratha",
			'cost' => "900",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "105",
			'subcategory_id' => "8",
			'name' => "Karachi Chicken Roll Paratha",
			'cost' => "1100",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "106",
			'subcategory_id' => "8",
			'name' => "Chicken Shami Kebab",
			'cost' => "700",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "107",
			'subcategory_id' => "8",
			'name' => "Chicken Tikka",
			'cost' => "1200",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "108",
			'subcategory_id' => "8",
			'name' => "Chicken Tikka Boti",
			'cost' => "1400",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "109",
			'subcategory_id' => "7",
			'name' => "Beef Bun Kebab",
			'cost' => "800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "110",
			'subcategory_id' => "7",
			'name' => "Beef Bun Kebab with Egg",
			'cost' => "900",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "111",
			'subcategory_id' => "7",
			'name' => "Beef Roll Paratha",
			'cost' => "1000",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "112",
			'subcategory_id' => "7",
			'name' => "Karachi Beef Roll Paratha",
			'cost' => "1200",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "113",
			'subcategory_id' => "7",
			'name' => "Beef Shami Kebab",
			'cost' => "800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "114",
			'subcategory_id' => "7",
			'name' => "Beef Tikka Boti",
			'cost' => "1600",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "115",
			'subcategory_id' => "10",
			'name' => "Chicken Biryani",
			'cost' => "1600",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "116",
			'subcategory_id' => "10",
			'name' => "Beef Biryani",
			'cost' => "2000",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "117",
			'subcategory_id' => "10",
			'name' => "Mutton Biryani",
			'cost' => "2600",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "118",
			'subcategory_id' => "10",
			'name' => "Fish Biryani",
			'cost' => "2400",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "119",
			'subcategory_id' => "12",
			'name' => "Chicken & Biryani Saawan 06 Pts",
			'cost' => "8640",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "120",
			'subcategory_id' => "12",
			'name' => "Chicken & Biryani Saawan 08 Pts",
			'cost' => "11520",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "121",
			'subcategory_id' => "12",
			'name' => "Beef Biryani Saawan 06 Pts",
			'cost' => "10800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "122",
			'subcategory_id' => "12",
			'name' => "Beef Biryani Saawan 08 Pts",
			'cost' => "14400",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "123",
			'subcategory_id' => "12",
			'name' => "Mutton Biryani Saawan 06 Pts",
			'cost' => "14000",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "124",
			'subcategory_id' => "12",
			'name' => "Mutton Biryani Saawan 08 Pts",
			'cost' => "18700",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "125",
			'subcategory_id' => "11",
			'name' => "Chicken Pulao Saawan 06 Pts",
			'cost' => "9720",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "126",
			'subcategory_id' => "11",
			'name' => "Chicken Pulao Saawan 08 Pts",
			'cost' => "12960",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "127",
			'subcategory_id' => "11",
			'name' => "Beef Pulao Saawan 06 Pts",
			'cost' => "11880",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "128",
			'subcategory_id' => "11",
			'name' => "Beef Pulao Saawan 08 Pts",
			'cost' => "15840",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "129",
			'subcategory_id' => "11",
			'name' => "Mutton Pulao Saawan 06 Pts",
			'cost' => "15000",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "130",
			'subcategory_id' => "11",
			'name' => "Mutton Pulao Saawan 08 Pts",
			'cost' => "20000",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "131",
			'subcategory_id' => "3",
			'name' => "Tehri",
			'cost' => "1200",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "132",
			'subcategory_id' => "11",
			'name' => "Chana Pulao",
			'cost' => "1200",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "133",
			'subcategory_id' => "11",
			'name' => "Matar Pulao",
			'cost' => "1200",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "134",
			'subcategory_id' => "10",
			'name' => "Veg Biryani",
			'cost' => "1200",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "135",
			'subcategory_id' => "11",
			'name' => "Chicken Pulao",
			'cost' => "1800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "136",
			'subcategory_id' => "11",
			'name' => "Beef Pulao",
			'cost' => "2200",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "137",
			'subcategory_id' => "11",
			'name' => "Mutton Pulao",
			'cost' => "2800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "138",
			'subcategory_id' => "6",
			'name' => "Beef Aalu Gosht",
			'cost' => "2000",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "139",
			'subcategory_id' => "6",
			'name' => "Mutton Aalu Gosht",
			'cost' => "2600",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "140",
			'subcategory_id' => "6",
			'name' => "Chicken Handi",
			'cost' => "1600",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "141",
			'subcategory_id' => "16",
			'name' => "Puri Set",
			'cost' => "1500",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "142",
			'subcategory_id' => "13",
			'name' => "Coca cola",
			'cost' => "300",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "143",
			'subcategory_id' => "13",
			'name' => "Pepsi",
			'cost' => "300",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "144",
			'subcategory_id' => "13",
			'name' => "7up",
			'cost' => "300",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "145",
			'subcategory_id' => "13",
			'name' => "Sprite",
			'cost' => "300",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "146",
			'subcategory_id' => "13",
			'name' => "Fanta",
			'cost' => "300",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "147",
			'subcategory_id' => "13",
			'name' => "Lassi salted",
			'cost' => "350",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "148",
			'subcategory_id' => "13",
			'name' => "Lassi sweet",
			'cost' => "400",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "149",
			'subcategory_id' => "13",
			'name' => "Lassi mint",
			'cost' => "400",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "150",
			'subcategory_id' => "14",
			'name' => "Karak Chai",
			'cost' => "300",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "151",
			'subcategory_id' => "14",
			'name' => "Kashmiri Chai",
			'cost' => "400",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "152",
			'subcategory_id' => "13",
			'name' => "Water 500ml",
			'cost' => "100",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "153",
			'subcategory_id' => "13",
			'name' => "Water 1000ml",
			'cost' => "200",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "154",
			'subcategory_id' => "15",
			'name' => "Kheer",
			'cost' => "300",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "155",
			'subcategory_id' => "15",
			'name' => "Zarda",
			'cost' => "300",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "156",
			'subcategory_id' => "15",
			'name' => "Suji Ka Halwa",
			'cost' => "300",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "157",
			'subcategory_id' => "16",
			'name' => "Chana Chaat",
			'cost' => "500",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "158",
			'subcategory_id' => "16",
			'name' => "Dahi Baray",
			'cost' => "800",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);

		DB::table('items')->insert([
			'id' => "159",
			'subcategory_id' => "16",
			'name' => "Gol Gappay 05pcs",
			'cost' => "500",
			'created_at' =>  NULL,
			'updated_at' =>  NULL,
		]);
	}
}
