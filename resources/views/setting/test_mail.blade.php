{{ Form::open(array('route' => array('test.send.mail'))) }}
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('email', __('Email'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
        {{ Form::text('email', '', array('class' => 'form-control','required'=>'required')) }}
        @error('email')
        <span class="invalid-email" role="alert">
            <strong class="text-danger">{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="modal-footer">
    <input type="submit" value="{{__('Send')}}" class="btn btn-primary">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-primary" data-bs-dismiss="modal">
</div>
{{ Form::close() }}

