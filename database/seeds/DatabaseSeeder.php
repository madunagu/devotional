<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call(UserSeeder::class);
      $this->call(AddressSeeder::class);
      $this->call(DefaultHierarchySeeder::class);
      $this->call(DevotionalSeeder::class);
      $this->call(ImageSeeder::class);
      $this->call(BiblePassageSeeder::class);
      $this->call(TagSeeder::class);
      $this->call(CommentSeeder::class);
      $this->call(ChurchSeeder::class);
      $this->call(EventSeeder::class);
      $this->call(PostSeeder::class);
      $this->call(VideoPostSeeder::class);
      $this->call(AudioPostSeeder::class);
      $this->call(HierarchySeeder::class);
      $this->call(HierarchyGroupSeeder::class);
      $this->call(FollowerSeeder::class);
      $this->call(FeedSeeder::class);
    }
}
