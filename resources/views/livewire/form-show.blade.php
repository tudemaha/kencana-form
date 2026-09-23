<div class="min-h-screen bg-gray-50 flex flex-col items-center pt-10 pb-20 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="w-full max-w-3xl">
        <!-- Header -->
        <div class="bg-white rounded-t-xl rounded-b-md shadow-sm ring-1 ring-gray-950/5 overflow-hidden mb-6">
            <div class="h-3 w-full" style="background-color: #B1CF6F;"></div>
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $formRecord->title }}</h1>
                @if($formRecord->description)
                    <p class="text-gray-600 text-sm whitespace-pre-line mt-3">{{ $formRecord->description }}</p>
                @endif
                <div class="mt-6 pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between text-xs text-gray-500 space-y-2 sm:space-y-0">
                    <div><span class="font-medium text-gray-700">School:</span> {{ $formRecord->school->name }}</div>
                    @if($formRecord->tour_date)
                        <div><span class="font-medium text-gray-700">Tour Date:</span> {{ $formRecord->tour_date->format('M d, Y') }}</div>
                    @endif
                </div>
            </div>
        </div>

        @if(!Auth::check())
            <div class="bg-amber-50 border border-amber-200 p-6 rounded-xl shadow-sm ring-1 ring-gray-950/5 mb-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 mb-4">
                    <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-amber-900">Login Required</h3>
                <p class="mt-2 text-sm text-amber-700">You must be logged in as a student to fill out this form.</p>
                <div class="mt-4">
                    <a href="/login" class="inline-flex justify-center rounded-md bg-[#13432D] py-2 px-4 text-sm font-semibold text-white shadow-sm hover:bg-[#13432D]/90">
                        Login Now
                    </a>
                </div>
            </div>
        @else
            <!-- Form -->
            <form wire:submit="save" class="space-y-6">
                @if (session()->has('message'))
                    <div class="bg-green-50 border border-green-200 p-4 rounded-xl shadow-sm">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                        </div>
                    </div>
                @endif

                @error('general')
                    <div class="bg-red-50 border border-red-200 p-4 rounded-xl shadow-sm">
                        <p class="text-sm text-red-700">{{ $message }}</p>
                    </div>
                @enderror

                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 p-6 md:p-8">
                    {{ $this->form }}
                </div>

                <div class="flex items-center justify-between pt-2">
                    <x-filament::button type="submit" color="primary" size="lg">
                        {{ $submissionId ? 'Update Form' : 'Submit Form' }}
                    </x-filament::button>
                    <span class="text-xs font-medium text-gray-400">Powered by <span class="text-[#B1CF6F]">Kencana Wisata</span></span>
                </div>
            </form>
        @endif
    </div>
</div>
