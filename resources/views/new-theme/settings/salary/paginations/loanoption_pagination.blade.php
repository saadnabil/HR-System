@foreach($loanoptions as $loanoption)
    <tr>
        <td>{{ $loanoption->id }}</td>
        <td>{{ $loanoption->{"name".$lang} }}</td>
        <td>
            <div class='action flex gap-3'>
                <div data-bs-toggle="modal" data-bs-target="#editLoanOption-{{$loanoption->id}}">
                    <img src="{{ asset("new-theme/icons/all/edit.svg") }}" alt="" />
                </div>
                <div >
                    <img data-bs-toggle="modal" data-bs-target="#confirm1" class="delete" data-route="{{ route('loanoption.destroy' , $loanoption->id) }}" src="{{ asset("new-theme/icons/all/delete.svg") }}" alt="" />
                </div>
            </div>
            @include("new-theme.settings.salary.components.editLoanOptionModel")
        </td>
    </tr>
@endforeach