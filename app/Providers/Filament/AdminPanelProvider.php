<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\MenuItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Admin\Pages\Login::class) // custom login dengan username untuk email
            ->userMenuItems([
                MenuItem::make()
                    ->label('Go to Welcome')
                    ->url('/')
                    ->icon('heroicon-o-home'),
            ])
            ->colors([
                'danger' => Color::Red,
                'gray' => Color::Slate,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            // Temukan semua resources, pages, dan widgets di folder Admin
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')

            // Halaman default tambahan
            ->pages([
                Pages\Dashboard::class,
            ])

            // Widget default tambahan
            ->widgets([
                \App\Filament\Admin\Widgets\BorrowingsChart::class,
                \App\Filament\Admin\Widgets\MonthlyBorrowingsChart::class,
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])

            // Middleware global
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            // Middleware autentikasi khusus Filament
            ->authMiddleware([
                Authenticate::class,
                \App\Http\Middleware\AdminRoleMiddleware::class, // untuk filter role admin
            ])

            // Resource tambahan (opsional jika mau manual)
            ->resources([
                \App\Filament\Admin\Resources\BookResource::class,
                \App\Filament\Admin\Resources\CategoryResource::class,
            ]);
    }
}
