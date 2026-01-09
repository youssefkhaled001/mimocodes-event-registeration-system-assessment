<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="bg-neutral-secondary-soft border-b border-default">
            <tr>
                @foreach($columns as $column)
                <th scope="col" class="px-6 py-3 font-medium">
                    {{ $column }}
                </th>
                @endforeach
                @if($actions)
                <th scope="col" class="px-6 py-3 font-medium">
                    Actions
                </th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $index => $row)
            <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default">
                @foreach($row as $cell)
                <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    @if(is_array($cell))
                        <div class="px-2 py-1 capitalize text-xs rounded-full flex justify-center" style="background-color: {{ $cell['color'] }}; color: {{ $cell['text_color']??'white' }}">
                            {{ $cell['text'] }}
                        </div>
                    @else
                        {{ $cell }}
                    @endif
                </td>
                @endforeach
                @if(!empty($actions))
                <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    @foreach($actions as $action)
                    @php
                        $url = route($action['url'], $ids[$index]);
                        $method = $action['method'] ?? 'get';
                    @endphp
                    @if($method == 'get')
                    <a href="{{ $url }}" class="text-primary hover:text-primary-hover mr-3 bg-transparent border-0 cursor-pointer underline">
                        {{ $action['label'] }}
                    </a>
                    @else
                    <button type="button" 
                            onclick="openDeleteModal('{{ $url }}', '{{ $method }}')" 
                            class="text-red-600 hover:text-red-800 mr-3 bg-transparent border-0 cursor-pointer underline">
                        {{ $action['label'] }}
                    </button>
                    @endif
                    @endforeach
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Include reusable delete modal -->
<x-delete-modal modal-id="deleteModal" />
            