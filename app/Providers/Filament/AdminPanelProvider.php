<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Get site settings safely (handle database not available during composer install)
        $siteLogo = null;
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
                $siteSetting = \App\Models\SiteSetting::first();
                $siteLogo = $siteSetting?->logo_path;
            }
        } catch (\Exception $e) {
            // Database not available, use default
        }

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('JAFFNA ICF')
            ->brandLogo($siteLogo ? asset('storage/' . $siteLogo) : null)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->font('Inter')
            ->favicon($siteLogo ? asset('storage/' . $siteLogo) : null)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverviewWidget::class,
                \App\Filament\Widgets\ProgrammeStatsWidget::class,
                \App\Filament\Widgets\RecentActivityWidget::class,
                AccountWidget::class,
            ])
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
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn (): string => view('filament.components.developer-credits')->render(),
            )
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
                fn (): string => view('filament.components.developer-credits-login')->render(),
            )
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn (): string => '<style>
                    /* Main Container - Centered Background */
                    .fi-simple-main-ctn {
                        background: linear-gradient(135deg, #C5502C 0%, #8B3A1F 100%) !important;
                        background-attachment: fixed !important;
                        min-height: 100vh;
                        display: flex !important;
                        align-items: center !important;
                        justify-content: center !important;
                        padding: 1.5rem !important;
                        position: relative;
                    }
                    
                    /* Login Card - Compact & Professional */
                    .fi-simple-page {
                        background: white !important;
                        border-radius: 1.25rem !important;
                        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.05) !important;
                        padding: 2rem 2.25rem !important;
                        max-width: 420px !important;
                        width: 100% !important;
                        margin: 0 auto !important;
                        position: relative;
                    }
                    
                    /* Brand Logo Container */
                    .fi-simple-header {
                        text-align: center !important;
                        margin-bottom: 2rem !important;
                        padding-bottom: 1.5rem !important;
                        border-bottom: 1px solid rgba(197, 80, 44, 0.1) !important;
                    }
                    
                    .fi-simple-header-logo {
                        margin: 0 auto 1rem auto !important;
                        display: block !important;
                        max-width: 120px !important;
                        height: auto !important;
                    }
                    
                    /* Brand Heading */
                    .fi-header-heading {
                        font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
                        font-weight: 700 !important;
                        font-size: 1.5rem !important;
                        color: #1f2937 !important;
                        letter-spacing: -0.02em !important;
                        margin: 0 !important;
                        text-align: center !important;
                    }
                    
                    /* Form Container */
                    .fi-simple-main {
                        margin-top: 0 !important;
                    }
                    
                    /* Form Fields - Professional Styling */
                    .fi-simple-main form .fi-fo-field-wrp {
                        margin-bottom: 1.25rem !important;
                    }
                    
                    .fi-simple-main .fi-input-wrp {
                        border-radius: 0.625rem !important;
                        border: 1.5px solid #e5e7eb !important;
                        transition: all 0.2s ease !important;
                    }
                    
                    .fi-simple-main .fi-input-wrp:focus-within {
                        border-color: #C5502C !important;
                        box-shadow: 0 0 0 3px rgba(197, 80, 44, 0.1) !important;
                    }
                    
                    .fi-simple-main input[type="email"],
                    .fi-simple-main input[type="password"] {
                        padding: 0.75rem 1rem !important;
                        font-size: 0.9375rem !important;
                        border: none !important;
                        background: transparent !important;
                    }
                    
                    .fi-simple-main input[type="email"]:focus,
                    .fi-simple-main input[type="password"]:focus {
                        outline: none !important;
                        box-shadow: none !important;
                    }
                    
                    /* Labels */
                    .fi-simple-main label {
                        font-weight: 500 !important;
                        font-size: 0.875rem !important;
                        color: #374151 !important;
                        margin-bottom: 0.5rem !important;
                    }
                    
                    /* Remember Me Checkbox */
                    .fi-simple-main .fi-checkbox {
                        margin-top: 0.5rem !important;
                    }
                    
                    /* Primary Button - Professional */
                    .fi-btn-primary {
                        background: linear-gradient(135deg, #C5502C 0%, #8B3A1F 100%) !important;
                        border: none !important;
                        border-radius: 0.625rem !important;
                        font-weight: 600 !important;
                        font-size: 0.9375rem !important;
                        padding: 0.75rem 1.5rem !important;
                        width: 100% !important;
                        margin-top: 0.5rem !important;
                        transition: all 0.2s ease !important;
                        box-shadow: 0 4px 6px -1px rgba(197, 80, 44, 0.2) !important;
                        text-transform: none !important;
                        letter-spacing: 0 !important;
                    }
                    
                    .fi-btn-primary:hover {
                        background: linear-gradient(135deg, #8B3A1F 0%, #6B2D15 100%) !important;
                        box-shadow: 0 6px 12px -2px rgba(197, 80, 44, 0.3) !important;
                        transform: translateY(-1px) !important;
                    }
                    
                    .fi-btn-primary:active {
                        transform: translateY(0) !important;
                    }
                    
                    /* Error Messages */
                    .fi-simple-main .fi-fo-field-error-message {
                        font-size: 0.8125rem !important;
                        margin-top: 0.375rem !important;
                        color: #dc2626 !important;
                    }
                    
                    /* Success/Info Messages */
                    .fi-simple-main .fi-badge {
                        border-radius: 0.5rem !important;
                        font-size: 0.8125rem !important;
                        padding: 0.5rem 0.75rem !important;
                    }
                    
                    /* Responsive Design */
                    @media (max-width: 640px) {
                        .fi-simple-page {
                            padding: 1.75rem 1.5rem !important;
                            max-width: 100% !important;
                            border-radius: 1rem !important;
                        }
                        
                        .fi-simple-header {
                            margin-bottom: 1.5rem !important;
                            padding-bottom: 1.25rem !important;
                        }
                        
                        .fi-header-heading {
                            font-size: 1.375rem !important;
                        }
                        
                        .fi-simple-header-logo {
                            max-width: 100px !important;
                        }
                    }
                    
                    /* Developer Credits - Enhanced UI */
                    .developer-credits-login {
                        margin-top: 2rem !important;
                        padding-top: 1.75rem !important;
                        border-top: 1px solid rgba(229, 231, 235, 0.8) !important;
                        text-align: center !important;
                    }
                    
                    .developer-credits-content {
                        display: flex !important;
                        flex-direction: column !important;
                        align-items: center !important;
                        justify-content: center !important;
                        gap: 0.625rem !important;
                    }
                    
                    .developer-credits-icon {
                        display: flex !important;
                        align-items: center !important;
                        justify-content: center !important;
                        width: 2rem !important;
                        height: 2rem !important;
                        background: linear-gradient(135deg, rgba(197, 80, 44, 0.1) 0%, rgba(139, 58, 31, 0.1) 100%) !important;
                        border-radius: 50% !important;
                        margin-bottom: 0.25rem !important;
                        color: #C5502C !important;
                    }
                    
                    .developer-credits-label {
                        font-size: 0.75rem !important;
                        color: #6b7280 !important;
                        font-weight: 400 !important;
                        margin: 0 !important;
                        letter-spacing: 0.01em !important;
                    }
                    
                    .developer-credits-link {
                        display: inline-flex !important;
                        align-items: center !important;
                        justify-content: center !important;
                        gap: 0.25rem !important;
                        text-decoration: none !important;
                        transition: all 0.2s ease !important;
                        padding: 0.375rem 0.75rem !important;
                        border-radius: 0.5rem !important;
                        background: transparent !important;
                    }
                    
                    .developer-credits-link:hover {
                        background: rgba(197, 80, 44, 0.05) !important;
                        transform: translateY(-1px) !important;
                    }
                    
                    .developer-credits-company {
                        font-size: 0.8125rem !important;
                        font-weight: 600 !important;
                        color: #C5502C !important;
                        letter-spacing: 0.01em !important;
                    }
                    
                    .developer-credits-type {
                        font-size: 0.8125rem !important;
                        font-weight: 500 !important;
                        color: #9ca3af !important;
                    }
                    
                    .developer-credits-link:hover .developer-credits-company {
                        color: #8B3A1F !important;
                    }
                    
                    .developer-credits-link:hover .developer-credits-type {
                        color: #6b7280 !important;
                    }
                    
                    /* Responsive Developer Credits */
                    @media (max-width: 640px) {
                        .developer-credits-login {
                            margin-top: 1.5rem !important;
                            padding-top: 1.5rem !important;
                        }
                        
                        .developer-credits-icon {
                            width: 1.75rem !important;
                            height: 1.75rem !important;
                        }
                        
                        .developer-credits-icon svg {
                            width: 0.875rem !important;
                            height: 0.875rem !important;
                        }
                        
                        .developer-credits-label {
                            font-size: 0.6875rem !important;
                        }
                        
                        .developer-credits-company,
                        .developer-credits-type {
                            font-size: 0.75rem !important;
                        }
                    }
                    
                    /* Loading State */
                    .fi-btn-primary:disabled {
                        opacity: 0.7 !important;
                        cursor: not-allowed !important;
                    }
                </style>',
            );
    }
}
