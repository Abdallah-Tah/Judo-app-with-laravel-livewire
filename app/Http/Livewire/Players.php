<?php

namespace App\Http\Livewire;

use App\Models\Player;
use Livewire\Component;
use Livewire\WithPagination;

class Players extends Component
{
    use WithPagination;
    public $name;
    public $user_id;
    public $playerId;
   

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
     * @param  mixed $Player
     * @return void
     */
    public function editShowModal($id)
    {
        $this->playerId = $id;
        $this->modalFormVisible = true;
        $this->loadPlayer();
    }


    /**
     * Shows the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->playerId = $id;
        $this->name = Player::find($id)->name;
        $this->modalConfirmDeleteVisible = true;
    }


    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        Player::destroy($this->playerId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();

        session()->flash('message', 'The Player has been deleted.');
    }
  
    /**
     * loadPlayer
     *
     * @return void
     */
    public function loadPlayer()
    {
        $Player = Player::where('user_id', auth()->user()->id)->find($this->playerId);
        $this->name = $Player->name;
    }

    /**
     * createPlayer
     *
     * @return void
     */
    public function createPlayer()
    {
        $this->validate($this->rules());
        Player::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetInput();
    }


    
    /**
     * read
     *
     * @return void
     */
    public function getPlayers()
    {
        return Player::paginate(10);
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
        $this->playerId = null;
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
        return view('livewire.players',[
            'players' => $this->getPlayers(),
        ]);
    }
}
