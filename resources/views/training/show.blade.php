@extends('layouts.admin')
@section('page-title')
    {{__('Trainig Details')}}
@endsection
@section('content')

<div id="kt_app_content" class="app-content flex-column-fluid" data-select2-id="select2-data-kt_app_content">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl" data-select2-id="select2-data-kt_app_content_container">
        <!--begin::Form-->
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-3 py-lg-6 justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('Trainig Details')}}</h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->

        <div class="row">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3">
                                <tbody>
                                <tr>
                                    <td>{{__('Training Type')}}</td>
                                    <td class="text-right">{{ !empty($training->types)?$training->types->name:'' }}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Trainer')}}</td>
                                    <td class="text-right">{{ !empty($training->trainers)?$training->trainers->firstname:'--' }}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Training Cost')}}</td>
                                    <td class="text-right">{{auth()->user()->priceFormat($training->training_cost)}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Start Date')}}</td>
                                    <td class="text-right">{{auth()->user()->dateFormat($training->start_date)}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('End Date')}}</td>
                                    <td class="text-right">{{auth()->user()->dateFormat($training->end_date)}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Date')}}</td>
                                    <td class="text-right">{{auth()->user()->dateFormat($training->created_at)}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="text-sm mt-4 p-2"> {{$training->description}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <h6>{{__('Training Employee')}}</h6>
                                <div class="media-list" id="all_employees_list">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" style="border:0px;">
                                            <div class="media align-items-center">
                                                <img src="{{!empty($training->employees)? !empty($training->employees->user->avatar)?asset(Storage::url('uploads/avatar')).'/'.$training->employees->user->avatar:asset(Storage::url('uploads/avatar')).'/avatar.png':asset(Storage::url('uploads/avatar')).'/avatar.png'}}" class="user-image-hr-prj ui-w-30 rounded-circle" width="50px" height="50px">
                                                <div class="media-body px-2 text-sm">
                                                    <a href="{{route('employee.show',!empty($training->employees)?($training->employees->id):0)}}" class="text-dark">
                                                        {{ !empty($training->employees)?$training->employees->name:'' }}
                                                    </a>
                                                    <br>
                                                    {{ !empty($training->employees)?!empty($training->employees->designation)?$training->employees->designation->name:'':'' }}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-6">
                                {{Form::model($training,array('route' => array('training.status', $training->id), 'method' => 'post')) }}
                                <h6>{{__('Update Status')}}</h6>
                                <div class="col-md-12 mt-4">
                                    <input type="hidden" value="{{$training->id}}" name="id">
                                    <div class="form-group">
                                        {{Form::label('performance',__('Performance'),['class'=>'form-control-label text-dark'])}}
                                        {{Form::select('performance',$performance,null,array('class'=>'form-control select2'))}}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('status',__('Status'),['class'=>'form-control-label text-dark'])}}
                                        {{Form::select('status',$status,null,array('class'=>'form-control select2'))}}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('remarks',__('Remarks'),['class'=>'form-control-label text-dark'])}}
                                        {{Form::textarea('remarks',null,array('class'=>'form-control','placeholder'=>__('Remarks')))}}
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 text-right">
                                    <input type="submit" value="{{__('Save')}}" class="btn btn-primary">
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection



