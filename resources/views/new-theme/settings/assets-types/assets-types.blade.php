@foreach ($types as $type)
    <tr>
        <td>{{ $type->id }}</td>
        <td>{{ $type->name }}</td>
        <td>
            <div class='action flex gap-3'>
                <div data-bs-toggle="modal" data-bs-target="#editInsurance-{{ $type->id }}">
                    <img src="{{ asset('new-theme/icons/all/edit.svg') }}" alt="" />
                </div>
                <div data-bs-toggle="modal" data-bs-target="#delete-{{ $type->id }}">
                    <img src="{{ asset('new-theme/icons/all/delete.svg') }}" alt="" />
                </div>
            </div>
            @include('new-theme.settings.assets-types.components.editModal')
            @include('new-theme.settings.assets-types.components.deleteModel')
        </td>
    </tr>
@endforeach