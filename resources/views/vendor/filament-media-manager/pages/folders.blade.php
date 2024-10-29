
<div class="grid grid-cols-1 gap-4 p-4 md:grid-cols-3">
    @foreach($records as $item)
        {{ ($this->folderAction($item))(['record' => $item]) }}
    @endforeach
</div>
