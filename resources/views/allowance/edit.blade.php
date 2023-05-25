    {{Form::model($allowance,array('route' => array('allowance.update', $allowance->id), 'method' => 'PUT')) }}
    <div class="card-body p-0">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('allowance_option', __('Allowance Options*')) }}
                    {{ Form::select('allowance_option',$allowance_options,null, array('class' => 'form-control ','required'=>'required')) }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('title', __('Title')) }}
                    {{ Form::text('title',null, array('class' => 'form-control ','required'=>'required')) }}
                </div>
            </div>
        </div>

        <div class="form-group col-md-6">
            {{Form::label('date',__('Date'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('date',null,array('class'=>'form-control datepicker'))}}
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('amount', __('Amount')) }}
                    {{ Form::number('amount',null, array('class' => 'form-control ','required'=>'required')) }}
                </div>
            </div>
        </div>

        <div class="col-12">
            <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
            <input type="button" value="{{__('Cancel')}}" class="btn btn-white" data-bs-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}

