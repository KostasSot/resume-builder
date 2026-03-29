<div class="flex flex-col min-h-screen bg-gray-50 w-full overflow-hidden">

    <div class="lg:hidden flex p-4 bg-white border-b border-gray-200 justify-center space-x-4 w-full shrink-0">
        <button wire:click="$set('activeTab', 'editor')" class="cursor-pointer px-4 py-2 rounded-md font-medium w-1/2 transition-colors {{ $activeTab === 'editor' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Edit</button>
        <button wire:click="$set('activeTab', 'preview')" class="cursor-pointer px-4 py-2 rounded-md font-medium w-1/2 transition-colors {{ $activeTab === 'preview' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Preview</button>
    </div>

    <div class="flex-1 grid grid-cols-1 lg:grid-cols-2 h-[calc(100vh-73px)] lg:h-screen w-full">

        <div class="{{ $activeTab === 'editor' ? 'block' : 'hidden' }} lg:block h-full overflow-y-auto p-4 sm:p-6 lg:p-10 border-r border-gray-200 bg-white w-full">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Personal Details</h2>

            <div class="mb-8 p-4 sm:p-6 bg-blue-50 border-2 border-dashed border-blue-300 rounded-lg w-full transition-all hover:bg-blue-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 cursor-pointer relative">
                <div class="flex-1 w-full">
                    <h3 class="font-bold text-blue-900 text-lg">Import Existing CV</h3>
                    <p class="text-sm text-blue-700">Upload a PDF to extract your details automatically.</p>
                </div>
                <div class="relative w-full sm:w-auto shrink-0">
                    <input type="file" wire:model="resumeUpload" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                    <div class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-md shadow-sm flex justify-center items-center gap-2 w-full transition-colors relative z-0 cursor-pointer">
                        <svg wire:loading wire:target="resumeUpload" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>

                        <span wire:loading.remove wire:target="resumeUpload">Choose PDF</span>
                        <span wire:loading wire:target="resumeUpload">Reading File...</span>
                    </div>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center w-full transition-all">
                    <svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-medium">{{ session('message') }}</span>
                </div>
            @endif

            <div class="mb-8 flex flex-col sm:flex-row justify-end w-full gap-4">

                <button wire:click="save" class="cursor-pointer w-full sm:w-auto bg-white border border-blue-600 text-blue-600 hover:bg-blue-50 font-bold py-3 px-8 rounded-md shadow-sm transition-all flex justify-center items-center gap-2">
                    <svg wire:loading wire:target="save" class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Save Progress</span>
                </button>

                <button wire:click="downloadPdf" class="cursor-pointer w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-md shadow-md transition-all flex justify-center items-center gap-2">
                    <svg wire:loading wire:target="downloadPdf" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <svg wire:loading.remove wire:target="downloadPdf" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span>Download PDF</span>
                </button>

            </div>

            <form class="space-y-6 w-full">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" wire:model.live="firstName" class="block w-full rounded-md border-gray-300 border px-4 py-2 focus:border-blue-500 focus:ring-blue-500 outline-none transition-all">
                    </div>
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" wire:model.live="lastName" class="block w-full rounded-md border-gray-300 border px-4 py-2 focus:border-blue-500 focus:ring-blue-500 outline-none transition-all">
                    </div>
                </div>
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                    <input type="text" wire:model.live="jobTitle" class="block w-full rounded-md border-gray-300 border px-4 py-2 focus:border-blue-500 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Professional Summary</label>
                    <textarea wire:model.live="summary" rows="3" class="block w-full rounded-md border-gray-300 border px-4 py-2 focus:border-blue-500 focus:ring-blue-500 outline-none transition-all"></textarea>
                </div>

                <hr class="my-8 border-gray-200 w-full">

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 w-full gap-4">
                    <h2 class="text-2xl font-bold text-gray-800">Work Experience</h2>
                    <button type="button" wire:click="addExperience" class="cursor-pointer text-sm bg-blue-100 text-blue-700 font-semibold py-2 px-4 rounded-md hover:bg-blue-200 transition-colors w-full sm:w-auto">
                        + Add Job
                    </button>
                </div>

                @foreach($experiences as $index => $experience)
                    <div class="p-4 sm:p-6 bg-gray-50 border border-gray-200 rounded-lg space-y-4 mb-4 relative w-full">

                        <button type="button" wire:click="removeExperience({{ $index }})" class="cursor-pointer absolute top-4 right-4 text-red-500 hover:text-red-700 font-bold p-1">
                            &times;
                        </button>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pr-6 w-full">
                            <div class="w-full">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Company</label>
                                <input type="text" wire:model.live="experiences.{{ $index }}.company" class="block w-full rounded-md border-gray-300 border px-3 py-2 text-sm outline-none focus:border-blue-500">
                            </div>
                            <div class="w-full">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Position</label>
                                <input type="text" wire:model.live="experiences.{{ $index }}.position" class="block w-full rounded-md border-gray-300 border px-3 py-2 text-sm outline-none focus:border-blue-500">
                            </div>
                        </div>

                        <div class="w-full">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Duration (e.g. Jan 2020 - Present)</label>
                            <input type="text" wire:model.live="experiences.{{ $index }}.duration" class="block w-full rounded-md border-gray-300 border px-3 py-2 text-sm outline-none focus:border-blue-500">
                        </div>

                        <div class="w-full">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                            <textarea wire:model.live="experiences.{{ $index }}.description" rows="3" class="block w-full rounded-md border-gray-300 border px-3 py-2 text-sm outline-none focus:border-blue-500"></textarea>
                        </div>
                    </div>
                @endforeach
            </form>
        </div>

        <div class="{{ $activeTab === 'preview' ? 'block' : 'hidden' }} lg:block h-full overflow-y-auto bg-gray-300 p-4 sm:p-8 flex justify-center items-start w-full">

            <div class="bg-white shadow-2xl w-full max-w-[210mm] min-h-[297mm] flex flex-col mx-auto overflow-hidden shrink-0">
                <div class="bg-gray-900 text-white p-6 sm:p-8 w-full">
                    <h1 class="text-3xl sm:text-4xl font-bold uppercase tracking-wide break-words">
                        {{ $firstName ?: 'First' }} <span class="text-blue-400">{{ $lastName ?: 'Last' }}</span>
                    </h1>
                    <p class="text-lg text-gray-300 mt-2 font-light">{{ $jobTitle ?: 'Professional Title' }}</p>
                </div>

                <div class="p-6 sm:p-8 w-full flex-1 bg-white">
                    @if($summary)
                        <div class="mb-8 w-full">
                            <h2 class="text-xl font-bold text-gray-800 uppercase tracking-wide border-b-2 border-blue-500 inline-block mb-4">Profile</h2>
                            <p class="text-gray-600 leading-relaxed whitespace-pre-wrap w-full">{{ $summary }}</p>
                        </div>
                    @endif

                    <div class="w-full">
                        <h2 class="text-xl font-bold text-gray-800 uppercase tracking-wide border-b-2 border-blue-500 inline-block mb-4">Experience</h2>

                        <div class="space-y-6 w-full">
                            @foreach($experiences as $exp)
                                @if($exp['company'] || $exp['position'])
                                    <div class="flex flex-col sm:flex-row w-full">
                                        <div class="w-full sm:w-1/4 text-sm text-gray-500 font-medium mb-1 sm:mb-0 pr-4">
                                            {{ $exp['duration'] ?: 'Start - End' }}
                                        </div>
                                        <div class="w-full sm:w-3/4">
                                            <h3 class="font-bold text-gray-900 text-lg">{{ $exp['position'] ?: 'Job Title' }}</h3>
                                            <p class="text-sm font-semibold text-blue-600 mb-2">{{ $exp['company'] ?: 'Company Name' }}</p>
                                            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap w-full">{{ $exp['description'] }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
