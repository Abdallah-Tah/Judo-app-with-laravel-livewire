<div class="p-6">
    
    <div class="flex justify-end items-center px-4 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal">
            {{ __('Create Player') }}
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
                <th
                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Address') }}
                </th>
                
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
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $player->created_at }}</td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">
                            <img src="{{ $player->photo }}" alt="{{ $player->name }}" class="w-full h-full object-cover">
                        </td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $player->name }}</td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $player->phone }}</td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $player->email }}</td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $player->club->name }}</td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">{{ $player->address }}</td>
                        <td class="px-6 py-4 text-center-sm whitespace-nowrap">
                            <x-jet-button wire:click="editShowModal({{ $player->id }})" wire:loading.attr="disabled">
                                {{ __('Edit') }}
                            </x-jet-button>
                            <x-jet-danger-button wire:click="deleteShowModal({{ $player->id }})" wire:loading.attr="disabled">
                                {{ __('Delete') }}
                            </x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center-sm whitespace-nowrap">No players found.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

