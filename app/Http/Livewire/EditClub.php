<?php

namespace App\Http\Livewire;

use App\Models\Club;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class EditClub extends ModalComponent
{

    public Club $club;

    public function mount(Club $club)
    {
        // Gate::authorize('update', $club);

        $this->club = $club;
    }


    public function render()
    {
        return view('livewire.edit-club');
    }

    public function update()
    {
        $this->validate([
            'club.name' => 'required',
        ]);
        
        $this->club->update($this->club->toArray());
        
    }
}
