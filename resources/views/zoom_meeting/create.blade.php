<style>
    .select2-container--default.select2-container--focus .select2-selection--multiple,
    .select2-container--default .select2-selection--multiple {
        height: auto !important;
        min-height: 40px !important;
    }
</style>

    {{ Form::open(['url' => 'zoom-meeting', 'enctype' => 'multipart/form-data',"autocomplete"  => "off"]) }}
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('', __('Title'), ['class' => 'form-control-label']) }}
                {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Meeting Title'), 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group select2_option">
                {{ Form::label('', __('User'), ['class' => 'form-control-label']) }}
                {!! Form::select('user_id[]', $employee_option, null, ['multiple' => true, 'class' => 'form-control select2']) !!}
            </div>
        </div>


        <div class="col-6">
            <div class="form-group">
                {{ Form::label('', __('Start Date'), ['class' => 'form-control-label']) }}
                {!! Form::text('start_date', null, ['class' => 'form-control datepicker datetime_class_start_date']) !!}
                <input type="hidden" name="start_date" class="start_date" value="">
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                {{ Form::label('', __('Duration'), ['class' => 'form-control-label']) }}
                {!! Form::number('duration', null, ['class' => 'form-control', 'required' => true, 'min' => 0]) !!}
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                {{ Form::label('password', __('Password'),['class' => 'form-control-label']) }}
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter Password')]) }}
            </div>
        </div>

        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
            <input type="button" value="{{__('Cancel')}}" class="btn btn-white" data-bs-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}

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
