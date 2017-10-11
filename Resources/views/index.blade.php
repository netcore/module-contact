@extends('admin::layouts.master')

@section('content')
    <div class="row">

        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Contact page text</h4>
                </div>
                <div class="panel-body">
                    @include('admin::_partials._messages')
                    {{ Form::open(['route' => 'admin::contact.content.update', 'method' => 'put']) }}
                    {{ Form::textarea('text', $content->text, ['class' => 'form-control summernote']) }}
                    <div class="pull-right">
                        {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
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
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr class="object{{ $item->id }}" data-data="{{ $item->toJson() }}">
                                <td>{{ ucfirst($item->type) }}</td>
                                <td class="js-item-value">
                                    @if($item->type == 'workdays')
                                        <ul>
                                            @foreach(json_decode($item->value) as $day => $time)
                                                <li><b>{{ $day }}</b>: {{ $time }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ $item->value }}
                                    @endif
                                </td>
                                <td>
                                    <button data-id="{{ $item->id }}" class="btn btn-primary edit-item"
                                            data-toggle="modal" data-target="#edit-item">Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Map</h4>
                </div>
                <div class="panel-body">
                        {!! Form::open(['route' => 'admin::contact.map.update']) !!}

                        <div class="col-md-6">
                            <div id="contact-map" class="map"></div>
                        </div>
                        <div class="col-md-6">

                            {!! Form::hidden('lat', $location->lat) !!}
                            {!! Form::hidden('lng', $location->lng) !!}

                            <div class="form-group">
                                {!! Form::label('address_full', 'Full address:') !!}
                                <div class="input-group">
                                    {!! Form::text('address_full', $location->address_full, ['class' => 'form-control']) !!}
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-success" id="search-map">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('address_short', 'Short address:') !!}
                                {!! Form::text('address_short', $location->address_short, ['class' => 'form-control']) !!}
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    {!! Form::label('country', 'Country:') !!}
                                    {!! Form::text('country', $location->country, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group col-md-4">
                                    {!! Form::label('city', 'City:') !!}
                                    {!! Form::text('city', $location->city, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group col-md-4">
                                    {!! Form::label('zip_code', 'ZIP code:') !!}
                                    {!! Form::text('zip_code', $location->zip_code, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Save location data
                        </button>
                        {!! Form::close() !!}
                    </div>
            </div>
        </div>
    </div>

    @include('contact::_partials.modal-edit-item')
@endsection

@section('scripts')
    <script>
        $(function () {
            $('.summernote').summernote();
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

                    var tableBody = form.find('.js-workday-fields table tbody').empty();
                    $.each(JSON.parse(data.value), function (field, value) {
                        tableBody.append('<tr><td>' + field + '</td><td><input type="text" value="' + value + '" name="value[]" class="form-control"></td></tr>');
                    })
                } else {
                    form.find('[name="value"]').val(data.value);
                    form.find('.js-workday-fields').addClass('hidden');
                    form.find('.js-other-fields').removeClass('hidden');
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
                            if (response.data.type != 'workdays') {
                                row.find('.js-item-value').text(response.data.value);
                            } else {
                                var workdayList = '<ul>';
                                $.each(JSON.parse(response.data.value), function (day, time) {
                                    workdayList += '<li><b>' + day + '</b>: ' + time + '</li>';
                                });
                                workdayList += '</ul>';
                                row.find('.js-item-value').html(workdayList);
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
        });
    </script>
@endsection