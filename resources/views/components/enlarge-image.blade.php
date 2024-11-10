@if ($getRecord() && $getRecord()->image)
    @php
        // If the database only stores the filename, use this:
        $imageUrl = asset('storage/' . $getRecord()->image);
        
        // If the database stores the full path, use this instead:
        // $imageUrl = asset('storage/' . $getRecord()->image);
    @endphp
    <div x-data="{ isOpen: false }">
        <!-- Thumbnail Image -->
        <img src="{{ $imageUrl }}" alt="Announcement Image" class="w-32 h-auto cursor-pointer rounded-lg" @click="isOpen = true">

        <!-- Modal for Enlarged Image -->
        <div x-show="isOpen" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75">
            <div class="relative">
                <button @click="isOpen = false" class="absolute top-0 right-0 text-white text-2xl p-2">&times;</button>
                <img src="{{ $imageUrl }}" alt="Enlarged Image" class="max-w-full max-h-screen rounded-lg">
            </div>
        </div>
    </div>
@else
    <p>No image uploaded</p>
@endif
