<div class="card bg-none card-box">
    {{Form::model($allowanceoption,array('route' => array('allowanceoption.update', $allowanceoption->id), 'method' => 'PUT')) }}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Allowance option Name')))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('name_ar',__('Name_ar'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
                {{Form::text('name_ar',null,array('class'=>'form-control','placeholder'=>__('Enter Allowance option Name arabic')))}}
                @error('name_ar')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('insurance_active', __('added_to_insurance'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
            {{ Form::select('insurance_active', [ "0" => __('no') , "1" => __('yes') ],null, array('class' => 'form-control','required'=>'required')) }}
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('payroll_dispaly', __('added_to_payroll'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
            {{ Form::select('payroll_dispaly', [ null => __('no') , "1" => __('yes') ],null, array('class' => 'form-control')) }}
        </div>

        <div class="col-12">
            <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
            <input type="button" value="{{__('Cancel')}}" class="btn btn-white" data-bs-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
</div>
