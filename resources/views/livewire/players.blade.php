<div class="p-6">

    <div class="flex justify-end items-center px-4 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal">
            {{ __('Create Player') }}
        </x-jet-button>
    </div>
    <div>
        @if (session()->has('message'))
            <div class="bg-teal-100 rounded-b text-teal-900 px-4 py-4 shadow-md my-3" role="alert">
                <div class="flex">
                    <div>
                        <h4>{{ session('message') }}</h4>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <br />
    <table class="min-w-full divide-y divide-gray-200 scrollbar-custom">
        <thead>
            <tr>
                {{-- <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Create At') }}
                </th> --}}
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Photo') }}
                </th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Name') }}
                </th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Phone') }}
                </th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Email') }}
                </th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Club') }}
                </th>
                {{-- <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Address') }}
                </th> --}}
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($players->count())
                @foreach ($players as $player)
                    <tr>
                        {{-- <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $player->created_at }}
                        </td> --}}
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">

                            @if ($player->photo)
                                @if (file_exists(url('storage/' . $player->photo)))
                                    <img src="{{ url("/storage/{$player->photo}") }}" alt="{{ $player->name }}"
                                        class="rounded-full h-20 w-20 object-cover">
                                @else
                                    <img src="{{ $player->photo }}" alt="{{ $player->name }}"
                                        class="rounded-full h-20 w-20 object-cover">
                                    {{-- <img src="{{ url("/storage/{$player->photo}") }}" alt="{{ $player->name }}"
                                    class="rounded-full h-20 w-20 object-cover"> --}}
                                @endif
                            @else
                                <img src="{{ url('/storage/no-image.png') }}" alt="{{ $player->name }}"
                                    class="rounded-full h-8 w-8">
                            @endif

                        </td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $player->name }}</td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $player->phone }}
                        </td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $player->email }}
                        </td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">
                            {{ $player->club->name }}</td>
                        {{-- <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $player->address }}
                        </td> --}}
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">
                            <x-jet-button wire:click="editShowModal({{ $player->id }})" wire:loading.attr="disabled">
                                {{ __('Edit') }}
                            </x-jet-button>
                            <x-jet-danger-button wire:click="deleteShowModal({{ $player->id }})"
                                wire:loading.attr="disabled">
                                {{ __('Delete') }}
                            </x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="4">No players
                        found.</td>
                </tr>
            @endif
        </tbody>
    </table>
    <br />
    <div class="mt-5">
        {{ $players->links() }}
    </div>

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Player') }} {{ $playerId }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model.debounce.500ms="name"
                    name="name" required autofocus />
                @error('name')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="phone" value="{{ __('Phone') }}" />
                <x-jet-input id="phone" class="block mt-1 w-full" type="text" wire:model.debounce.500ms="phone"
                    name="phone" required autofocus />
                @error('phone')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="text" wire:model.debounce.500ms="email"
                    name="email" required autofocus />
                @error('email')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="club_id" value="{{ __('Club') }}" />
                <select wire:model="club_id" id="club_id" class="block mt-1 w-full" name="club_id"
                    class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    @php
                        $clubs = App\Models\Club::where('user_id', Auth::user()->id)->get();
                    @endphp
                    <option value="">-- Select a club --</option>
                    @foreach ($clubs as $key => $value)
                        <option value="{{ $key }}">{{ $value->name }}</option>
                    @endforeach
                    @error('club')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </select>
            </div>
            <div class="mt-4">
                <x-jet-label for="address" value="{{ __('Address') }}" />
                <x-jet-input id="address" class="block mt-1 w-full" type="text" wire:model.debounce.500ms="address"
                    name="address" required autofocus />
                @error('address')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="dob" value="{{ __('Birthday') }}" />
                <x-jet-input id="dob" class="block mt-1 w-full" type="date" wire:model.debounce.500ms="dob"
                    name="dob" required autofocus />
                @error('dob')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="photo" value="{{ __('Photo') }}" />
                <x-jet-input id="photo" class="block mt-1 w-full" type="file" wire:model.debounce.500ms="photo"
                    name="photo" required autofocus />
                @error('photo')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @if ($playerId)
                <x-jet-button class="ml-2" wire:click="updatePlayer" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-button>
            @else
                <x-jet-button class="ml-2" wire:click="createPlayer" wire:loading.attr="disabled">
                    {{ __('Create') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Player') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this Player') }} <strong>{{ $name }}</strong>
            {{ __('? Once the Player is deleted, all of its resources and data will be permanently deleted.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>










</div>
