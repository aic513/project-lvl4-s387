<?php

use App\Task;
use App\TaskStatus;
use App\User;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'status_id' => function () {
            return factory(TaskStatus::class)->create()->id;
        },
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
        'assigned_to_id' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});
