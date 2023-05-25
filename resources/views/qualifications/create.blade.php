    {{Form::open(array('url'=>'qualifications','method'=>'post' , 'enctype' => 'multipart/form-data'))}}
    {{ Form::hidden('employee_id',$employee->id, array()) }}
    <div class="row">

        <div class="form-group col-md-6">
            {{ Form::label('major', __('major'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
            {{ Form::text('major',null, array('class' => 'form-control ','required'=>'required')) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('degree', __('quakification_degree'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
            {{ Form::text('degree',null, array('class' => 'form-control ','required'=>'required')) }}
        </div>


        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('graduation_date', __('graduation_date'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                {!! Form::text('graduation_date', old('graduation_date') ?? now(), ['class' => 'form-control gregorian-date']) !!}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('institute_name', __('institute_name'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                {!! Form::text('institute_name', old('institute_name'), ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('study_length', __('study_length'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
            {{ Form::text('study_length',null, array('class' => 'form-control ','required'=>'required','step'=>'0.01')) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('location', __('location'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
            {{ Form::text('location',null, array('class' => 'form-control ','required'=>'required','step'=>'0.01')) }}
        </div>

        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
            <input type="button" value="{{__('Cancel')}}" class="btn btn-white" data-bs-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}

    <script>
        $(function () {
            $(".gregorian-date").flatpickr({
              format:'YYYY-M-D',
              showSwitcher: false,
              hijri:false,
              useCurrent: true,
            });
        });

    </script>

