@foreach($paymenttypes as $paymenttype)
    <tr>
        <td>{{ $paymenttype->id }}</td>
        <td>{{ $paymenttype->{"name"} }}</td>
        <td>
            <div class='action flex gap-3'>
                <div data-bs-toggle="modal" data-bs-target="#editPaymentType-{{$paymenttype->id}}">
                    <img src="{{ asset("new-theme/icons/all/edit.svg") }}" alt="" />
                </div>
                <div data-bs-toggle="modal" data-bs-target="#confirm1" class="delete" data-route="{{ route('paymenttype.destroy' , $paymenttype->id) }}">
                    <img src="{{ asset("new-theme/icons/all/delete.svg") }}" alt="" />
                </div>
            </div>
            @include("new-theme.settings.salary.components.editPaymenttypeModel")
        </td>
    </tr>
@endforeach