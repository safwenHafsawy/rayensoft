<?php

namespace App\Livewire\Modals;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ZoomPicture extends Component
{
    public bool $isOpen = false;
    public string $imagePath = "";

    protected $listeners = ['showZoomPicture' => 'openModal'];

    public function openModal($imagePath): void
    {
        $this->imagePath = $imagePath;
        $this->isOpen = true;
    }

    public function closeModal(): void
    {
        $this->imagePath = "";
        $this->isOpen = false;
    }

    public function render(): Factory|View
    {
        return view('livewire.modals.zoom-picture');
    }
}
