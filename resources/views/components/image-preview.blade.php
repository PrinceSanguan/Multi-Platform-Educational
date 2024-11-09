@php
    $fileUrl = $getState(); // Retrieve the file URL/path
@endphp

@if($fileUrl)
    @if(str_ends_with($fileUrl, '.pdf'))
        <iframe src="{{ Storage::url($fileUrl) }}" width="100%" height="500px"></iframe>
    @elseif(Str::startsWith(mime_content_type(storage_path('app/' . $fileUrl)), 'image/'))
        <img src="{{ Storage::url($fileUrl) }}" alt="Activity Image" style="max-width: 100%; height: auto;">
    @else
        <a href="{{ Storage::url($fileUrl) }}" target="_blank" class="text-blue-500 underline">Download File</a>
    @endif
@else
    <p>No image uploaded.</p>
@endif