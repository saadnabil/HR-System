    {{Form::model($travel,array('route' => array('travel.update', $travel->id), 'method' => 'PUT')) }}
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('employee_id', __('Employee'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{ Form::select('employee_id', $employees,null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('start_date',__('Start Date'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('start_date',null,array('class'=>'form-control datepicker'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('end_date',__('End Date'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('end_date',null,array('class'=>'form-control datepicker'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('purpose_of_visit',__('Purpose of Visit'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('purpose_of_visit',null,array('class'=>'form-control'))}}
        </div>
         <div class="form-group col-lg-6 col-md-6">
            {{Form::label('purpose_of_visit_ar',__('Purpose of Visit_ar'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('purpose_of_visit_ar',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('place_of_visit_ar',__('Place Of Visit_ar'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('place_of_visit_ar',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('place_of_visit',__('Place Of Visit'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('place_of_visit',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('description',__('Description'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('description_ar',__('Description_ar'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::textarea('description_ar',null,array('class'=>'form-control','placeholder'=>__('Enter Description arabic')))}}
        </div>
        <div class="col-12">
            <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
            <input type="button" value="{{__('Cancel')}}" class="btn btn-white" data-bs-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}

    <script>
        $(function () {
            $(".gregorian-date , .datepicker").flatpickr({
            format:'YYYY-M-D',
            showSwitcher: false,
            hijri:false,
            useCurrent: true,
            });
        });
    </script>
