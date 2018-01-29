@extends('admin::layouts.master')

@section('content')
    <div class="row">
        @if($config['text-block'])
            <div class="@if($config['information']['enabled'])col-md-6 @else  col-md-12 @endif">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Contact page text</h4>
                    </div>
                    <div class="panel-body">
                        @include('admin::_partials._messages')
                        {{ Form::open(['route' => 'admin::contact.content.update', 'method' => 'put']) }}
                        <div class="form-group">
                            {{ Form::textarea('text', $content->text, ['class' => 'form-control summernote-with-filemanager']) }}
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success btn-md"><i class="fa fa-save"></i> Save
                            </button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        @endif
        @if($config['information']['enabled'])
            <div class="@if($config['text-block'])col-md-6 @else  col-md-12 @endif">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Contact information</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered item-table">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Value</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                @if(!$config['information'][$item->type])
                                    @continue
                                @endif
                                <tr class="object{{ $item->id }}" data-data="{{ $item->toJson() }}"
                                    @if($item->type == 'contact-form' && isset($forms)) data-form_id="{{ $item->default_value }}"
                                    data-forms="{{ $forms }}" @endif>
                                    <td>{{ ucfirst(str_replace('-', ' ', $item->type)) }}</td>
                                    <td class="js-item-value">
                                        @if($item->type == 'workdays')
                                            @foreach(\Netcore\Translator\Helpers\TransHelper::getAllLanguages() as $language)
                                                <b>{{ strtoupper($language->iso_code) }}</b>
                                                <ul>
                                                    @foreach(json_decode(trans_model($item, $language, 'value')) as $day => $time)
                                                        <li><b>{{ ucfirst($day) }}</b>: {{ $time }}</li>
                                                    @endforeach
                                                </ul>
                                            @endforeach
                                        @else
                                            @if($item->type == 'contact-form')
                                                {{ $item->form->name }}
                                            @else
                                                <ul>
                                                    @foreach(\Netcore\Translator\Helpers\TransHelper::getAllLanguages() as $language)
                                                        <li><b>{{ strtoupper($language->iso_code) }}:</b> {{ trans_model($item, $language, 'value') }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endif
                                    </td>
                                    <td width="10%" class="text-center">
                                        @if($item->type == 'contact-form')
                                            <button data-id="{{ $item->id }}" class="btn btn-primary btn-sm edit-item"
                                                    data-toggle="modal" data-target="#edit-item">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                        @else
                                            <a href="{{ route('admin::contact.item.edit', $item->id) }}"
                                               class="btn btn-primary btn-sm edit-item"
                                            >
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if($config['map'])
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Map</h4>
                    </div>
                    <div class="panel-body">
                        @include('contact::_partials.panels._map')
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($config['information']['contact-form'] && $form)
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Contact Form entries
                            <div class="pull-right">
                                <a href="{{ route('admin::form.edit', contact()->item('contact-form')) }}"
                                   class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit form</a>
                            </div>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-primary">
                            <table class="table table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    @foreach ($form->fields as $field)
                                        <th>{{ $field->label }}</th>
                                    @endforeach
                                    <th>Submitted At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('contact::_partials.modal-edit-item')
@endsection

@section('styles')
    @if($config['map'])
        <style>
            .map {
                width: 100%;
                height: 195px;
            }

            .gm-style img {
                max-height: none;
            }

            .map {
                height: 100%;
                width: 100%;
                margin: 0px;
                padding: 0px
            }
        </style>
        <script src="//maps.googleapis.com/maps/api/js?key={{ contact()->item('maps_api_key') }}&v=3.exp"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>
    @endif
@endsection

@section('scripts')
    <script src="{{ versionedAsset('/assets/contact/js/contact.js') }}"></script>
    <script>
     @if($config['map'])
        @foreach(\Netcore\Translator\Helpers\TransHelper::getAllLanguages() as $language)
            var latLong_{{ $language->iso_code }};
            var map_{{ $language->iso_code }};
            var geocoder_{{ $language->iso_code }};
        @endforeach
        $(window).on('load', function () {
            @foreach(\Netcore\Translator\Helpers\TransHelper::getAllLanguages() as $language)
                geocoder_{{ $language->iso_code }} = new google.maps.Geocoder();
                var locale = '{{ $language->iso_code }}';
                var map_lat = $('input[name="translations[' + locale + '][lat]"]').val();
                var map_lng = $('input[name="translations[' + locale + '][lng]"]').val();

                latLong_{{ $language->iso_code }} = new google.maps.LatLng(map_lat, map_lng);
                map_{{ $language->iso_code }} = new google.maps.Map(document.getElementById('contact-map-' + locale), {
                    center: latLong_{{ $language->iso_code }},
                    zoom: 12
                });
                markers_{{ $language->iso_code }} = {};
                markers_{{ $language->iso_code }}[latLong_{{ $language->iso_code }}] = new google.maps.Marker({
                    position: latLong_{{ $language->iso_code }},
                    map: map_{{ $language->iso_code }}
                });
            @endforeach
        });
        @endif

        $(function () {
            @if($config['map'])
            @foreach(\Netcore\Translator\Helpers\TransHelper::getAllLanguages() as $language)
            $('[href="#map-{{ $language->iso_code }}"]').click(function () {
                setTimeout(function () {
                    google.maps.event.trigger(map_{{ $language->iso_code }}, 'resize');
                    console.log(latLong_{{ $language->iso_code }});
                    map_{{ $language->iso_code }}.setCenter(latLong_{{ $language->iso_code }});
                }, 500);
            });
            @endforeach
            @endif

            @if($config['information']['contact-form'] && $form)
            $('#datatable').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: '{{ route('admin::form.entries.pagination', $form->id) }}',

                columns: [
                @foreach ($form->fields as $field)
                    {
                        data: '{{ $field->key }}', name: '{{ $field->key }}'
                    },
                @endforeach
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false,
                        sortable: false,
                        width: '10%',
                        className: 'text-center'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        searchable: false,
                        sortable: false,
                        width: '10%',
                        className: 'text-center'
                    }
                ]
            });
            @endif
        });
    </script>
@endsection
