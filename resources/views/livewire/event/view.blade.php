<div style="width: 470px;" class="offcanvas offcanvas-end" tabindex="-1" id="id1" aria-labelledby="id1Label"
    wire:ignore.self>
    <div class="drawerS1">
        <div class="head_ flex align between">
            <div class="flex align gap-25">
                <div class="" data-bs-dismiss="offcanvas" aria-label="Close">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.29289 5.29289C6.68342 4.90237 7.31658 4.90237 7.70711 5.29289L17.7071 15.2929C18.0976 15.6834 18.0976 16.3166 17.7071 16.7071L7.70711 26.7071C7.31658 27.0976 6.68342 27.0976 6.29289 26.7071C5.90237 26.3166 5.90237 25.6834 6.29289 25.2929L15.5858 16L6.29289 6.70711C5.90237 6.31658 5.90237 5.68342 6.29289 5.29289Z"
                            fill="black" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M16.2929 5.29289C16.6834 4.90237 17.3166 4.90237 17.7071 5.29289L27.7071 15.2929C28.0976 15.6834 28.0976 16.3166 27.7071 16.7071L17.7071 26.7071C17.3166 27.0976 16.6834 27.0976 16.2929 26.7071C15.9024 26.3166 15.9024 25.6834 16.2929 25.2929L25.5858 16L16.2929 6.70711C15.9024 6.31658 15.9024 5.68342 16.2929 5.29289Z"
                            fill="black" />
                    </svg>
                </div>
                <h3>{{ __('Event Details') }}</h3>
            </div>
            <div class="flex gap-15">

                @can('Event-Edit')
                    <div data-bs-toggle="offcanvas" data-bs-target="#edit1" aria-controls="edit1" class="edit-event" data-id="{{ $event->id }}">
                        <img src="/new-theme/icons/edit.svg" alt="">
                    </div>
                @endcan

                @can('Event-Edit')
                    @if ($event->id)
                        <div class="modal modal-delete fade" id="confirm2" abindex="-1" aria-hidden="true">
                            <div class="modal-dialog confirmS1 ">
                                <div class="content">
                                    <div class="des">{{ __('Are you sure to delete this item ?') }}</div>
                                    <div class="btns">
                                        <button form="delete-form2" type="submit" class="buttonS2 danger">{{ __('Remove')
                                            }}</button>
                                        <button type="button" class="buttonS2 cancel" data-bs-dismiss="modal">{{ __('Close')
                                            }}</button>
                                        <form id="delete-form2" style="display:none;" method="post"
                                            action="{{ route('event.destroy', $event->id) }}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <img data-bs-toggle="modal" data-bs-target="#confirm2" class=""
                            data-route="{{ route('event.destroy', $event->id) }}" src="/new-theme/icons/delete.svg" />
                    @endif
                @endcan
            </div>
        </div>

        <div class="contentDrawer scroll">
            <div class="sectionHistory sectionDDS1 section">
                <div class="ant-collapse">
                    <span class="ant-collapse-header-text">{{ __('Event information') }}</span>
                </div>

                <div class="collapse show" id="informations">
                    <div class="ant-collapse-content-box">
                        <div class="cards">
                            <div class="cardS1 flex align">
                                <div class="name">{{ __('Title') }}</div>
                                <div class="des">{{ $event->title }}</div>
                            </div>
                            <div class="cardS1 flex align">
                                <div class="name">{{ __('Date') }}</div>
                                <div class="des">{{ $event->start_date  ? $event->start_date->format('d/m/Y') : '' }}</div>
                            </div>
                            <div class="cardS1 flex align">
                                <div class="name">{{ __('Time') }}</div>
                                <div class="des">{{ $event->start_time }}</div>
                            </div>
                            <div class="cardS1 flex align">
                                <div class="name">{{ __('The Lectures')}}</div>
                                <div class="des"> {{ $event->lectures }} </div>
                            </div>
                            <div class="cardS1 flex align">
                                <div class="name">{{ __('location') }}</div>
                                <div class="des">{{ $event->location }}</div>
                            </div>
                            <div class="cardS1">
                                <div class="name">{{ __('About') }}</div>
                                <textarea readonly>{{ $event->about }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="sectionDDS1 section">
                <div class="ant-collapse-content-box">
                    <div class="cards mb-4">
                        <div class="cardS1 flex align">
                            <div class="name">@lang("Event photo")</div>
                            <!-- TODO: CHANGE IMG IN EVENT  -->
                            <div class="logo"><img src="{{$event->photo_path}}" /></div>
                        </div>
                    </div>
                </div>
            </div>            <div class="sectionEmployees sectionDDS1 section mb-4">
                <div data-bs-toggle="collapse" data-bs-target="#sectionEmployees" aria-expanded="true"
                    aria-controls="sectionEmployees">
                    <div class="ant-collapse">
                        <div class="ant-collapse-header" aria-expanded="true" aria-disabled="false"
                            role="button" tabindex="0">
                            <div class="ant-collapse-expand-icon">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1"
                                    viewBox="0 0 17 17" class="ant-collapse-arrow" height="1em" width="1em"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g></g>
                                    <path
                                        d="M12.146 6.146l0.707 0.707-4.353 4.354-4.354-4.353 0.707-0.707 3.647 3.646 3.646-3.647zM17 8.5c0 4.687-3.813 8.5-8.5 8.5s-8.5-3.813-8.5-8.5 3.813-8.5 8.5-8.5 8.5 3.813 8.5 8.5zM16 8.5c0-4.136-3.364-7.5-7.5-7.5s-7.5 3.364-7.5 7.5 3.364 7.5 7.5 7.5 7.5-3.364 7.5-7.5z">
                                    </path>
                                </svg>
                            </div>
                            <span class="ant-collapse-header-text">{{__('Employee List')}}</span>
                        </div>
                    </div>
                </div>

                <div class="collapse show" id="sectionEmployees">
                    <div
                        class="ant-collapse ant-collapse-icon-position-start ant-collapse-borderless css-dev-only-do-not-override-ilhm5s">
                        <div class="ant-collapse-item ant-collapse-item-active">
                            <div class="ant-collapse-content ant-collapse-content-active">
                                <div class="ant-collapse-content-box">

                                    <div class="cards tableS1">
                                        <!-- TODO: change employees list -->
                                        <div class="cardS1 flex align gap-2 mb-4">
                                            <div class="icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12.1601 10.87C12.0601 10.86 11.9401 10.86 11.8301 10.87C9.45006 10.79 7.56006 8.84 7.56006 6.44C7.56006 3.99 9.54006 2 12.0001 2C14.4501 2 16.4401 3.99 16.4401 6.44C16.4301 8.84 14.5401 10.79 12.1601 10.87Z"
                                                        stroke="#292D32" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M7.15997 14.56C4.73997 16.18 4.73997 18.82 7.15997 20.43C9.90997 22.27 14.42 22.27 17.17 20.43C19.59 18.81 19.59 16.17 17.17 14.56C14.43 12.73 9.91997 12.73 7.15997 14.56Z"
                                                        stroke="#292D32" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                            <div class="des">Omar Ahmed</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        

    </div>
</div>
