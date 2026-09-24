<div class="min-h-screen bg-white text-gray-900 font-sans py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        
        @if(Auth::check())
            <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-secondary font-bold text-sm">
                        {{ Auth::user()->initials() }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ '@' . Auth::user()->username }}</p>
                    </div>
                </div>
                <button wire:click="logout" type="button" class="text-sm font-medium text-primary hover:text-secondary transition-colors flex items-center gap-2 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                    </svg>
                    Logout
                </button>
            </div>
        @endif

        <div class="mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-gray-900 mb-2">{{ $formRecord->title }}</h1>
            
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6 text-sm text-gray-500 mt-4 border-b border-gray-100 pb-6">
                <div class="flex items-center gap-2">
                    <span class="text-gray-400">School:</span> 
                    <span class="font-medium text-gray-700">{{ $formRecord->school->name }}</span>
                </div>
                @if($formRecord->tour_date)
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400">Tour Date:</span> 
                        <span class="font-medium text-gray-700">{{ $formRecord->tour_date->format('d F Y') }}</span>
                    </div>
                @endif
            </div>

            @if($formRecord->description)
                <div class="mt-6 text-gray-600 leading-relaxed text-sm whitespace-pre-line">
                    {{ $formRecord->description }}
                </div>
            @endif
        </div>

        @if($isForbidden)
            <div class="bg-red-50 p-8 rounded-2xl text-center border border-red-100">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-100 text-red-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-red-900">Access Denied</h3>
                <p class="mt-2 text-sm text-red-700">This form is exclusively for students of <span class="font-bold">{{ $formRecord->school->name }}</span>.<br>You are registered under a different school.</p>
            </div>
        @elseif(!Auth::check())
            <div class="bg-gray-50 p-8 rounded-2xl text-center border border-gray-100">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-yellow-50 text-yellow-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Login Required</h3>
                <p class="mt-2 text-sm text-gray-500">You must be logged in as a student to fill out this form.</p>
                <button wire:click="redirectToLogin" type="button" class="mt-6 inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-xl text-secondary bg-primary hover:bg-secondary hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary cursor-pointer">
                    Login Now
                </button>
            </div>
        @else
            <form wire:submit="save" class="space-y-8">
                @if (session()->has('message'))
                    <div class="p-4 rounded-xl bg-green-50 text-green-800 text-sm border border-green-100 flex gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0 text-green-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <p class="font-medium">{{ session('message') }}</p>
                    </div>
                @endif

                @error('general')
                    <div class="p-4 rounded-xl bg-red-50 text-red-800 text-sm border border-red-100 flex gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0 text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        <p class="font-medium">{{ $message }}</p>
                    </div>
                @enderror

                <div class="space-y-8">
                    @foreach($formRecord->questions as $question)
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-900">
                                {{ $question->question }} <span class="text-red-500">*</span>
                            </label>

                            @if($question->type === 'text')
                                <input type="text" wire:model="data.{{ $question->id }}" class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2.5 transition-colors">
                            
                            @elseif($question->type === 'textarea')
                                <textarea wire:model="data.{{ $question->id }}" rows="3" class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2.5 transition-colors"></textarea>
                            
                            @elseif($question->type === 'dropdown')
                                <select wire:model="data.{{ $question->id }}" class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2.5 transition-colors bg-white">
                                    <option value="">Select an option</option>
                                    @foreach($question->choices ?? [] as $choice)
                                        <option value="{{ $choice }}">{{ $choice }}</option>
                                    @endforeach
                                </select>

                            @elseif($question->type === 'room_partner')
                                @php
                                    $available = $this->getAvailablePartners($question);
                                @endphp
                                <div x-data="{ search: '' }" class="mt-3 border border-gray-200 rounded-xl overflow-hidden bg-white shadow-sm">
                                    <div class="p-2 border-b border-gray-100 bg-gray-50">
                                        <input x-model="search" type="text" placeholder="Search partners..." class="w-full text-sm border-gray-300 rounded-lg focus:ring-primary focus:border-primary px-3 py-2 bg-white">
                                    </div>
                                    <div class="max-h-60 overflow-y-auto p-3 space-y-3">
                                        @foreach($available as $choice)
                                            <div class="flex items-center" x-show="search === '' || '{{ strtolower(addslashes($choice)) }}'.includes(search.toLowerCase())">
                                                <input type="checkbox" wire:model="data.{{ $question->id }}" value="{{ $choice }}" id="q_{{ $question->id }}_{{ $loop->index }}" class="h-4 w-4 rounded border-gray-300 text-secondary focus:ring-secondary">
                                                <label for="q_{{ $question->id }}_{{ $loop->index }}" class="ml-3 block text-sm text-gray-700 cursor-pointer">
                                                    {{ $choice }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @if(empty($available))
                                    <p class="mt-1 text-xs text-gray-500">All partners have been picked.</p>
                                @endif

                            @elseif($question->type === 'radio')
                                <div class="space-y-3 mt-3">
                                    @foreach($question->choices ?? [] as $choice)
                                        <div class="flex items-center">
                                            <input type="radio" wire:model="data.{{ $question->id }}" value="{{ $choice }}" id="q_{{ $question->id }}_{{ $loop->index }}" class="h-4 w-4 border-gray-300 text-secondary focus:ring-secondary">
                                            <label for="q_{{ $question->id }}_{{ $loop->index }}" class="ml-3 block text-sm text-gray-700 cursor-pointer">
                                                {{ $choice }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                            @elseif($question->type === 'checkbox')
                                <div class="space-y-3 mt-3">
                                    @foreach($question->choices ?? [] as $choice)
                                        <div class="flex items-center">
                                            <input type="checkbox" wire:model="data.{{ $question->id }}" value="{{ $choice }}" id="q_{{ $question->id }}_{{ $loop->index }}" class="h-4 w-4 rounded border-gray-300 text-secondary focus:ring-secondary">
                                            <label for="q_{{ $question->id }}_{{ $loop->index }}" class="ml-3 block text-sm text-gray-700 cursor-pointer">
                                                {{ $choice }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @error('data.'.$question->id)
                                <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div class="pt-8 mt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-transparent bg-primary py-3 px-8 text-sm font-bold text-secondary shadow-sm hover:bg-secondary hover:text-white focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2 transition-colors cursor-pointer">
                        {{ $submissionId ? 'Update Form' : 'Submit Form' }}
                    </button>
                    <span class="text-xs text-gray-400 font-medium">
                        Powered by <span class="text-primary">Kencana Wisata</span>
                    </span>
                </div>
            </form>
        @endif
    </div>
</div>
