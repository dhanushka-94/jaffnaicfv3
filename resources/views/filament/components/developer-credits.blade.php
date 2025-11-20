@if(!request()->routeIs('filament.admin.auth.login'))
<footer class="fi-footer mt-auto">
    <div class="mx-auto w-full max-w-7xl border-t border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/50 px-4 sm:px-6 lg:px-8">
        <div class="py-4">
            <div class="flex flex-col items-center justify-between gap-3 sm:flex-row">
                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                    <span>© {{ date('Y') }} {{ config('app.name') }}</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                    <span class="hidden sm:inline">Website design & development by</span>
                    <a href="#" class="font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors duration-200">
                        <span>olexto Digital Solutions (Pvt) Ltd</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
@endif

