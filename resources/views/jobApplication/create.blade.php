    {{Form::open(array('url'=>'job-application','method'=>'post', 'enctype' => "multipart/form-data"))}}
    <div class="row">
        <div class="form-group col-md-12">
            {{Form::label('job',__('Job'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::select('job',$jobs,null,array('class'=>'form-control ','id'=>'jobs'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('name',__('Name'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('name',null,array('class'=>'form-control name'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('email',__('Email'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('email',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('phone',__('Phone'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('phone',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6 dob d-none">
            {!! Form::label('dob', __('Date of Birth'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
            {!! Form::text('dob', old('dob'), ['class' => 'form-control datepicker']) !!}
        </div>
        <div class="form-group col-md-6 gender d-none">
            {!! Form::label('gender', __('Gender'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
            <div class="d-flex radio-check">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="g_male" value="Male" name="gender" class="custom-control-input">
                    <label class="custom-control-label" for="g_male">{{__('Male')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="g_female" value="Female" name="gender" class="custom-control-input">
                    <label class="custom-control-label" for="g_female">{{__('Female')}}</label>
                </div>
            </div>
        </div>
        <div class="form-group col-md-6 country d-none">
            {{Form::label('country',__('Country'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('country',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6 country d-none">
            {{Form::label('state',__('State'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('state',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6 country d-none">
            {{Form::label('city',__('City'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::text('city',null,array('class'=>'form-control'))}}
        </div>

        <div class="form-group col-md-6 profile d-none">
            {{Form::label('profile',__('Profile'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            <div class="choose-file form-group">
                <label for="profile" class="form-control-label">
                    <div>{{__('Choose file here')}}</div>
                    <input type="file" class="form-control" name="profile" id="profile" data-filename="profile_create">
                </label>
                <p class="profile_create"></p>
            </div>
        </div>
        <div class="form-group col-md-6 resume d-none">
            {{Form::label('resume',__('CV / Resume'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            <div class="choose-file form-group">
                <label for="resume" class="form-control-label">
                    <div>{{__('Choose file here')}}</div>
                    <input type="file" class="form-control" name="resume" id="resume" data-filename="resume_create">
                </label>
                <p class="resume_create"></p>
            </div>
        </div>
        <div class="form-group col-md-12 letter d-none">
            {{Form::label('cover_letter',__('Cover Letter'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
            {{Form::textarea('cover_letter',null,array('class'=>'form-control'))}}
        </div>
        @foreach($questions as $question)
            <div class="form-group col-md-12  question question_{{$question->id}} d-none">
                {{Form::label($question->question,$question->question,['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
                <input type="text" class="form-control" name="question[{{$question->question}}]" {{($question->is_required=='yes')?'required':''}}>
            </div>
        @endforeach
        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
            <input type="button" value="{{__('Cancel')}}" class="btn btn-white" data-bs-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}

