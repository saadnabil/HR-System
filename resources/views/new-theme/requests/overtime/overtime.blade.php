@foreach ($overtimerequests as $value => $overtimerequest)
    <tr data-row-key="{{ $value }}" class="ant-table-row ant-table-row-level-0">
        <td class="tooltipS1" data-bs-toggle="offcanvas" data-bs-target="#id{{ $value }}" aria-controls="id1">
            <div class="tooltip">{{ __('View Details') }}</div>
            <div class="userTabl user">
                <img src="/new-theme/icons/all/user.svg" />
            </div>
        </td>
        <td class="tooltipS1" data-bs-toggle="offcanvas" data-bs-target="#id{{ $value }}"
            aria-controls="id{{ $value }}">
            <div class="tooltip">{{ __('View Details') }}</div>
            {{ auth()->user()->employeeIdFormat($overtimerequest->employee?->id) }}
        </td>

        <td class="tooltipS1" data-bs-toggle="offcanvas" data-bs-target="#id{{ $value }}"
            aria-controls="id{{ $value }}">
            <div class="tooltip">{{ __('View Details') }}</div>
            {{ app()->isLocale('ar') ? $overtimerequest->employee?->name_ar : $overtimerequest->employee?->name }}
        </td>

        <td class="tooltipS1" data-bs-toggle="offcanvas" data-bs-target="#id{{ $value }}"
            aria-controls="id{{ $value }}">
            <div class="tooltip">{{ __('View Details') }}</div>
            {{ $overtimerequest->employee?->jobtitle ? $overtimerequest->employee?->jobtitle['name' . $lang] : 'N/A' }}
        </td>


        <td class="tooltipS1" data-bs-toggle="offcanvas" data-bs-target="#id{{ $value }}" aria-controls="id1">
            <div class="tooltip">{{ __('View Details') }}</div>{{ $overtimerequest->date }}
        </td>
        @php
            $minutes = Carbon\Carbon::parse($overtimerequest->end)->diffInMinutes(Carbon\Carbon::parse($overtimerequest->start));
        @endphp
        <td class="tooltipS1" data-bs-toggle="offcanvas" data-bs-target="#id{{ $value }}"
            aria-controls="id{{ $value }}">
            {{ $minutes }} {{ $minutes > 1 ? __('Minutes') : __('Minute') }} <p>
                {{ __('From') . ' ' . $overtimerequest->start . ' ' . __('To') . ' ' . $overtimerequest->end }}
            </p>
            <div class="tooltip">{{ __('View Details') }}</div>
        </td>
        <td class="tooltipS1" data-bs-toggle="offcanvas" data-bs-target="#id{{ $value }}"
            aria-controls="id{{ $value }}">
            @php
                $status_class_array = [
                    'approved' => 'success',
                    'pending' => 'pending',
                    'rejected' => 'danger',
                ];
                $status_translate_array = [
                    'approved' => __('Approved'),
                    'pending' => __('Pending'),
                    'rejected' => __('Rejected'),
                ];
            @endphp
            <div class="buttonS2  {{ $status_class_array[$overtimerequest->status] }}">
                {{ $status_translate_array[$overtimerequest->status] }}
            </div>
            <div class="tooltip">{{ __('View Details') }}</div>
        </td>
        <td>

            <div class="actions flex gap-3">
                @if ($overtimerequest->status == 'pending')
                    @can('OverTime-Accept')
                        <a href="{{ route('over-time.accept', $overtimerequest->id) }}"
                            class="buttonS1 primary">{{ __('Accept') }}</a>
                    @endcan
                    @can('OverTime-Reject')
                        <a href="{{ route('over-time.reject', $overtimerequest->id) }}" class="buttonS1 rejected reject-button"
                            data-bs-toggle="modal" data-bs-target="#addNewDocument">{{ __('Reject') }}</a>
                    @endcan
                @else
                    N/A
                @endif
            </div>

        </td>
    </tr>


    <div style="width: 470px;" class="offcanvas offcanvas-end" tabindex="-1" id="id{{ $value }}"
        aria-labelledby="id1Label">
        <div class=" drawerS1">
            <div class="head_ flex align between">
                <div class="flex align gap-25">
                    <div class="" data-bs-dismiss="offcanvas" aria-label="Close">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.29289 5.29289C6.68342 4.90237 7.31658 4.90237 7.70711 5.29289L17.7071 15.2929C18.0976 15.6834 18.0976 16.3166 17.7071 16.7071L7.70711 26.7071C7.31658 27.0976 6.68342 27.0976 6.29289 26.7071C5.90237 26.3166 5.90237 25.6834 6.29289 25.2929L15.5858 16L6.29289 6.70711C5.90237 6.31658 5.90237 5.68342 6.29289 5.29289Z"
                                fill="black" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M16.2929 5.29289C16.6834 4.90237 17.3166 4.90237 17.7071 5.29289L27.7071 15.2929C28.0976 15.6834 28.0976 16.3166 27.7071 16.7071L17.7071 26.7071C17.3166 27.0976 16.6834 27.0976 16.2929 26.7071C15.9024 26.3166 15.9024 25.6834 16.2929 25.2929L25.5858 16L16.2929 6.70711C15.9024 6.31658 15.9024 5.68342 16.2929 5.29289Z"
                                fill="black" />
                        </svg>
                    </div>
                    <h3>{{ __('View Details') }}</h3>
                </div>
                <div class="flex gap-15">
                    <div>
                        <img src="/new-theme/icons/all/print.svg" alt="" />
                    </div>
                    <div>
                        <img src="/new-theme/icons/all/download.svg" alt="" />
                    </div>
                </div>
            </div>

            <div class="contentDrawer scroll">
                <div class="sectionHistory sectionDDS1 section">
                    <div data-bs-toggle="collapse" data-bs-target="#employeeInformation" aria-expanded="true"
                        aria-controls="employeeInformation">
                        <div class="ant-collapse">
                            <div class="ant-collapse-header" aria-expanded="true" aria-disabled="false" role="button"
                                tabindex="0">
                                <div class="ant-collapse-expand-icon">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1"
                                        viewBox="0 0 17 17" class="ant-collapse-arrow" height="1em" width="1em"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g></g>
                                        <path
                                            d="M12.146 6.146l0.707 0.707-4.353 4.354-4.354-4.353 0.707-0.707 3.647 3.646 3.646-3.647zM17 8.5c0 4.687-3.813 8.5-8.5 8.5s-8.5-3.813-8.5-8.5 3.813-8.5 8.5-8.5 8.5 3.813 8.5 8.5zM16 8.5c0-4.136-3.364-7.5-7.5-7.5s-7.5 3.364-7.5 7.5 3.364 7.5 7.5 7.5 7.5-3.364 7.5-7.5z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="ant-collapse-header-text">{{ __('Employee Details') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="collapse show" id="employeeInformation">
                        <div class="cards">
                            <div class="cardS1 flex align">
                                <div class="name">{{ __('Name') }}</div>
                                <div class="des">
                                    {{ app()->isLocale('ar') ? $overtimerequest->employee?->name_ar : $overtimerequest->employee?->name }}
                                </div>
                            </div>
                            <div class="cardS1 flex align">
                                <div class="name">{{ __('Code') }}</div>
                                <div class="des">
                                    {{ auth()->user()->employeeIdFormat($overtimerequest->employee?->id) }}</div>
                            </div>
                            <div class="cardS1 flex align">
                                <div class="name">{{ __('Job Title') }}</div>
                                <div class="des">
                                    {{ $overtimerequest->employee?->jobtitle ? $overtimerequest->employee?->jobtitle['name' . $lang] : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="sectionDDS1 section pb-0">
                    <div class="ant-collapse flex align between">
                        <span class="ant-collapse-header-text">{{ __('Request Details') }}</span>
                        <div class="flex gap-15">
                            @can('OverTime-Edit')
                                <div data-bs-toggle="offcanvas" data-bs-target="#edit{{ $value }}"
                                    aria-controls="edit1">
                                    <img src="/new-theme/icons/edit.svg" alt="" />
                                </div>
                            @endcan

                            @can('OverTime-Delete')
                                <img src="/new-theme/icons/delete.svg" alt="" />
                            @endcan
                        </div>
                    </div>

                </div>

                <div class="sectionDDS1 section py-0" style="border: none">
                    <div class="cards">
                        <div class="cardS1 flex align">
                            <div class="name">{{ __('Date') }}</div>
                            <div class="des">{{ $overtimerequest->date }}</div>
                        </div>
                        <div class="cardS1 flex align">
                            <div class="name">{{ __('Time') }}</div>
                            <div class="des">{{ $overtimerequest->get_time_format() }}</div>
                        </div>
                        <div class="cardS1 flex align">
                            <div class="name">{{ __('Status') }}</div>
                            <div class="buttonS2  {{ $status_class_array[$overtimerequest->status] }} small">
                                {{ $status_translate_array[$overtimerequest->status] }}</div>
                        </div>
                        <div class="cardS1 flex align">
                            <div class="name">{{ __('Reason') }}</div>
                            <div class="des">{{ $overtimerequest->message ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div style="width: 470px;" class="offcanvas offcanvas-end" tabindex="-1" id="edit{{ $value }}"
        aria-labelledby="edit1Label">
        <div class=" drawerS1">
            <div class="head_ flex align between">
                <div class="flex align gap-25">
                    <div class="" data-bs-dismiss="offcanvas" aria-label="Close">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.29289 5.29289C6.68342 4.90237 7.31658 4.90237 7.70711 5.29289L17.7071 15.2929C18.0976 15.6834 18.0976 16.3166 17.7071 16.7071L7.70711 26.7071C7.31658 27.0976 6.68342 27.0976 6.29289 26.7071C5.90237 26.3166 5.90237 25.6834 6.29289 25.2929L15.5858 16L6.29289 6.70711C5.90237 6.31658 5.90237 5.68342 6.29289 5.29289Z"
                                fill="black" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M16.2929 5.29289C16.6834 4.90237 17.3166 4.90237 17.7071 5.29289L27.7071 15.2929C28.0976 15.6834 28.0976 16.3166 27.7071 16.7071L17.7071 26.7071C17.3166 27.0976 16.6834 27.0976 16.2929 26.7071C15.9024 26.3166 15.9024 25.6834 16.2929 25.2929L25.5858 16L16.2929 6.70711C15.9024 6.31658 15.9024 5.68342 16.2929 5.29289Z"
                                fill="black" />
                        </svg>
                    </div>
                    <h3>{{ __('Request Details') }}</h3>
                </div>
                <div class="flex gap-15">
                    <div>
                        <img src="/new-theme/icons/all/print.svg" alt="" />
                    </div>
                    <div>
                        <img src="/new-theme/icons/all/download.svg" alt="" />
                    </div>
                </div>
            </div>

            <div class="contentDrawer scroll">
                <div class="sectionHistory sectionDDS1 section">
                    <div data-bs-toggle="collapse" data-bs-target="#employeeInformationEdit" aria-expanded="true"
                        aria-controls="employeeInformationEdit">
                        <div class="ant-collapse">
                            <div class="ant-collapse-header" aria-expanded="true" aria-disabled="false"
                                role="button" tabindex="0">
                                <div class="ant-collapse-expand-icon">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1"
                                        viewBox="0 0 17 17" class="ant-collapse-arrow" height="1em" width="1em"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g></g>
                                        <path
                                            d="M12.146 6.146l0.707 0.707-4.353 4.354-4.354-4.353 0.707-0.707 3.647 3.646 3.646-3.647zM17 8.5c0 4.687-3.813 8.5-8.5 8.5s-8.5-3.813-8.5-8.5 3.813-8.5 8.5-8.5 8.5 3.813 8.5 8.5zM16 8.5c0-4.136-3.364-7.5-7.5-7.5s-7.5 3.364-7.5 7.5 3.364 7.5 7.5 7.5 7.5-3.364 7.5-7.5z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="ant-collapse-header-text">Employee Details</span>
                            </div>
                        </div>
                    </div>

                    <div class="collapse show" id="employeeInformationEdit">
                        <div class="cards">
                            <div class="cardS1 flex align">
                                <div class="name">{{ __('Name') }}</div>
                                <div class="des">
                                    {{ app()->isLocale('ar') ? $overtimerequest->employee?->name_ar : $overtimerequest->employee?->name }}
                                </div>
                            </div>
                            <div class="cardS1 flex align">
                                <div class="name">{{ __('Code') }}</div>
                                <div class="des">
                                    {{ auth()->user()->employeeIdFormat($overtimerequest->employee?->id) }}</div>
                            </div>
                            <div class="cardS1 flex align">
                                <div class="name">{{ __('Job Title') }}</div>
                                <div class="des">
                                    {{ $overtimerequest->employee?->jobtitle ? $overtimerequest->employee?->jobtitle['name' . $lang] : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="sectionDDS1 section pb-0">
                    <div class="ant-collapse flex align between">
                        <span class="ant-collapse-header-text">{{ __('Request Details') }}</span>
                        <div>
                            <img src="/new-theme/icons/delete.svg" alt="" />
                        </div>
                    </div>

                </div>

                <div class="sectionDDS1 section py-0" style="border: none">
                    <form class="ajax-submit" action="{{ route('over-time.update', $overtimerequest->id) }}"
                        method="post">
                        @csrf
                        @method('put')
                        <div class="cardS1 datePicker my-4">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <div class="inputS1">
                                <select name="employee_id" required>
                                    <option value="">{{ __('Select') }}</option>
                                    @foreach ($employees as $employee)
                                        <option
                                            {{ $employee?->id == old('employee_id', $overtimerequest->employee_id) ? 'selected' : '' }}
                                            value="{{ $employee?->id }}">
                                            {{ app()->isLocale('en') ? $employee?->name : $employee?->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @include('new-theme.components.error1', ['error' => 'employee_id'])
                        </div>
                        <div class="cardS1 my-4">
                            <div class="name mb-3">{{ __('Date') }}</div>
                            <div class="inputS1">
                                <img src="/new-theme/icons/date.svg" class="iconImg" />
                                <input value="{{ Carbon\Carbon::parse($overtimerequest->date)->format('d/m/Y') }}"
                                    type="text" value="" placeholder="Set The Date" name="date"
                                    class="datePickerBasic" autocomplete="off" />
                            </div>
                        </div>
                        @include('new-theme.components.error1', ['error' => 'date'])
                        <div class="cardS1 my-4">
                            <div class="name mb-3">{{ __('Start Time') }}</div>
                            <div class="inputS1">
                                <img src="/new-theme/icons/clock.svg" class="iconImg" />
                                <input type="text"
                                    value="{{ Carbon\Carbon::parse($overtimerequest->start)->format('H:i') }}"
                                    placeholder="{{ __('Set Start Time') }}" name="start" class="time-pickable"
                                    autocomplete="off" />
                            </div>
                        </div>
                        @include('new-theme.components.error1', ['error' => 'start'])
                        <div class="cardS1 my-4">
                            <div class="name mb-3">{{ __('End Time') }}</div>
                            <div class="inputS1">
                                <img src="/new-theme/icons/clock.svg" class="iconImg" />
                                <input type="text"
                                    value="{{ Carbon\Carbon::parse($overtimerequest->end)->format('H:i') }}"
                                    placeholder="{{ __('Set Start Time') }}" name="end" class="time-pickable"
                                    autocomplete="off" />
                            </div>
                        </div>
                        @include('new-theme.components.error1', ['error' => 'end'])
                        <div class="cardS1  my-4">
                            <div class="name mb-3">{{ __('Reason') }}</div>
                            <div class="inputS1">
                                <input name="reason" type="text" value="{{ $overtimerequest->reason }}"
                                    placeholder="{{ __('Set The Reason') }}" />
                            </div>
                        </div>
                        @include('new-theme.components.error1', ['error' => 'reason'])
                        <div class="cardS1 my-4">
                            <div class="name mb-3">{{ __('Status') }}</div>
                            <div class="inputS1">
                                <select id="changeStatus" name="status">
                                    <option value="pending"
                                        {{ $overtimerequest->status == 'pending' ? 'selected' : '' }}>
                                        {{ __('Pending') }}</option>
                                    <option value="approved"
                                        {{ $overtimerequest->status == 'approved' ? 'selected' : '' }}>
                                        {{ __('Approved') }}</option>
                                    <option value="rejected"
                                        {{ $overtimerequest->status == 'rejected' ? 'selected' : '' }}>
                                        {{ __('Rejected') }}</option>
                                </select>
                            </div>
                        </div>
                        @include('new-theme.components.error1', ['error' => 'status'])
                        <div class="cardS1 my-4" id="statusReason" style="display: none;">
                            <div class="name mb-3">{{ __('Reject Reason') }}</div>
                            <div class="inputS1">
                                <input name="admin_message" type="text" value=""
                                    placeholder="{{ __('Set The Reject Reason') }}" />
                            </div>
                        </div>
                        @include('new-theme.components.error1', ['error' => 'admin_message'])

                        <div class="flex align end gap-15 my-5">
                            <button class="buttonS1 rejected" type="button" data-bs-dismiss="offcanvas"
                                aria-label="Close">
                                {{ __('Cancel') }}
                            </button>
                            <button class="buttonS1 primary" type="submit">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
@endforeach
@push('script')
<script>
$('.reject-button').click(function(){
    var action = $(this).attr('href');
    $('.reject-form').attr('action', action);
});
</script>
@endpush
