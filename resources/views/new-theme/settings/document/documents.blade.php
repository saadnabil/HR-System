@foreach($documents as $document)
    <tr>
        <td>{{ $document['name'.$lang] }}</td>
        <td>{{ $document->documentType ? $document->documentType['name'.$lang] : "N/A" }}</td>
        <td>
            <div class='action flex gap-3'>
                <div>
                    <a href="{{ route('document.edit', $document->id) }}">
                        <img src="{{ asset('new-theme/icons/all/edit.svg') }}" alt="" />
                    </a>
                </div>

                <div>
                    <img data-bs-toggle="modal" data-bs-target="#confirm1" class="delete" data-route="{{ route('document.destroy', $document->id) }}" src="/new-theme/icons/all/delete.svg" />
                </div>
            </div>
        </td>
    </tr>
@endforeach