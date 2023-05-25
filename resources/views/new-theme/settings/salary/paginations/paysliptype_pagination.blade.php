@foreach ($paysliptypes as $paysliptype)
    <tr>
        <td>{{ $paysliptype->id }}</td>
        <td>{{ $paysliptype->{'name' . $lang} }}</td>
        <td>
            <div class='action flex gap-3'>
                <div data-bs-toggle="modal"
                     data-bs-target="#editPaySlip-{{ $paysliptype->id }}">
                    <img src="{{ asset('new-theme/icons/all/edit.svg') }}" alt="" />
                </div>
                <div data-bs-toggle="modal" data-bs-target="#delete-{{ $paysliptype->id }}">
                    <img src="{{ asset('new-theme/icons/all/delete.svg') }}"
                         alt="" />
                </div>
            </div>
            @include('new-theme.settings.salary.components.editPaysliptypeModel')
            @include('new-theme.settings.salary.components.deletePaysliptypeModal')
        </td>
    </tr>
@endforeach