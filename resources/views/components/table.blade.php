<div class="relative overflow-x-auto rounded-lg border border-white/[0.08]">
    <table class="w-full text-sm text-left">
        <thead class="bg-white/[0.02] border-b border-white/[0.08]">
            <tr>
                @foreach($columns as $column)
                <th scope="col" class="px-6 py-4 font-medium text-white/70 uppercase tracking-wider text-xs">
                    {{ $column }}
                </th>
                @endforeach
                @if($actions)
                <th scope="col" class="px-6 py-4 font-medium text-white/70 uppercase tracking-wider text-xs">
                    Actions
                </th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $index => $row)
            <tr class="border-b border-white/[0.05] hover:bg-white/[0.02] transition-colors"
                @if(isset($dataAttributes[$index]))
                    @foreach($dataAttributes[$index] as $key => $value)
                        {{ $key }}="{{ $value }}"
                    @endforeach
                @endif>
                @foreach($row as $cell)
                <td class="px-6 py-4 text-white/80 whitespace-nowrap">
                    @if(is_array($cell))
                        <div class="px-2 py-1 capitalize text-xs rounded-full flex justify-center" style="background-color: {{ $cell['color'][$cell['text']] }}; color: {{ $cell['text_color'][$cell['text']]??'white' }}">
                            {{ $cell['text'] }}</div>
                    @else
                        {{ $cell }}
                    @endif
                </td>
                @endforeach
                @if(!empty($actions))
                <td class="px-6 py-4 whitespace-nowrap flex gap-1">
                    @foreach($actions as $action)
                    @if(isset($action['onclick']))
                        <button type="button" 
                                data-action="{{ $action['onclick'] }}"
                                data-id="{{ $ids[$index] }}"
                                title="{{ $action['label'] ?? '' }}"
                                class="text-cyan-400 hover:text-cyan-300 mr-3 bg-transparent border-0 cursor-pointer transition-colors {{ isset($action['icon']) || isset($action['icon_name']) ? '' : 'underline' }}">
                            @if(isset($action['icon_name']))
                                <x-icon :name="$action['icon_name']" />
                            @else
                                {!! $action['icon'] ?? $action['label'] !!} <!-- Show HTML Element or Label if not using predefined icons -->
                            @endif
                        </button>
                    @else
                        @php
                            $url = route($action['url'], $ids[$index]);
                            $method = $action['method'] ?? 'get';
                        @endphp
                        @if($method == 'get')
                        <a href="{{ $url }}" 
                           title="{{ $action['label'] ?? '' }}"
                           class="text-cyan-400 hover:text-cyan-300 mr-3 transition-colors {{ isset($action['icon']) || isset($action['icon_name']) ? '' : 'underline' }}">
                            @if(isset($action['icon_name']))
                                <x-icon :name="$action['icon_name']" />
                            @else
                                {!! $action['icon'] ?? $action['label'] !!}
                            @endif
                        </a>
                        @else
                        <button type="button" 
                                onclick="openDeleteModal('{{ $url }}', '{{ $method }}')" 
                                title="{{ $action['label'] ?? '' }}"
                                class="text-red-400 hover:text-red-300 mr-3 bg-transparent border-0 cursor-pointer transition-colors {{ isset($action['icon']) || isset($action['icon_name']) ? '' : 'underline' }}">
                            @if(isset($action['icon_name']))
                                <x-icon :name="$action['icon_name']" />
                            @else
                                {!! $action['icon'] ?? $action['label'] !!}
                            @endif
                        </button>
                        @endif
                    @endif
                    @endforeach
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>