@extends('layouts.admin')

@section('page-title')
    {{ __('Manage employee request') }}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @if(auth()->user()->type == 'employee')
            @can('Create Leave')
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                    <a href="#" data-url="{{ route('employee_requests.create') }}" class="btn btn-primary btn-icon-only width-auto"
                        data-ajax-popup="true" data-title="{{ __('Create New Request') }}">
                        <i class="fa fa-plus"></i> {{ __('Create') }}
                    </a>
                </div>
            @endcan
        @endif
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5></h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables" >
                            
                            <thead>
                                <tr>
                                    @if (auth()->user()->type != 'employee')
                                        <th>{{ __('Employee') }}</th>
                                    @endif
                                    <th>{{ __('Request_type') }}</th>
                                    <th>{{ __('Request Date') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Request Reason') }}</th>
                                    <th>{{ __('status') }}</th>
                                    <th width="5%">{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($leaves as $leave)
                                    <tr>
                                        @if (auth()->user()->type != 'employee')
                                            <td>{{ !empty(auth()->user()->getEmployee($leave->employee_id)) ? auth()->user()->getEmployee($leave->employee_id)->name : '' }}
                                            </td>
                                        @endif
                                        <td>{{ $leave->requestType['name'.$lang] }}
                                        </td>
                                        <td>{{ auth()->user()->dateFormat($leave->applied_on) }}</td>
                                        <td>{{ auth()->user()->dateFormat($leave->start_date) }}</td>
                                        <td>{{ auth()->user()->dateFormat($leave->end_date) }}</td>
                                        <td>{{ $leave['request_reason'.$lang] }}</td>
                                        <td style="text-align: center;">
                                            @if($leave->status == 0)
                                                <div class="badge badge-pill badge-warning">{{ __('Pending') }}</div>
                                            @elseif($leave->status == 1)
                                                <div class="badge badge-pill badge-success">{{ __('Approve By Department Manager') }}</div>
                                            @elseif($leave->status == 2)
                                                <div class="badge badge-pill badge-danger">{{ __('Reject By Department Manager') }}</div>
                                            @elseif($leave->status == 3)
                                                <div class="badge badge-pill badge-success">{{ __('Approve By Branch Manager') }}</div>
                                            @elseif($leave->status == 4)
                                                <div class="badge badge-pill badge-danger">{{ __('Reject By Branch Manager') }}</div>
                                            @endif
                                        </td>
                                        <td class="text-right action-btns">
                                            
                                            @if($leave->status == 0)
                                                @can('Edit Leave')
                                                    <a class="btn btn-success" href="#" data-url="{{ URL::to('employee_requests/' . $leave->id . '/edit') }}"
                                                        data-size="lg" data-ajax-popup="true"
                                                        data-title="{{ __('Edit Request') }}" class="edit-icon btn btn-success"
                                                        data-toggle="tooltip" data-original-title="{{ __('Edit') }}"><i class="fa fa-edit"></i></a>
                                                @endcan
                                            @endif

                                            @can('Delete Leave')
                                                <a class="btn btn-danger" href="#" class="delete-icon btn btn-danger" data-toggle="tooltip"
                                                    data-original-title="{{ __('Delete') }}"
                                                    data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                    data-confirm-yes="document.getElementById('delete-form-{{ $leave->id }}').submit();"><i class="fa fa-trash"></i>
                                                </a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['employee_requests.destroy', $leave->id], 'id' => 'delete-form-' . $leave->id]) !!}
                                                {!! Form::close() !!}
                                            @endcan

                                            <a href="#" class="btn btn-primary" data-url="{{ URL::to('employee_requests/' . $leave->id . '/action') }}"
                                                data-size="lg" data-ajax-popup="true"
                                                data-title="{{ __('Request Action') }}" class="edit-icon btn btn-success bg-success"
                                                data-toggle="tooltip" data-original-title="{{ __('Request Action') }}">
                                                <i class="fa fa-caret-right"></i> 
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody> 
                                                   
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
