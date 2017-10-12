{!! Form::open(['route' => 'admin::contact.map.update', 'method' => 'put']) !!}

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