<x-layouts.app title="Welcome | Kencana Wisata">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 pointer-events-none opacity-[0.03]" style="background-image: radial-gradient(circle at 2px 2px, #13432D 1px, transparent 0); background-size: 32px 32px;"></div>

        <div class="relative w-full max-w-2xl text-center px-4 sm:px-0">
            <div class="w-24 h-24 bg-primary rounded-3xl mx-auto mb-8 shadow-xl shadow-primary/20 flex items-center justify-center transform -rotate-3 hover:rotate-0 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-secondary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-gray-900 mb-6">
                Welcome to <span class="text-secondary">Kencana Wisata</span>
            </h1>
            
            <p class="text-lg text-gray-600 mb-10 max-w-lg mx-auto leading-relaxed">
                Streamline your school's travel and tour coordination. Sign in to access your forms or create a new student account to get started.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-transparent bg-primary py-3.5 px-8 text-base font-bold text-secondary shadow-md hover:bg-secondary hover:text-white focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2 transition-all cursor-pointer">
                    Sign in to your account
                </a>
                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-gray-300 bg-white py-3.5 px-8 text-base font-bold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2 transition-all cursor-pointer">
                    Create an account
                </a>
            </div>

            <div class="mt-16 text-sm text-gray-400 font-medium">
                Admin access? <a href="/admin" class="text-primary hover:text-secondary transition-colors underline decoration-primary/30 underline-offset-4">Go to dashboard</a>
            </div>
        </div>
    </div>
</x-layouts.app>
