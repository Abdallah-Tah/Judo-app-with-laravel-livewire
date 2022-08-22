<?php

namespace App\Http\Livewire;

use App\Models\Club;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class DeleteClub extends ModalComponent
{
    public ?int $clubId = null;

    public array $clubIds = [];

    public string $confirmationTitle = '';

    public string $confirmationDescription = '';

    public $name;

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }

    public function cancel()
    {
        $this->closeModal();
    }

    public function confirm()
    {
        if ($this->clubId) {
            Club::query()->find($this->clubId)->delete();
        }

        if ($this->clubIds) {
            Club::query()->whereIn('id', $this->clubIds)->delete();
        }

        if ($this->name) {
            Club::query()->where('name', 'like', '%' . $this->name . '%')->delete();
        }

        $this->closeModalWithEvents([
            'pg:eventRefresh-default',
        ]);
    }

    public function render()
    {
        return view('livewire.delete-club');
    }
}
