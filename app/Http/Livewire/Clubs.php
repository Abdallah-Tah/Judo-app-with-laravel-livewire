<?php

namespace App\Http\Livewire;

use App\Models\Club;
use Livewire\Component;
use Livewire\WithPagination;

class Clubs extends Component
{
    use WithPagination;
    public $name;
    public $user_id;
    public $clubId;
   

    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;


    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:70',
        ];
    }

    /**
     * showNodalForm
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->resetInput();
        $this->modalFormVisible = true;
    }
    
    /**
     * updateShowModal
     *
     * @param  mixed $club
     * @return void
     */
    public function editShowModal($id)
    {
        $this->clubId = $id;
        $this->modalFormVisible = true;
        $this->loadClub();
    }


    /**
     * Shows the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->clubId = $id;
        $this->name = Club::find($id)->name;
        $this->modalConfirmDeleteVisible = true;
    }


    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        Club::destroy($this->clubId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();

        session()->flash('message', 'The club has been deleted.');
    }
  
    /**
     * loadClub
     *
     * @return void
     */
    public function loadClub()
    {
        $club = Club::where('user_id', auth()->user()->id)->find($this->clubId);
        $this->name = $club->name;
    }

    /**
     * createClub
     *
     * @return void
     */
    public function createClub()
    {
        $this->validate($this->rules());
        Club::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetInput();
    }


    
    /**
     * read
     *
     * @return void
     */
    public function getClubs()
    {
        return Club::paginate(10);
    }


    public function modelData()
    {
        return [
            'name' => $this->name,
            'user_id' => auth()->user()->id,
        ];
    }

    /**
     * resetInput
     *
     * @return void
     */
    public function resetInput()
    {
        $this->clubId = null;
        $this->name = null;
        $this->user_id = null;
    }

    /**
     * resetValidation
     *
     * @return void
     */
    public function resetValidations()
    {
        $this->rules();
    }

    public function mount()
    {
        $this->resetInput();
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.clubs', [
            'clubs' => $this->getClubs(),
        ]);
    }
}
