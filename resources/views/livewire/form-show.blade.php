<div class="min-h-screen bg-gray-50 flex flex-col items-center pt-10 pb-20 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="w-full max-w-3xl">
        <!-- Header -->
        <div class="bg-white rounded-t-xl rounded-b-md shadow-sm ring-1 ring-gray-950/5 overflow-hidden mb-6">
            <div class="h-3 w-full" style="background-color: #B1CF6F;"></div>
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $form->title }}</h1>
                @if($form->description)
                    <p class="text-gray-600 text-sm whitespace-pre-line mt-3">{{ $form->description }}</p>
                @endif
                <div class="mt-6 pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between text-xs text-gray-500 space-y-2 sm:space-y-0">
                    <div><span class="font-medium text-gray-700">School:</span> {{ $form->school->name }}</div>
                    @if($form->tour_date)
                        <div><span class="font-medium text-gray-700">Tour Date:</span> {{ $form->tour_date->format('M d, Y') }}</div>
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
        @elseif($alreadySubmitted)
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 p-8 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900">You've already responded</h3>
                <p class="mt-2 text-sm text-gray-500">You can only fill out this form once.</p>
            </div>
        @else
            <!-- Form -->
            <form wire:submit="submit" class="space-y-6">
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

                @foreach($form->questions as $index => $question)
                    <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 p-6 md:p-8" wire:key="question-{{ $question->id }}">
                        <label class="block text-base font-medium text-gray-900 mb-1">
                            {{ $question->question }} <span class="text-red-500 ml-1">*</span>
                        </label>
                        
                        @error("answers.{$question->id}")
                            <p class="text-xs text-red-500 mt-1 mb-3 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror

                        <div class="mt-4">
                            @if($question->type === 'text')
                                <input type="text" wire:model="answers.{{ $question->id }}" class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#50A7AF] sm:text-sm sm:leading-6">
                            
                            @elseif($question->type === 'textarea')
                                <textarea wire:model="answers.{{ $question->id }}" rows="3" class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#50A7AF] sm:text-sm sm:leading-6"></textarea>
                            
                            @elseif($question->type === 'dropdown')
                                <select wire:model="answers.{{ $question->id }}" class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#50A7AF] sm:text-sm sm:leading-6">
                                    <option value="">Select an option</option>
                                    @if(is_array($question->choices))
                                        @foreach($question->choices as $choice)
                                            <option value="{{ $choice }}">{{ $choice }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            
                            @elseif($question->type === 'room_partner')
                                <select wire:model="answers.{{ $question->id }}" class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#50A7AF] sm:text-sm sm:leading-6">
                                    <option value="">Select a partner</option>
                                    @php $available = $this->getAvailablePartners($question); @endphp
                                    @foreach($available as $choice)
                                        <option value="{{ $choice }}">{{ $choice }}</option>
                                    @endforeach
                                </select>
                                @if(empty($available))
                                    <p class="text-xs text-amber-600 mt-2 font-medium">All options have been picked.</p>
                                @endif
                                
                            @elseif($question->type === 'radio')
                                <div class="space-y-3">
                                    @if(is_array($question->choices))
                                        @foreach($question->choices as $choice)
                                            <div class="flex items-center">
                                                <input id="radio-{{ $question->id }}-{{ $loop->index }}" type="radio" wire:model="answers.{{ $question->id }}" value="{{ $choice }}" class="h-4 w-4 border-gray-300 text-[#13432D] focus:ring-[#50A7AF]">
                                                <label for="radio-{{ $question->id }}-{{ $loop->index }}" class="ml-3 block text-sm font-medium leading-6 text-gray-900">{{ $choice }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                
                            @elseif($question->type === 'checkbox')
                                <div class="space-y-3">
                                    @if(is_array($question->choices))
                                        @foreach($question->choices as $choice)
                                            <div class="flex items-center">
                                                <input id="check-{{ $question->id }}-{{ $loop->index }}" type="checkbox" wire:model="answers.{{ $question->id }}" value="{{ $choice }}" class="h-4 w-4 rounded border-gray-300 text-[#13432D] focus:ring-[#50A7AF]">
                                                <label for="check-{{ $question->id }}-{{ $loop->index }}" class="ml-3 block text-sm font-medium leading-6 text-gray-900">{{ $choice }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="flex items-center justify-between pt-2">
                    <button type="submit" class="inline-flex justify-center rounded-md bg-[#13432D] py-2.5 px-6 text-sm font-semibold text-white shadow-sm hover:bg-[#13432D]/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#13432D] transition-colors">
                        Submit Form
                    </button>
                    <span class="text-xs font-medium text-gray-400">Powered by <span class="text-[#B1CF6F]">Kencana Wisata</span></span>
                </div>
            </form>
        @endif
    </div>
</div>
