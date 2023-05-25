 @foreach ($templates as $template)
 <tr>
    <td>
        #{{ $template -> id }}
    </td>
    <td>{{ $template -> name }}</td>
    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d' , $template -> date ) -> format('Y/m/d')  }}</td>
    <td>
        <div class='action flex gap-3'>
            <div>
                <a href="{{ route('contract-templates.edit' , $template) }}"><img src="/new-theme/icons/all/edit.svg" alt="" /></a>
            </div>
            <div data-bs-toggle="modal" data-bs-target="#confirm1" class="delete" data-route="{{ route('contract-templates.destroy' , $template) }}">
                <img src="/new-theme/icons/all/delete.svg" alt="" />
            </div>
        </div>
    </td>
</tr>
 @endforeach
