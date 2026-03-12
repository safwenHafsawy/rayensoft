<?php

namespace App\Livewire\Messages;

use App\Models\Message;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class MessageTable extends Component
{

    use WithPagination;

    public $messageIdToDelete;

    public string $search = '';

    public function confirmDeleteMessage($messageId): void
    {
        $this->messageIdToDelete = $messageId;
    }

    public function destroyMessage(): void
    {
        Message::find($this->messageIdToDelete)->delete();
        $this->reset('messageIdToDelete');
    }

    public function closeModal(): void
    {
        $this->reset('messageIdToDelete');
    }

    public function limit_words($text, $limit = 100): string
    {
        $words = explode(' ', $text); // turn string into array
        return implode(' ', array_slice($words, 0, $limit)) . (count($words) > $limit ? '...' : ''); //splits the array takes the needed words
    }


    public function render(): Factory|View
    {
        return view('livewire.messages.message-table', [
            'messages' => Message::where('fullname', 'like', '%' . $this->search . '%')->orderBy('created_at', 'desc')->paginate(20),
        ]);
    }
}
