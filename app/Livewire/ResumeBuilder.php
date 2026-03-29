<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // <-- Add this import
use App\Models\Resume;
use App\Models\Experience;
use Spatie\LaravelPdf\Facades\Pdf;
use Smalot\PdfParser\Parser; // <-- Add this import

class ResumeBuilder extends Component
{
    use WithFileUploads; // <-- Add the trait here

    public $activeTab = 'editor';
    public $resumeId = null;

    // File upload property
    public $resumeUpload;

    public $firstName = '';
    public $lastName = '';
    public $jobTitle = '';
    public $summary = '';
    public $experiences = [];

    public function mount(Resume $resume = null)
    {
        if ($resume && $resume->exists) {
            $this->resumeId = $resume->id;
            $this->firstName = $resume->first_name;
            $this->lastName = $resume->last_name;
            $this->jobTitle = $resume->job_title;
            $this->summary = $resume->summary;

            if ($resume->experiences->count() > 0) {
                $this->experiences = $resume->experiences->toArray();
            } else {
                $this->addExperience();
            }
        } else {
            $this->addExperience();
        }
    }

    // Runs automatically the moment a user selects a file
    public function updatedResumeUpload()
    {
        $this->validate([
            'resumeUpload' => 'required|mimes:pdf|max:5120',
        ]);

        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($this->resumeUpload->getRealPath());
        $extractedText = $pdf->getText();

        // 1. Break the raw text into an array of individual lines, removing empty spaces
        $lines = array_values(array_filter(explode("\n", str_replace("\r", "", $extractedText)), fn($line) => trim($line) !== ''));

        if (count($lines) === 0) {
            session()->flash('message', 'Could not read text from this PDF.');
            $this->resumeUpload = null;
            return;
        }

        // 2. Map the top section (Line 0 is Name, Line 1 is Job Title)
        $nameParts = explode(' ', $lines[0], 2);
        $this->firstName = trim($nameParts[0] ?? '');
        $this->lastName = trim($nameParts[1] ?? '');
        $this->jobTitle = trim($lines[1] ?? '');

        // 3. Find where the PROFILE and EXPERIENCE sections start
        $profileIndex = array_search('PROFILE', $lines);
        $experienceIndex = array_search('EXPERIENCE', $lines);

        // 4. Map the Professional Summary
        if ($profileIndex !== false && $experienceIndex !== false) {
            $summaryLines = array_slice($lines, $profileIndex + 1, $experienceIndex - $profileIndex - 1);
            $this->summary = trim(implode("\n", $summaryLines));
        }

        // 5. Map the Work Experiences
        if ($experienceIndex !== false) {
            $this->experiences = []; // Clear the default blank job
            $expLines = array_slice($lines, $experienceIndex + 1);

            // Our specific PDF template groups job details in blocks of 4 lines
            $chunks = array_chunk($expLines, 4);
            foreach ($chunks as $chunk) {
                if (count($chunk) >= 2) {
                    $this->experiences[] = [
                        'duration' => trim($chunk[0] ?? ''),
                        'position' => trim($chunk[1] ?? ''),
                        'company' => trim($chunk[2] ?? ''),
                        'description' => trim($chunk[3] ?? ''),
                    ];
                }
            }
        }

        // Always ensure there is at least one experience block so the UI doesn't break
        if (empty($this->experiences)) {
             $this->addExperience();
        }

        // Clean up the upload input
        $this->resumeUpload = null;

        // Let the user know it worked
        session()->flash('message', 'CV Imported Successfully! You can now edit it.');
    }

    public function addExperience()
    {
        $this->experiences[] = [
            'company' => '',
            'position' => '',
            'duration' => '',
            'description' => ''
        ];
    }

    public function removeExperience($index)
    {
        unset($this->experiences[$index]);
        $this->experiences = array_values($this->experiences);
    }

    public function save()
    {
        $isNew = is_null($this->resumeId);

        $resume = Resume::updateOrCreate(
            ['id' => $this->resumeId],
            [
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'job_title' => $this->jobTitle,
                'summary' => $this->summary,
            ]
        );

        $this->resumeId = $resume->id;

        $resume->experiences()->delete();

        foreach ($this->experiences as $exp) {
            if (!empty($exp['company']) || !empty($exp['position'])) {
                $resume->experiences()->create([
                    'company' => $exp['company'],
                    'position' => $exp['position'],
                    'duration' => $exp['duration'],
                    'description' => $exp['description'],
                ]);
            }
        }

        session()->flash('message', 'Resume saved successfully!');

        if ($isNew) {
            return redirect()->to('/' . $resume->id);
        }
    }

    public function downloadPdf()
    {
        // Generate the PDF directly from the current typed data
        $fileName = ($this->firstName ?: 'My') . '_Resume.pdf';
        $tempPath = storage_path('app/' . $fileName);

        Pdf::view('pdf.resume', [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'jobTitle' => $this->jobTitle,
            'summary' => $this->summary,
            'experiences' => $this->experiences,
        ])
        ->format('a4')
        ->save($tempPath);

        // Download and clean up
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    public function render()
    {
        return view('livewire.resume-builder');
    }
}
