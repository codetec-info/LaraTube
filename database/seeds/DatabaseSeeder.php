<?php

use Illuminate\Database\Seeder;
use Laratube\Channel;
use Laratube\Subscription;
use Laratube\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // Customize a field in factory
        $user1 = factory(User::class)->create([
            'email' => 'hsn.saad@outlook.com',
            'name' => 'hsn.saad'
        ]);

        $user2 = factory(User::class)->create([
            'email' => 'hsn.saad92@gmail.com',
            'name' => 'hsn.saad92'
        ]);

        $channel1 = factory(Channel::class)->create([
            'user_id' => $user1->id,
        ]);

        $channel2 = factory(Channel::class)->create([
            'user_id' => $user2->id,
        ]);

        $channel1->subscriptions()->create([
            'user_id' => $user2->id,
        ]);

        $channel2->subscriptions()->create([
            'user_id' => $user1->id,
        ]);

        factory(Subscription::class, 100)->create([
            'channel_id' => $channel1->id
        ]);

        factory(Subscription::class, 100)->create([
            'channel_id' => $channel2->id
        ]);
    }
}
