<?php

namespace App\Livewire\Team;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;

class PersonalTodos extends Component
{
    public $tasks;
    public $allTasks;
    public $users;
    public $filters = [
        'user' => '',
        'status' => '',
        'priority' => '',
    ];
    public string $selectedTaskId = '';

    // Array to store possible priorities for tasks
    public array $priorities = ['Low', 'Medium', 'High', 'Critical'];

    // Array to store possible statuses for tasks
    public array $statuses = ['Pending', 'In Progress', 'Completed', 'Overdue', 'Cancelled'];

    protected $listeners = ['updateTasksTable' => '$refresh'];

    // Method to handle filter updates
    public function updatedFilters(): void
    {
        $this->applyFilters();
    }

    // Method to apply all filters
    public function applyFilters(): void
    {
        $filteredTasks = $this->allTasks;

        if ($this->filters['user']) {
            $filteredTasks = $filteredTasks->filter(fn($task) => $task->assigned_to == $this->filters['user']);
        }

        if ($this->filters['status']) {
            $filteredTasks = $filteredTasks->filter(fn($task) => $task->status == $this->filters['status']);
        }

        if ($this->filters['priority']) {
            $filteredTasks = $filteredTasks->filter(fn($task) => $task->priority == $this->filters['priority']);
        }

        $this->tasks = $filteredTasks;
    }

    // Method to set priority color
    public function setPriorityColor($priority): string
    {
        return match ($priority) {
            'Medium' => 'bg-green-300 text-green-700', // Lighter green for medium priority
            'Low' => 'bg-yellow-300 text-yellow-700', // Lighter yellow for low priority
            'High' => 'bg-red-100 text-red-400', // Strong red for high priority
            'Critical' => 'bg-red-300 text-red-700', // Darker red for critical priority
            default => 'bg-gray-300', // Default fallback gray
        };
    }

    // Method to set status color
    public function setStatusColor($status): string
    {
        return match ($status) {
            'Completed' => ' bg-green-500 ',
            'In Progress' => 'bg-blue-300 ',
            'Pending' => 'bg-yellow-400 ',
            'Overdue' => 'bg-red-500',
            'Cancelled' => 'bg-red-200',
            default => 'text-gray-500',
        };
    }

    /**
     * This method is called when the component is first mounted.
     *
     * @return void
     */
    public function mount(): void
    {
        // Fetch all tasks with their related project and user.
        $this->allTasks = Task::with('assignedToUser')
            ->where('status', ['overdue', 'pending', 'in progress'])
            ->orWhereDate('due_date', now()->toDateString())
            ->orderBy('due_date', 'asc')
            ->get();

        // Fetch all users
        $this->users = User::all();

        $this->filters['user'] = auth()->user()->id;

        $this->applyFilters();
    }

    // Method to open the creation task modal
    public function openCreateTaskModal($taskId = null): void
    {
        $this->dispatch('openCreateTaskModal', taskId: $taskId);
    }

    public function render()
    {
        return view('livewire.team.personal-todos');
    }
}
