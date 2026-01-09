<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($events->count() > 0)
                        <x-table 
                            :columns="['Title', 'Description', 'Location', 'Date', 'Status', 'Price']"
                            :rows="$events->map(fn($event) => [
                                $event->title,
                                \Str::limit($event->description, 50),
                                $event->location,
                                $event->date_time->format('M d, Y g:i A'),
                                [
                                    'text'=>$event->status,
                                    'color'=>$event->status=='published'?'#cbffc2ff':
                                    ($event->status=='cancelled'?'#ffcfb8ff': 
                                    ($event->status=='draft'?'#D4D4D4':
                                    '#ABF1FF')), 
                                    'text_color'=>$event->status=='published'?'#18A300':
                                    ($event->status=='cancelled'?'#FF5500':
                                    ($event->status=='draft'?'black':
                                    '#099BB8'))
                                ],
                                $event->price > 0 ? '$' . number_format($event->price, 2) : 'FREE',
                            ])->toArray()"
                            :actions="[
                                [
                                    'label'=>'Edit',
                                    'url'=>'edit.event'
                                ],
                                [
                                    'label'=>'Delete',
                                    'url'=>'delete.event',
                                    'method'=>'delete'
                                ]
                            ]"
                            :ids="$events->pluck('id')->toArray()"
                           
                        />
                        
                        <div class="mt-4">
                            {{ $events->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No events found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>