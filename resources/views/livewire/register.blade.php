<div class="min-h-screen bg-white flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">Create an Account</h2>
        <p class="mt-2 text-center text-sm text-gray-500">
            Sign up to start filling out forms
        </p>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-10 px-8 sm:rounded-2xl border border-gray-100 shadow-sm sm:px-10">
            <form wire:submit="register" class="space-y-6">
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-900">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input id="name" type="text" wire:model="name" required autofocus class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2.5 transition-colors">
                    </div>
                    @error('name')
                        <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="school_id" class="block text-sm font-medium text-gray-900">
                        School <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <select id="school_id" wire:model="school_id" required class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2.5 transition-colors bg-white">
                            <option value="">Select your school</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('school_id')
                        <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-900">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input id="username" type="text" wire:model="username" required class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2.5 transition-colors">
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

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-900">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input id="password_confirmation" type="password" wire:model="password_confirmation" required class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2.5 transition-colors">
                    </div>
                </div>

                <div class="pt-4 mt-8">
                    <button type="submit" class="w-full inline-flex justify-center items-center rounded-xl bg-primary py-3.5 px-8 text-base font-bold text-white shadow-md hover:bg-primary/90 transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Sign up
                    </button>
                </div>
                
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="font-medium text-primary hover:text-secondary transition-colors">Log in</a>
                    </p>
                </div>
            </form>
        </div>
        <p class="text-center mt-8 text-xs text-gray-400 font-medium">Powered by <span class="text-primary">Kencana Wisata</span></p>
    </div>
</div>
