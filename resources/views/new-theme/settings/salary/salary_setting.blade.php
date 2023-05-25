@extends('new-theme.layout.layout1', ['showSettingMenu' => true])

@push('styles')
    <link rel="stylesheet" href="{{ asset('new-theme/styles/settings.css') }}" />
    <style>
        #non-saudi {
            display: none;
        }
    </style>
@endpush



@section('content')
    <div class="branchesPage">
        <div class="pageS1">
            @component('new-theme.settings.salary.components.tabs')
                @slot('active', 'salary')
                <div class="tab-pane fade show active" id="salary" role="tabpanel" aria-labelledby="salary-tab">
                    <form action="{{ route('salary_setting.store') }}" class="formS1" method="post">
                        @csrf


                        <div class="sectionS2">
                            <div class="head withBorder flex align between">
                                <h3 class='small'>@lang('insurance Settings')</h3>
                                <div class="inputS1 m-0" style="width: 100px">
                                    <select class='p-2' style="height: 35px;line-height: 1;" id="form-salary">
                                        <option value="saudi" selected>saudi</option>
                                        <option value="non-saudi">non-saudi</option>

                                    </select>
                                </div>
                            </div>
                        </div>



                        @include('new-theme.settings.salary.components.saudi')
                        @include('new-theme.settings.salary.components.nonsaudi')


                    </form>


                </div>
            @endcomponent



        </div>
    </div>
@endsection
@push('script')
    <script>
        $('#form-salary').on('change', function(e) {
            e.preventDefault();

            var salary = $('#form-salary').val();
            if (salary == 'saudi') {

                $('#saudi').css('display', 'block')
                $('#non-saudi').css('display', 'none')

            } else {
                $('#non-saudi').css('display', 'block')
                $('#saudi').css('display', 'none')
            }

        })
    </script>
@endpush
