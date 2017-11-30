@extends('admin::layouts.master')

@section('content')
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="{{ route('admin::contact.index') }}" class="btn btn-xs btn-primary">
                    <i class="fa fa-undo"></i> Back to list
                </a>
            </div>
            <h4 class="panel-title">Edit item - {{ $item->type }}</h4>
        </div>

        <div class="panel-body">
            @include('admin::_partials._messages')
            {{ Form::model($item, ['route' => ['admin::contact.custom.item.update', $item->id], 'method' => 'PUT', 'class' => 'form-horizontal']) }}

            @include('translate::_partials._nav_tabs')

            <div class="tab-content">
                @foreach(\Netcore\Translator\Helpers\TransHelper::getAllLanguages() as $language)
                    <div role="tabpanel" class="tab-pane {{ $loop->first ? 'active' : '' }}"
                         id="{{ $language->iso_code }}">

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Value</label>
                            <div class="col-md-8">
                                {!! Form::text('translations['.$language->iso_code.'][value]', trans_model((isset($item) ? $item : null), $language, 'value'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-success btn-md pull-right"><i class="fa fa-save"></i> Save</button>
        </div>
        {{ Form::close() }}
    </div>
    </div>
@endsection
