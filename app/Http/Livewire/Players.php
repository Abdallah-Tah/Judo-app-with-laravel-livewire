<?php

namespace App\Http\Livewire;

use App\Models\Club;
use App\Models\Player;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Players extends Component
{
    use WithPagination, WithFileUploads;
    public $playerId, $name, $dob, $club_id, $address, $phone, $email, $user_id, $photo;
    public $clubs;

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
        $this->PlayerId = $id;
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
        $this->name = Player::where('user_id', auth()->id())->where('id', $id)->first()->name;
        $this->modalConfirmDeleteVisible = true;
        $this->resetInput();
    }


    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        Player::destroy($this->playerId );
        $this->modalConfirmDeleteVisible = false;
         session()->flash('message', 'Player Deleted Successfully.');
    }

    /**
     * loadPlayer
     *
     * @return void
     */
    public function loadPlayer()
    {
        $Player = Player::where('user_id', auth()->user()->id)->find($this->PlayerId);
        $this->name = $Player->name;
        $this->dob = $Player->dob;
        $this->club_id = $Player->club_id;
        $this->address = $Player->address;
        $this->phone = $Player->phone;
        $this->email = $Player->email;
        $this->user_id = $Player->user_id;
        $this->photo = $Player->photo;
    }

    /**
     * createPlayer
     *
     * @return void
     */
    public function createPlayer()
    {
        $this->validate([
            'name' => 'required|string|max:70',
            'dob' => 'required|date',
            'address' => 'required|string|max:70',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:70|unique:players',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $Player = new Player();
        $Player->name = $this->name;
        $Player->dob = $this->dob;
        $Player->club_id = $this->club_id;
        $Player->address = $this->address;
        $Player->phone = $this->phone;
        $Player->email = $this->email;
        $Player->user_id = auth()->user()->id;
        $Player->photo = $this->photo->store('public');
        $Player->save();
       // Player::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetInput();
        $this->resetPage();
    }



    /**
     * read
     *
     * @return void
     */
    public function getPlayers()
    {
        return Player::where('user_id', auth()->user()->id)->paginate(10);
    }


   /*  public function modelData()
    {
        return [
            'name' => $this->name,
            'dob' => $this->dob,
            'club_id' => $this->club_id,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'user_id' => auth()->user()->id,
            'photo' => $this->photo,
        ];
    } */

    /**
     * resetInput
     *
     * @return void
     */
    public function resetInput()
    {
        $this->PlayerId = null;
        $this->name = null;
        $this->user_id = null;
        $this->dob = null;
        $this->club_id = null;
        $this->address = null;
        $this->phone = null;
        $this->email = null;
        $this->photo = null;
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
        return view('livewire.players', [
            'players' => $this->getPlayers(),
            'clubs' => Club::all(),
        ]);
    }
}
