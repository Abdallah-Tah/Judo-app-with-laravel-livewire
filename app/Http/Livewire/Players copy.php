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
    public $playerId, $name, $dob, $club_id, $address, $phone, $email, $user_id;
    public $clubs;

    public $isOpen = false;
    public $modalConfirmDeleteVisible = false;
    public $photo = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        return view('livewire.players', [
            'players' => Player::paginate(10),
            'clubs' => $this->loadClub(),
        ]);
    }



    /**
     * Loads the club data into the form.
     *
     * @return void
     */
    public function loadClub()
    {
        $this->clubs = Club::where('user_id', auth()->id())->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function editShowModal($id)
    {
        $this->playerId = $id;
        $this->modalFormVisible = true;
        $this->players = Player::where('user_id', auth()->user()->id)->find($id);
        $this->resetInputFields();
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function deleteShowModal($id)
    {
        $this->playerId = $id;
        $this->name = Player::where('user_id', auth()->id())->where('id', $id)->first()->name;
        $this->modalConfirmDeleteVisible = true;
        $this->resetInputFields();
        
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields()
    {
        $this->name = '';
        $this->dob = '';
        $this->club_id = '';
        $this->address = '';
        $this->phone = '';
        $this->email = '';
        $this->photo = '';
        $this->user_id = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:70',
            'dob' => 'required|date',
            'address' => 'required|string|max:70',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:70|unique:players',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //$filename = $this->photo->getClientOriginalName();
        //$image = $this->photo->store('assets/images', 'public');

        Player::create(['id' => $this->playerId], [
            'name' => $this->name,
            'dob' => $this->dob,
            'club_id' => intval($this->club_id),
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'photo' => $this->photo->store('public'),
            'user_id' => auth()->id(),
        ]);

        session()->flash(
            'message',
            $this->playerId ? 'Player Updated Successfully.' : 'Player Created Successfully.'
        );

        $this->closeModal();
        $this->resetInputFields();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $player = Player::findOrFail($id);
        $this->post_id = $id;
        $this->name = $player->name;
        $this->dob = $player->dob;
        $this->club_id = $player->club_id;
        $this->address = $player->address;
        $this->phone = $player->phone;
        $this->email = $player->email;
        $this->photo = $player->photo;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete()
    {
       Player::destroy($this->playerId );
       $this->modalConfirmDeleteVisible = false;
        session()->flash('message', 'Player Deleted Successfully.');
    }
}
