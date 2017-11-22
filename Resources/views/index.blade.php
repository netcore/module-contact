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
                                                        <li><b>{{ $day }}</b>: {{ $time }}</li>
                                                    @endforeach
                                                </ul>
                                            @endforeach

                                        @else
                                            @if($item->type == 'contact-form')
                                                {{ $item->form->name }}
                                            @else
                                                <ul>
                                                    @foreach(\Netcore\Translator\Helpers\TransHelper::getAllLanguages() as $language)
                                                        <li><b>{{ strtoupper($language->iso_code) }}
                                                                :</b> {{ trans_model($item, $language, 'value') }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endif
                                    </td>
                                    <td width="10%" class="text-center">
                                        @if($item->type == 'contact-form')
                                            <button data-id="{{ $item->id }}" class="btn btn-primary btn-sm edit-item"
                                                    data-toggle="modal" data-target="#edit-item"><i
                                                        class="fa fa-edit"></i> Edit
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

    @if($config['information']['contact-form'])
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
    <style>
        .map {
            width: 100%;
            height: 195px;
        }
    </style>
@endsection

@section('scripts')
    @if($config['map'])
        <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyDoxElWVmbMEV44F4-joUDSZurbhFo1UyE&v=3.exp"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>
        <script src="{{ versionedAsset('/assets/contact/js/contact.js') }}"></script>
    @endif
    <script>
        $(function () {
            //init switcher
            $('.single-entries-changeable-state').each(function (i, switcher) {
                new Switchery(switcher);
            });

            $('.edit-item').on('click', function () {
                var btn = $(this);
                var form = $('.js-edit-field');
                var data = JSON.parse(btn.parent().parent().attr('data-data'));
                var dangerAlert = form.find('.alert-danger');


                form.find('[name="item_id"]').val(data.id);
                form.find('[name="type"]').val(data.type);

                if (data.type == 'workdays') {
                    form.find('.js-workday-fields').removeClass('hidden');
                    form.find('.js-other-fields').addClass('hidden');
                    form.find('.js-contact-form').addClass('hidden');

                    var tableBody = form.find('.js-workday-fields table tbody').empty();
                    $.each(JSON.parse(data.default_value), function (field, value) {
                        tableBody.append('<tr><td>' + field + '</td><td><input type="text" value="' + value + '" name="value[]" class="form-control"></td></tr>');
                    })
                } else if (data.type == 'contact-form') {
                    form.find('.js-contact-form').removeClass('hidden');
                    form.find('.js-other-fields').addClass('hidden');
                    form.find('.js-workday-fields').addClass('hidden');

                    var currentFormId = JSON.parse(btn.parent().parent().attr('data-form_id'));
                    var forms = JSON.parse(btn.parent().parent().attr('data-forms'));
                    var formList = [];

                    var select = $('.js-contact-form select');
                    select.empty();

                    $.each(forms, function (index, form) {
                        var formId = form.id;
                        var formName = form.name;
                        if (currentFormId == formId) {
                            select.append($('<option value="' + formId + '" selected>' + formName + '</option>'));
                        } else {
                            select.append($('<option value="' + formId + '">' + formName + '</option>'));
                        }
                    });

                    console.log(formList);
                } else {
                    form.find('[name="value"]').val(data.value);
                    form.find('.js-workday-fields').addClass('hidden');
                    form.find('.js-other-fields').removeClass('hidden');
                    form.find('.js-contact-form').addClass('hidden');

                }

                form.on('submit', function (e) {
                    e.preventDefault();
                    var formData = form.serializeArray();

                    $.ajax({
                        type: 'post',
                        url: form.attr('action'),
                        data: formData,
                        success: function (response) {
                            $('#edit-item').modal('hide');
                            form[0].reset();
                            var row = $('.item-table').find('.object' + response.data.id + '');
                            if (response.data.type == 'contact-form') {
                                var forms = JSON.parse(btn.parent().parent().attr('data-forms'));
                                var formName = '';
                                $.each(forms, function (index, form) {
                                    if (form.id == response.data.default_value) {
                                        formName = form.name;
                                    }
                                });

                                row.find('.js-item-value').text(formName);
                            } else if (response.data.type == 'workdays') {
                                var workdayList = '<ul>';
                                $.each(JSON.parse(response.data.default_value), function (day, time) {
                                    workdayList += '<li><b>' + day + '</b>: ' + time + '</li>';
                                });
                                workdayList += '</ul>';
                                row.find('.js-item-value').html(workdayList);
                            } else {
                                row.find('.js-item-value').text(response.data.default_value);
                            }
                            row.attr('data-data', response.json);

                        },
                        error: function (response) {
                            var errors = response.responseJSON.errors;
                            var errorList = '';
                            $.each(errors, function (field, error) {
                                console.log(error);
                                errorList += '<li>' + error[0] + '</li>'
                            });
                            dangerAlert.hide().removeClass('hidden').html(errorList).fadeIn();
                            form.find('input[type="submit"]').prop('disabled', false);
                        }
                    });
                })
            });

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

            })
        });
    </script>
@endsection
