<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Admin password: 123456
         */
        DB::insert(
            "INSERT INTO `users` (`id`, `name`, `username`, `phone`, `type`, `gender`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
            (1, 'Admin', NULL, NULL, 'admin', NULL, 'admin@admin.com', NULL, '\$2y$10\$pqSsKcTaktmaiubX/.ZhP.6fuz8IxHqyo8jBiiB3YEMwCUFCn1CrW', 'woKxxNKYi4QEDvmi0tjqJbx8CqibJonpUHE10E4rgYQHAPApi7jfLqA5kSHP', '2019-09-09 23:10:28', '2019-09-09 23:10:28'),
            (2, 'Saad', NULL, NULL, 'admin', NULL, 'test@example.com', NULL, '\$2y$10\$OErG.mAlpq7cOWNZnEV5GOkpBBu0MpxHA9n1Rug.F/NOWIaqMPqN2', 'isthisnecessary', '2019-09-09 23:10:28', '2019-09-09 23:10:28')"
        );

    }
}
