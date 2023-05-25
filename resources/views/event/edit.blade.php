    {{Form::model($event,array('route' => array('event.update', $event->id), 'method' => 'PUT')) }}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('title',__('Event Title'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
                {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Event Title')))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('title_ar',__('Event Title_ar'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
                {{Form::text('title_ar',null,array('class'=>'form-control','placeholder'=>__('Enter Event Title arabic')))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('start_date',__('Event start Date'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
                {{Form::date('start_date',null,array('class'=>'form-control datepicker'))}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('end_date',__('Event End Date'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
                {{Form::date('end_date',null,array('class'=>'form-control datepicker'))}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('time',__('Event Time'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
                {{Form::time('time',null,array('class'=>'form-control datepicker'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{Form::label('color',__('Event Select Color'),['class'=>'form-control-label d-block mb-3'])}}
                <div class="btn-group btn-group-toggle btn-group-colors event-tag" data-toggle="buttons">
                    <label class="btn bg-info {{($event->color=='#00B8D9')?'active':''}} "><input type="radio" name="color" value="#00B8D9" {{($event->color=='#00B8D9')?'checked':''}}></label>
                    <label class="btn bg-warning {{($event->color=='#FFAB00')?'active':''}}"><input type="radio" name="color" value="#FFAB00" {{($event->color=='#FFAB00')?'checked':''}}></label>
                    <label class="btn bg-danger {{($event->color=='#FF5630')?'active':''}}"><input type="radio" name="color" value="#FF5630" {{($event->color=='#FF5630')?'checked':''}}></label>
                    <label class="btn bg-success {{($event->color=='#36B37E')?'active':''}}"><input type="radio" name="color" value="#36B37E" {{($event->color=='#36B37E')?'checked':''}}></label>
                    <label class="btn bg-secondary {{($event->color=='#EFF2F7')?'active':''}}"><input type="radio" name="color" value="#EFF2F7" {{($event->color=='#EFF2F7')?'checked':''}}></label>
                    <label class="btn bg-primary {{($event->color=='#051C4B')?'active':''}}"><input type="radio" name="color" value="#051C4B" {{($event->color=='#051C4B')?'checked':''}}></label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('description',__('Event Description'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
                {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Event Description')))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('description_ar',__('Event Description_ar'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
                {{Form::textarea('description_ar',null,array('class'=>'form-control','placeholder'=>__('Enter Event Description arabic')))}}
            </div>
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
