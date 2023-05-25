@foreach ($companies as $company)
    <tr>
        <td>{{ $company->id }}</td>
        <td>{{ $company->name }}</td>
        <td>
            <div class='action flex gap-3'>
                <div data-bs-toggle="modal" data-bs-target="#editInsurance-{{ $company->id }}">
                    <img src="{{ asset('new-theme/icons/all/edit.svg') }}" alt="" />
                </div>
                <div data-bs-toggle="modal" data-bs-target="#delete-{{ $company->id }}">
                    <img src="{{ asset('new-theme/icons/all/delete.svg') }}" alt="" />
                </div>
            </div>
            @include('new-theme.settings.insurance-companies.components.editModal')
            @include('new-theme.settings.insurance-companies.components.deleteModel')
        </td>
    </tr>
@endforeach