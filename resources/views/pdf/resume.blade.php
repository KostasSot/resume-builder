<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resume</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white m-0 p-0">
    <div class="w-[210mm] min-h-[297mm] flex flex-col mx-auto overflow-hidden">

        <div class="bg-gray-900 text-white p-8 w-full">
            <h1 class="text-4xl font-bold uppercase tracking-wide break-words">
                {{ $firstName ?: 'First' }} <span class="text-blue-400">{{ $lastName ?: 'Last' }}</span>
            </h1>
            <p class="text-lg text-gray-300 mt-2 font-light">{{ $jobTitle ?: 'Professional Title' }}</p>
        </div>

        <div class="p-8 w-full flex-1 bg-white">
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
                            <div class="flex flex-row w-full">
                                <div class="w-1/4 text-sm text-gray-500 font-medium pr-4">
                                    {{ $exp['duration'] ?: 'Start - End' }}
                                </div>
                                <div class="w-3/4">
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
</body>
</html>
