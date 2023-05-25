@extends('layouts.admin')
@section('page-title')
    {{__('Edit Employee')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{ Form::model($employee, array('route' => array('employee.update', $employee->id), 'method' => 'PUT' , 'enctype' => 'multipart/form-data')) }}
            @csrf
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-fluid">
                <div class="card-header"><h6 class="mb-0">{{__('Personal Detail')}}</h6></div>
                <div class="card-body employee-detail-edit-body">

                    <div class="row">
                        <div class="form-group col-md-4">
                            {!! Form::label('name', __('Name'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('name', __('Name_ar'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('name_ar', null, ['class' => 'form-control','required' => 'required']) !!}
                        </div>

                        <div class="form-group col-md-4">
                            {!! Form::label('sync_attendance_employee_id', __('sync_attendance_employee_id'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                            <select class="form-control" required="required" name="sync_attendance_employee_id" required>
                                @for($i = 0 ; $i < count($attandance_employees) ; $i++)
                                    <option value="{{ $attandance_employees[$i]['id'] }}" @if($employee->sync_attendance_employee_id == $attandance_employees[$i]['id']) selected @endif>{{ $attandance_employees[$i]['name'] }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            {!! Form::label('phone', __('Phone'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('phone',null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('dob', __('Date of Birth'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                                {!! Form::text('dob', null, ['class' => 'form-control datepicker']) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group ">
                                {!! Form::label('gender', __('Gender'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                                <div class="d-flex radio-check">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="g_male" value="Male" name="gender" class="custom-control-input" {{($employee->gender == 'Male')?'checked':''}}>
                                        <label class="custom-control-label" for="g_male">{{__('Male')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="g_female" value="Female" name="gender" class="custom-control-input" {{($employee->gender == 'Female')?'checked':''}}>
                                        <label class="custom-control-label" for="g_female">{{__('Female')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('jobtitle_id', __('jobtitle'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                            {{ Form::select('jobtitle_id', $jobtitles,null, array('class' => 'form-control  ','required'=>'required')) }}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('category_id', __('category'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                            {{ Form::select('category_id', $categories,null, array('class' => 'form-control  ','required'=>'required')) }}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('nationality_type', __('nationality_type'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                            {{ Form::select('nationality_type', [ "0" => __('non_saudi') , "1" => __('saudi') ],null, array('class' => 'form-control','id' => 'nationality_type','required'=>'required')) }}
                        </div>

                        <div class="form-group col-md-6">
                            <div id="nationality" @if($employee->nationality_type == 1) style="display:none" @endif>
                                {{ Form::label('nationality_id', __('nationality'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                                {{ Form::select('nationality_id', $nationalities,null, array('class' => 'form-control  ','required'=>'required')) }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('work_time', __('work_time'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                            {{ Form::select('work_time', [ "1" => __('full_time') , "0" => __('part_time') ],null, array('class' => 'form-control','required'=>'required')) }}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('city', __('city'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('city', old('city'), ['class' => 'form-control','required' => 'required']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('passport_number', __('passport_number'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('passport_number', old('passport_number'), ['class' => 'form-control','required' => 'required']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('residence_number', __('residence_number'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('residence_number', old('residence_number'), ['class' => 'form-control','required' => 'required']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('social_status', __('social_status'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                            {{ Form::select('social_status', [ "1" => __('married') , "0" => __('single') ],null, array('class' => 'form-control','required'=>'required')) }}
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                {!! Form::label('commencement_date', __('commencement_date'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                                {!! Form::text('commencement_date', old('commencement_date'), ['class' => 'form-control datepicker']) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('contract_number', __('contract_number'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('contract_number', old('contract_number'), ['class' => 'form-control','required' => 'required']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('insurance_number', __('insurance_number'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('insurance_number', old('insurance_number'), ['class' => 'form-control','required' => 'required']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('is_active', __('status'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                            {{ Form::select('is_active', [ "1" => __('active') , "0" => __('not_active') ],null, array('class' => 'form-control','required'=>'required')) }}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('driving_license', __('driving_license'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                            {{ Form::select('driving_license', [ "1" => __('yes') , "0" => __('no') ],null, array('class' => 'form-control',"id" => "driving_license",'required'=>'required')) }}
                        </div>

                        <div @if($employee->driving_license == 0) style="display:none" @endif class="form-group driving_license_info col-md-6">
                            {!! Form::label('driving_license_number', __('driving_license_number'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('driving_license_number', old('driving_license_number'), ['class' => 'form-control']) !!}
                        </div>

                        <div @if($employee->driving_license == 0) style="display:none" @endif class="form-group driving_license_info col-md-6">
                            <div class="form-group">
                                {!! Form::label('expiry_date', __('expiry_date'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                                {!! Form::text('expiry_date', old('expiry_date'), ['class' => 'form-control datepicker']) !!}
                            </div>
                        </div>



                    </div>
                    <div class="form-group">
                        {!! Form::label('address', __('Address'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::textarea('address',null, ['class' => 'form-control','rows'=>2]) !!}
                    </div>
                    @if(auth()->user()->type=='employee')
                        {!! Form::submit('Update', ['class' => 'btn-create btn-xs badge-blue radius-10px float-right']) !!}
                    @endif
                </div>
            </div>
        </div>
        @if(auth()->user()->type!='employee')
            <div class="col-md-12">
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Company Detail')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                            @csrf
                            <div class="form-group col-md-12">
                                {!! Form::label('employee_id', __('Employee ID'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                                {!! Form::text('employee_id',$employeesId, ['class' => 'form-control','disabled'=>'disabled']) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('branch_id', __('Branch'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                                {{ Form::select('branch_id', $branches,null, array('class' => 'form-control ','required'=>'required')) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('department_id', __('Department'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                                {{ Form::select('department_id', $departments,null, array('class' => 'form-control ','required'=>'required')) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('designation_id', __('Designation'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                                <select class="select2 form-control select2-multiple" id="designation_id" name="designation_id" data-toggle="select2" data-placeholder="{{ __('Select Designation ...') }}">
                                    <option value="">{{__('Select any Designation')}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('company_doj', 'Company Date Of Joining',['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                                {!! Form::text('company_doj', null, ['class' => 'form-control datepicker','required' => 'required']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="employee-detail-wrap ">
                    <div class="card card-fluid">
                        <div class="card-header"><h6 class="mb-0">{{__('Company Detail')}}</h6></div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Branch')}}</strong>
                                        <span>{{!empty($employee->branch)?$employee->branch->name:''}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong>{{__('Department')}}</strong>
                                        <span>{{!empty($employee->department)?$employee->department->name:''}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong>{{__('Designation')}}</strong>
                                        <span>{{!empty($employee->designation)?$employee->designation->name:''}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Date Of Joining')}}</strong>
                                        <span>{{auth()->user()->dateFormat($employee->company_doj)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-12">
        <div class="card card-fluid">
            <div class="card-header"><h6 class="mb-0">{{__('Contract_Detail')}}</h6></div>
            <div class="card-body employee-detail-create-body">
                <div class="row">
                    @csrf

                    <div class="form-group col-md-6">
                        {{ Form::label('contract_type', __('contract_type'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                        {{ Form::select('contract_type', [ "1" => __('limited_time') , "0" => __('unlimited_time'), "2" => __('temporary') ],$employeeContract ? $employeeContract->contract_type : null, array('class' => 'form-control',"id" => "contract_type",'required'=>'required')) }}
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="choose-file">
                                <label for="avatar">
                                    <div>{{__('contract_document')}}</div>
                                    <input type="file" class="form-control" id="contract_document" name="contract_document" data-filename="contract_document">
                                </label>
                                <p class="contract_document"></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div id="contract_startdate" class="form-group">
                            {!! Form::label('contract_startdate', __('contract_startdate'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('contract_startdate', old('contract_startdate'), ['class' => 'form-control datepicker']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div  id="contract_enddate" @if($employeeContract && $employeeContract->contract_type == 0) style="display:none" @endif class="form-group">
                            {!! Form::label('contract_enddate', __('contract_enddate'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('contract_enddate', old('contract_enddate'), ['class' => 'form-control datepicker']) !!}
                        </div>
                    </div>


                    <div class="form-group col-md-6">
                        {{ Form::label('medical_insurance', __('medical_insurance'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                        {{ Form::select('medical_insurance', [ "1" => __('available') , "0" => __('not_available') ],$employeeContract ? $employeeContract->medical_insurance : null, array('class' => 'form-control',"id" => "medical_insurance",'required'=>'required')) }}
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="choose-file">
                                <label for="avatar">
                                    <div>{{__('insurance_document')}}</div>
                                    <input type="file" class="form-control" id="insurance_document" name="insurance_document" data-filename="insurance_document">
                                </label>
                                <p class="insurance_document"></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div id="insurance_startdate" @if($employeeContract && $employeeContract->medical_insurance == 0) style="display:none" @endif  class="form-group">
                            {!! Form::label('insurance_startdate', __('insurance_startdate'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('insurance_startdate', $employeeContract ? $employeeContract->insurance_startdate : null, ['class' => 'form-control datepicker']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div id="insurance_enddate" @if($employeeContract && $employeeContract->medical_insurance == 0) style="display:none" @endif class="form-group">
                            {!! Form::label('insurance_enddate', __('insurance_enddate'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('insurance_enddate', $employeeContract ? $employeeContract->insurance_enddate : null, ['class' => 'form-control datepicker']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        {{ Form::label('worker', __('worker'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                        {{ Form::select('worker', [ "1" => __('available') , "0" => __('not_available') ],$employeeContract ? $employeeContract->worker : null, array('class' => 'form-control',"id" => "worker",'required'=>'required')) }}
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="choose-file">
                                <label for="avatar">
                                    <div>{{__('worker_document')}}</div>
                                    <input type="file" class="form-control" id="worker_document" name="worker_document" data-filename="worker_document">
                                </label>
                                <p class="worker_document"></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div id="worker_startdate" @if($employeeContract && $employeeContract->worker == 0) style="display:none" @endif class="form-group">
                            {!! Form::label('worker_startdate', __('worker_startdate'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('worker_startdate', old('worker_startdate'), ['class' => 'form-control datepicker']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div id="worker_enddate" @if($employeeContract && $employeeContract->worker == 0) style="display:none" @endif class="form-group">
                            {!! Form::label('worker_enddate', __('worker_enddate'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('worker_enddate', old('worker_enddate'), ['class' => 'form-control datepicker']) !!}
                        </div>
                    </div>


                    <div class="form-group col-md-6">
                        {!! Form::label('residence_number', __('residence_number'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                        {!! Form::text('residence_number', old('residence_number'), ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        <div id="passport_expiredate" class="form-group">
                            {!! Form::label('residence_expiredate', __('residence_expiredate'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('residence_expiredate', old('residence_expiredate'), ['class' => 'form-control datepicker']) !!}
                        </div>
                    </div>


                    <div class="form-group col-md-6">
                        {!! Form::label('passport_number', __('passport_number'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                        {!! Form::text('passport_number', old('passport_number'), ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        <div id="passport_expiredate" class="form-group">
                            {!! Form::label('passport_expiredate', __('passport_expiredate'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('passport_expiredate', old('passport_expiredate'), ['class' => 'form-control datepicker']) !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->type!='employee')
        <div class="row">
            <div class="col-md-6 ">
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Document')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        @php
                            $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                        @endphp

                        @foreach($documents as $key=>$document)
                            <div class="row">
                                <div class="form-group col-12">
                                    <div class="float-left col-4">
                                        <label for="document" class="float-left pt-1 form-control-label">{{ $document->name }} @if($document->is_required == 1) <span class="text-danger">*</span> @endif</label>
                                    </div>
                                    <div class="float-right col-8">
                                        <input type="hidden" name="emp_doc_id[{{ $document->id}}]" id="" value="{{$document->id}}">
                                        <div class="choose-file form-group">
                                            <label for="document[{{ $document->id }}]">
                                                <div>{{__('Choose File')}}</div>
                                                <input class="form-control @if(!empty($employeedoc[$document->id])) float-left @endif @error('document') is-invalid @enderror border-0" @if($document->is_required == 1 && empty($employeedoc[$document->id]) ) required @endif name="document[{{ $document->id}}]" type="file" id="document[{{ $document->id }}]" data-filename="{{ $document->id.'_filename'}}">
                                            </label>
                                            <p class="{{ $document->id.'_filename'}}"></p>
                                        </div>

                                        @if(!empty($employeedoc[$document->id]))
                                            <br> <span class="text-xs"><a href="{{ (!empty($employeedoc[$document->id])?asset(Storage::url('uploads/document')).'/'.$employeedoc[$document->id]:'') }}" target="_blank">{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a>
                                                    </span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Bank Account Detail')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('account_holder_name', __('Account Holder Name'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('account_holder_name', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('account_number', __('Account Number'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::number('account_number', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('bank_name', __('Bank Name'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('bank_name', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('bank_identifier_code', __('Bank Identifier Code'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('bank_identifier_code',null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('branch_location', __('Branch Location'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('branch_location',null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('tax_payer_id', __('Tax Payer Id'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('tax_payer_id',null, ['class' => 'form-control']) !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card card-fluid">
                        <div class="card-header"><h6 class="mb-0">{{__('Document Detail')}}</h6></div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                @php
                                    $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                                @endphp
                                @foreach($documents as $key=>$document)
                                    <div class="col-md-12">
                                        <div class="info">
                                            <strong>{{$document->name }}</strong>
                                            <span><a href="{{ (!empty($employeedoc[$document->id])?asset(Storage::url('uploads/document')).'/'.$employeedoc[$document->id]:'') }}" target="_blank">{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a></span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card card-fluid">
                        <div class="card-header"><h6 class="mb-0">{{__('Bank Account Detail')}}</h6></div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Account Holder Name')}}</strong>
                                        <span>{{$employee->account_holder_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong>{{__('Account Number')}}</strong>
                                        <span>{{$employee->account_number}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong>{{__('Bank Name')}}</strong>
                                        <span>{{$employee->bank_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Bank Identifier Code')}}</strong>
                                        <span>{{$employee->bank_identifier_code}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Branch Location')}}</strong>
                                        <span>{{$employee->branch_location}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Tax Payer Id')}}</strong>
                                        <span>{{$employee->tax_payer_id}}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(auth()->user()->type != 'employee')
        <div class="row">
            <div class="col-12">
                <input type="submit" value="{{__('Update')}}" class="btn-create btn-xs badge-blue radius-10px float-right">
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('script-page')
    <script type="text/javascript">

        function getDesignation(did) {
            $.ajax({
                url: '{{route('employee.json')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">Select any Designation</option>');
                    $.each(data, function (key, value) {
                        var select = '';
                        if (key == '{{ $employee->designation_id }}') {
                            select = 'selected';
                        }

                        $('#designation_id').append('<option value="' + key + '"  ' + select + '>' + value + '</option>');
                    });
                }
            });
        }

        $(document).ready(function () {
            var d_id = $('#department_id').val();
            var designation_id = '{{ $employee->designation_id }}';
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department_id]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

        $(document).on('change', '#nationality_type', function () {
            var nationality_type = $(this).val();
            if(nationality_type == 1)
            {
                $('#nationality').css('display','none');
            }else{
                $('#nationality').css('display','block');
            }
        });

        $(document).on('change', '#driving_license', function () {
            var driving_license = $(this).val();
            if(driving_license == 0)
            {
                $('.driving_license_info').css('display','none');
            }else{
                $('.driving_license_info').css('display','block');
            }
        });

        $(document).on('change', '#contract_type', function () {
            var contract_type = $(this).val();
            if(contract_type == 0)
            {
                $('#contract_enddate').css('display','none');
            }else{
                $('#contract_enddate').css('display','block');
            }
        });

        $(document).on('change', '#medical_insurance', function () {
            var medical_insurance = $(this).val();
            if(medical_insurance == 0)
            {
                $('#insurance_startdate').css('display','none');
                $('#insurance_enddate').css('display','none');
            }else{
                $('#insurance_startdate').css('display','block');
                $('#insurance_enddate').css('display','block');
            }
        });

        $(document).on('change', '#worker', function () {
            var worker = $(this).val();
            if(worker == 0)
            {
                $('#worker_startdate').css('display','none');
                $('#worker_enddate').css('display','none');
            }else{
                $('#worker_startdate').css('display','block');
                $('#worker_enddate').css('display','block');
            }
        });

    </script>
@endpush
