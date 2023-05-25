@foreach ($departments as $department)
    <tr>
        <td>{{ $department->{'name' . $lang} }}</td>
        <td>{{ $department->branch ? $department->branch->name : 'N/A' }}</td>
        <td>{{ $department->manager ? $department->manager->name : 'N/A' }}</td>
        <td>{{ $department->employeess_count }}</td>
        <td>
            <div class='action flex gap-3'>
                <div data-bs-toggle="modal"
                     data-bs-target="#editDepartment-{{ $department->id }}">
                    <img src="{{ asset('new-theme/icons/all/edit.svg') }}" alt="" />
                </div>
                <div data-bs-toggle="modal" data-bs-target="#delete-{{ $department->id }}">
                    <img src="{{ asset('new-theme/icons/all/delete.svg') }}"
                         alt="" />
                </div>
            </div>
            @include('new-theme.settings.branch.components.editDepartmentModel')
            @include('new-theme.settings.branch.components.deleteDepartmentModal')
        </td>
    </tr>
@endforeach