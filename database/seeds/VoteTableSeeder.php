<?php

use Illuminate\Database\Seeder;

class VoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::inRandomOrder();
        for ($i = 1; $i <= 6; $i++) {
            $users->each(function ($user) {
                $question = App\Question::inRandomOrder()->first();
                $vote = factory(\App\Vote::class)->make();
                $vote->user()->associate($user);
                $vote->question()->associate($question);
                $vote->save();
            });
        }
    }
}
