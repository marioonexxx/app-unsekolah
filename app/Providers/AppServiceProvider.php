<?php

namespace App\Providers;

use App\Models\Periode;
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
        // Variabel ini akan otomatis tersedia di file layout navbar dan turunannya
        View::composer(['layouthomepage.partial.navbar', 'layouthomepage.partial.menubar'], function ($view) {
            $periodeAktif = Periode::where('is_active', true)->first(); // Sesuaikan logic database Anda
            $view->with('periodeAktif', $periodeAktif);
        });
    }
}
