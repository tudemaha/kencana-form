<div class="min-h-screen bg-white flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">Student Login</h2>
        <p class="mt-2 text-center text-sm text-gray-500">
            Sign in to access your forms
        </p>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-10 px-8 sm:rounded-2xl border border-gray-100 shadow-sm sm:px-10">
            <form wire:submit="authenticate" class="space-y-6">
                
                @error('auth')
                    <div class="p-4 rounded-xl bg-red-50 text-red-800 text-sm border border-red-100 flex gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0 text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        <p class="font-medium">{{ $message }}</p>
                    </div>
                @enderror

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-900">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input id="username" type="text" wire:model="username" required autofocus class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2.5 transition-colors">
                    </div>
                    @error('username')
                        <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-900">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input id="password" type="password" wire:model="password" required class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2.5 transition-colors">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 mt-8">
                    <button type="submit" class="w-full inline-flex justify-center items-center rounded-xl bg-primary py-3.5 px-8 text-base font-bold text-white shadow-md hover:bg-primary/90 transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Sign in
                    </button>
                </div>
                
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-medium text-primary hover:text-secondary transition-colors">Sign up</a>
                    </p>
                </div>
            </form>
        </div>
        <p class="text-center mt-8 text-xs text-gray-400 font-medium">Powered by <span class="text-primary">Kencana Wisata</span></p>
    </div>
</div>
