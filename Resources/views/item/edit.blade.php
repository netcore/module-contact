@extends('admin::layouts.master')
@section('content')
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Edit item - {{ $item->type }}</h4>
        </div>

        <div class="panel-body">
            @include('admin::_partials._messages')
            {{ Form::model($item, ['route' => ['admin::contact.custom.item.update', $item->id], 'method' => 'PUT', 'class' => 'form-horizontal']) }}

            @include('translate::_partials._nav_tabs')

            <div class="tab-content">
                @foreach(\Netcore\Translator\Helpers\TransHelper::getAllLanguages() as $language)
                    <div role="tabpanel" class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{ $language->iso_code }}">

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Value</label>
                            <div class="col-md-8">
                                {!! Form::text('translations['.$language->iso_code.'][value]', trans_model((isset($item) ? $item : null), $language, 'value'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="panel-footer text-right">
                {{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection