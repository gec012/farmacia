<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Menu::class, function (Faker $faker) {
	$etiqueta = $faker->name;
	$menus = App\Menu::all();

	return [
		'etiqueta' => $etiqueta,
		'pagina' => str_slug($etiqueta),
		'padre' => (count($menus) > 0) ? $faker->randomElement($menus->pluck('id')->toArray()) : 0,
		'orden' => 0,
	];
 });
