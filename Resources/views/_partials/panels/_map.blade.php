{!! Form::open(['route' => 'admin::contact.map.update', 'method' => 'put']) !!}
@include('translate::_partials._nav_tabs', ['idPrefix' => 'map-'])
<div class="tab-content">
    @foreach(\Netcore\Translator\Helpers\TransHelper::getAllLanguages() as $language)
        <div role="tabpanel" class="tab-pane {{ $loop->first ? 'active' : '' }} map-panel"
             id="map-{{ $language->iso_code }}" data-locale="{{ $language->iso_code }}">
            <div class="col-md-6">
                <div style="width:100%; height:400px; padding:0; margin:0; border:3px solid gainsboro; border-radius:3px;">
                <div id="contact-map-{{ $language->iso_code }}" style="width:100%; height:100%; padding:0; margin:0;"></div>
                </div>
                </div>
            <div class="col-md-6">
                {!! Form::hidden('translations['.$language->iso_code.'][lat]', trans_model((isset($location) ? $location : null), $language, 'lat')) !!}
                {!! Form::hidden('translations['.$language->iso_code.'][lng]', trans_model((isset($location) ? $location : null), $language, 'lng')) !!}

                <div class="form-group">
                    {!! Form::label('address_full', 'Full address:') !!}
                    <div class="input-group">
                        {!! Form::text('translations['.$language->iso_code.'][address_full]', trans_model((isset($location) ? $location : null), $language, 'address_full'), ['class' => 'form-control']) !!}
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-success search-map" data-locale="{{ $language->iso_code }}">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('address_short', 'Short address:') !!}
                    {!! Form::text('translations['.$language->iso_code.'][address_short]', trans_model((isset($location) ? $location : null), $language, 'address_short'), ['class' => 'form-control']) !!}
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        {!! Form::label('country', 'Country:') !!}
                        {!! Form::text('translations['.$language->iso_code.'][country]', trans_model((isset($location) ? $location : null), $language, 'country'), ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::label('city', 'City:') !!}
                        {!! Form::text('translations['.$language->iso_code.'][city]', trans_model((isset($location) ? $location : null), $language, 'city'), ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::label('zip_code', 'ZIP code:') !!}
                        {!! Form::text('translations['.$language->iso_code.'][zip_code]', trans_model((isset($location) ? $location : null), $language, 'zip_code'), ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

        </div>
    @endforeach
</div>
<button type="submit" class="btn btn-success">
    <i class="fa fa-save"></i> Save location data
</button>
{!! Form::close() !!}