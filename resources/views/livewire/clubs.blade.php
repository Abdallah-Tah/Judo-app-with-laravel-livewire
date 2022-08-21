<div class="p-6">
    
    <div class="flex justify-end items-center px-4 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal">
            {{ __('Create Club') }}
        </x-jet-button>
    </div>



    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 text-center">
            <tr>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Create At') }}
                </th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Name') }}
                </th>
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($clubs->count())
                @foreach ($clubs as $club)
                    <tr>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $club->created_at }}</td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $club->name }}</td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">
                            <x-jet-button wire:click="editShowModal({{ $club->id }})" wire:loading.attr="disabled">
                                {{ __('Edit') }}
                            </x-jet-button>
                            <x-jet-danger-button wire:click="deleteShowModal({{ $club->id }})" wire:loading.attr="disabled">
                                {{ __('Delete') }}
                            </x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center-sm whitespace-nowrap">No clubs found.</td>
                </tr>
            @endif
        </tbody>
    </table>
    <br />
    {{ $clubs->links() }}










    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Club') }} {{ $clubId }}
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
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @if ($clubId)
                <x-jet-button class="ml-2" wire:click="updateClub" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-button>
            @else
                <x-jet-button class="ml-2" wire:click="createClub" wire:loading.attr="disabled">
                    {{ __('Create') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>


    {{-- The Delete Modal --}}

    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Club') }}
        </x-slot>

        <x-slot name="content">
            {{ __("Are you sure you want to delete this")}} {{$name }} {{ __("? Once the club is deleted, all of its resources and data will be permanently deleted.") }}
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
