<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; 
use Carbon\Carbon;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         if (class_exists(\Doctrine\DBAL\Types\Type::class)) {
        \DB::getDoctrineSchemaManager()
            ->getDatabasePlatform()
            ->registerDoctrineTypeMapping('enum', 'string');
    }

    // Kalau kamu sebelumnya punya ini, biarkan tetap:
     Schema::defaultStringLength(191);

    // 👇 Masukkan ke dalam fungsi boot
    Carbon::setLocale('id'); // Bahasa Indonesia
    setlocale(LC_TIME, 'id_ID'); // Lokal Indonesia
}
}
