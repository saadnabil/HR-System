    {{Form::model($EmployeeContracts,array('route' => array('contracts.update', $EmployeeContracts->id), 'method' => 'PUT')) }}
    <div class="card-body p-0">
        <div class="row">
            <div style="display:flex;" class="form-group col-md-12">
                {{ Form::label('contract_type', __('contract_type'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                <div class="d-flex radio-check">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="contract_type" checked value="1" name="contract_type" class="custom-control-input">
                        <label class="custom-control-label" for="contract_type">{{__('limited_time')}}</label>
                    </div>
                </div>
            </div>

            <div style="display:flex;" class="form-group col-md-12">
                {{ Form::label('contract_duration', __('contract_duration'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) }}
                <div class="d-flex radio-check">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="1year" value="1" @if($EmployeeContracts->contract_duration == 1) checked @endif name="contract_duration" class="custom-control-input">
                        <label class="custom-control-label" for="1year">{{__('1year')}}</label>
                    </div>
                </div>

                <div class="d-flex radio-check">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="2year" value="2" @if($EmployeeContracts->contract_duration == 2) checked @endif name="contract_duration" class="custom-control-input">
                        <label class="custom-control-label" for="2year">{{__('2year')}}</label>
                    </div>
                </div>

                <div class="d-flex radio-check">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customduration"  value="0" @if($EmployeeContracts->contract_duration == 0) checked @endif name="contract_duration" class="custom-control-input">
                        <label class="custom-control-label" for="customduration">{{__('customduration')}}</label>
                    </div>
                </div>
            </div>

            <div class="col-md-12" @if($EmployeeContracts->contract_duration != 0) style="display:none;" @endif  id= "ContractDuration">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div id="contract_startdate" class="form-group">
                            {!! Form::label('contract_startdate', __('contract_startdate_gregorian'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('contract_startdate',$EmployeeContracts->Join_date_gregorian, ['id' => 'gregorian_3' ,'class' => 'form-control gregorian-date']) !!}
                        </div>
                    </div>


                    <div class="form-group col-md-6">
                        <div id="contract_startdate" class="form-group">
                            {!! Form::label('contract_startdate_Hijri', __('contract_startdate_Hijri'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('contract_startdate_hijri', $EmployeeContracts->Join_date_hijri, ['id' => 'hijri_3' , 'class' => 'form-control hijri-date-input']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div id="contract_enddate" class="form-group">
                            {!! Form::label('contract_enddate', __('contract_enddate_gregorian'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('contract_enddate', old('contract_enddate') ?? now(), ['id' => 'gregorian_2' ,'class' => 'form-control gregorian-date']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div id="contract_startdate" class="form-group">
                            {!! Form::label('contract_enddate_Hijri', __('contract_enddate_Hijri'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2']) !!}
                            {!! Form::text('contract_enddate_hijri', old('contract_enddate_Hijri') ?? now(), ['id' => 'hijri_2' ,'class' => 'form-control hijri-date-input']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <div class="choose-file">
                        <label for="avatar">
                            <div>{{__('add_attachment')}}</div>
                            <input type="file" class="form-control" id="contract_document" name="contract_document">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
            <input type="button" value="{{__('Cancel')}}" class="btn btn-white" data-bs-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}

    <script>
        $(document).on('change', 'input[name=contract_duration]', function () {
            if($(this).val() == 0)
            {
                $('#ContractDuration').css('display','block');
            }else{
                $('#ContractDuration').css('display','none');
            }
        });

        

        for(let i = 1; i <= 18; i++){
            $('#hijri_'+i).on('dp.change', function (arg) {

                if (!arg.date) {
                return;
                };

                let date = arg.date;
                $('#gregorian_'+i).val(date.format("YYYY-M-D"));
            });
            $('#gregorian_'+i).on('dp.change', function (arg) {

                if (!arg.date) {
                return;
                };

                let date = arg.date;
                $('#hijri_'+i).val(date.format("iYYYY-iM-iD"));
            });
        }
    </script>
