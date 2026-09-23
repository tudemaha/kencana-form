<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Student Login</h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Sign in to access your forms
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-sm ring-1 ring-gray-950/5 sm:rounded-xl sm:px-10">
            <form wire:submit="authenticate">
                
                @error('data.username')
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                        <p class="text-sm text-red-700">{{ $message }}</p>
                    </div>
                @enderror

                {{ $this->form }}

                <div class="mt-6">
                    <x-filament::button type="submit" class="w-full" color="primary">
                        Sign in
                    </x-filament::button>
                </div>
            </form>
        </div>
        <p class="text-center mt-6 text-xs text-gray-400 font-medium">Powered by <span class="text-[#B1CF6F]">Kencana Wisata</span></p>
    </div>
</div>
