<?php

namespace App\Providers;

use App\Models\City;
use App\Models\Config as Configuration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        if (class_exists(Configuration::class)) {
            try {
                $configs = Configuration::all();

                $cities = City::query()->where('active', 1)->whereNotIn('title', ['Москва', 'Санкт-Петербург'])->get();
                View::share('cities', $cities);

                foreach ($configs as $config) {
                    Config::set('site.' . $config->key, json_decode($config->value, true) ?? $config->value);
                }
            } catch (\Exception $e) {
                \Log::error('Ошибка загрузки конфигурации из базы: ' . $e->getMessage());
            }
        }
    }
}
