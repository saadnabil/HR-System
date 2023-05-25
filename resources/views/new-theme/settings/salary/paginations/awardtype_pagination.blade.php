@foreach($awardtypes as $awardtype)
    <tr>
        <td>{{ $awardtype->id }}</td>
        <td>{{ $awardtype->{"name".$lang} }}</td>
        <td>
            <div class='action flex gap-3'>
                <div data-bs-toggle="modal" data-bs-target="#editAwardType-{{$awardtype->id}}">
                    <img src="{{ asset("new-theme/icons/all/edit.svg") }}" alt="" />
                </div>
                <div data-bs-toggle="modal" data-bs-target="#delete-{{ $awardtype->id }}">
                    <img src="{{ asset("new-theme/icons/all/delete.svg") }}" alt="" />
                </div>
            </div>
            @include("new-theme.settings.salary.components.editAwardtypeModel")
            @include("new-theme.settings.salary.components.deleteAwardtypeModal")
        </td>
    </tr>
@endforeach