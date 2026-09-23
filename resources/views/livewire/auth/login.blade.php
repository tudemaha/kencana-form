<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Student Login</h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Sign in to access your forms
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-sm ring-1 ring-gray-950/5 sm:rounded-xl sm:px-10">
            <form wire:submit="login" class="space-y-6">
                
                @error('username')
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded-md">
                        <p class="text-sm text-red-700">{{ $message }}</p>
                    </div>
                @enderror

                <div>
                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                    <div class="mt-2">
                        <input wire:model="username" id="username" type="text" required autofocus class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#50A7AF] sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="mt-2">
                        <input wire:model="password" id="password" type="password" required class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#50A7AF] sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-[#13432D] py-2.5 px-3 text-sm font-semibold text-white shadow-sm hover:bg-[#13432D]/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#13432D] transition-colors">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
        <p class="text-center mt-6 text-xs text-gray-400 font-medium">Powered by <span class="text-[#B1CF6F]">Kencana Wisata</span></p>
    </div>
</div>
