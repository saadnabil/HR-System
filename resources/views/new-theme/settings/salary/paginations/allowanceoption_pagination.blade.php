@foreach ($allowanceoptions as $allowanceoption)
    <tr>
        <td>{{ $allowanceoption->id }}</td>
        <td>{{ $allowanceoption->{'name' . $lang} }}</td>
        <td>
            <div class='action flex gap-3'>
                <div data-bs-toggle="modal"
                     data-bs-target="#editAllawance-{{ $allowanceoption->id }}">
                    <img src="{{ asset('new-theme/icons/all/edit.svg') }}" alt="" />
                </div>
                <div data-bs-toggle="modal"
                     data-bs-target="#delete-{{ $allowanceoption->id }}">
                    <img src="{{ asset('new-theme/icons/all/delete.svg') }}"
                         alt="" />
                </div>
            </div>
            @include('new-theme.settings.salary.components.editAllowanceoptionModel')
            @include('new-theme.settings.salary.components.deleteAllowanceoptionModal')
        </td>
    </tr>
@endforeach