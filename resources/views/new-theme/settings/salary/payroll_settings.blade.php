@extends('new-theme.layout.layout1',['showSettingMenu'=>true])
@push('styles')
    <link rel="stylesheet" href="{{ asset('new-theme/styles/settings.css') }}"/>
@endpush

@section('content')
    <div class="salaryPage">
        <div class="pageS1">
            @component("new-theme.settings.salary.components.tabs")
                @slot("active","payroll")
                <div class="tab-pane show active" id="Payroll" role="tabpanel" aria-labelledby="Payroll-tab">
                    <form action="{{ route("payroll_setting.store") }}" method="post" class="formS1">
                        @csrf
                        <div class='sectionS2'>
                            <div class="head withBorder flex align between">
                                <h3 class='small'>@lang("Payslip Columns")</h3>
                                <button class='buttonS1 primary' type="button" data-bs-toggle="modal" data-bs-target="#addNewPayroll">
                                    <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.580872 7C0.580872 6.68934 0.869747 6.4375 1.22609 6.4375H15.4209C15.7773 6.4375 16.0662 6.68934 16.0662 7C16.0662 7.31066 15.7773 7.5625 15.4209 7.5625H1.22609C0.869747 7.5625 0.580872 7.31066 0.580872 7Z"
                                            fill="white" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.32352 0.25C8.67986 0.25 8.96874 0.50184 8.96874 0.8125V13.1875C8.96874 13.4982 8.67986 13.75 8.32352 13.75C7.96717 13.75 7.6783 13.4982 7.6783 13.1875V0.8125C7.6783 0.50184 7.96717 0.25 8.32352 0.25Z"
                                            fill="white" />
                                    </svg>
                                    @lang('Add New')
                                </button>
                            </div>

                            <div class="content">
                                <div class="row">
                                    @foreach($payroll_settings as $payroll_setting)
                                        <div class="col-lg-6">
                                            <label class="inputCheckbox" for="payroll_reports_view_{{ $payroll_setting->id }}">
                                                <input 
                                                    {{ $payroll_setting->payroll_dispaly ? "checked" : "" }}
                                                    type="checkbox" 
                                                    id="payroll_reports_view_{{ $payroll_setting->id }}" 
                                                    name="payroll_dispaly[{{ $payroll_setting->id }}]">
                                                <p>@lang($payroll_setting->name)</p>
                                            </label>
                                        </div>
                                    @endforeach
                                    
                                    
                                </div>
                            </div>
                        </div>

                        <div class="flex align end gap-15 mt-4">
                            <button class="buttonS1 rejected" type="button" data-bs-dismiss="modal" aria-label="Close">
                                Cancel
                            </button>
                            <button class="buttonS1 primary" type="submit">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            @endcomponent
        </div>
    </div>

    <!-- Add New Payroll Modal -->
    <div class="modal fade customeModal" id="addNewPayroll" tabindex="-1" aria-labelledby="addNewPayrollLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="formS1" method="post" action="{{ route('paysliptype.store') }}">
                        @csrf
                        <div class="sectionS2">
                            <div class="head withBorder flex align between">
                                <h3 class='small'>@lang('Add New Payroll type')</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="content">
                                <div class="">
                                    <label for="paySlipType" class="form-label">@lang('Payroll type')</label>
                                    <div class="inputS1">
                                        <input name="name_ar" value="{{ old('name_ar') }}" type="text" id="paySlipType"
                                            placeholder='@lang('Enter Payroll type')'>
                                    </div>
                                </div>

                                <div class="flex align end gap-15 orders  mt-5 mb-4">
                                    <button class="buttonS1 rejected" type="button" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        @lang('Cancel')
                                    </button>
                                    <button class="buttonS1 primary" type="submit">
                                        @lang('Save')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
