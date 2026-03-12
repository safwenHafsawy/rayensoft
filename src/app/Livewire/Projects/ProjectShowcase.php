<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class ProjectShowcase extends Component
{
    public function render()
    {
        return view('livewire.projects.project-showcase', [
            'projects' => Project::with('client.lead')->orderBy('created_at', 'desc')->get()
        ]);
    }
}
