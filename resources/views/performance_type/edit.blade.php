    {{ Form::model($performance_type, ['route' => ['performanceType.update', $performance_type->id], 'method' => 'PUT']) }}
    <div class="row ">
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('name_ar', __('Name_ar'), ['class' => 'form-control-label']) }}
                {{ Form::text('name_ar', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-control-label']) }}
                {{ Form::text('name', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-12">
            <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
            <input type="button" value="{{__('Cancel')}}" class="btn btn-white" data-bs-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}
