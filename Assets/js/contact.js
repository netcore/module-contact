$(function() {

    var map_lat = $('input[name=lat]').val();
    var map_lng = $('input[name=lng]').val();

    var map = new GMaps({
        div: '#contact-map',
        lat: map_lat,
        lng: map_lng,
        zoom: 12
    });

    map.addMarker({
        lat : map_lat,
        lng : map_lng
    });

    $('#search-map').click(function() {

        var address = $('#address_full').val();
        var btn = $(this).data('loading-text', '<i class="fa fa-spinner fa-spin"></i>').button('loading');

        map.removeMarkers();

        GMaps.geocode({
            address: address,
            callback: function(results, status)
            {
                if(status === 'OK') {
                    var latlng = results[0].geometry.location;

                    map.setCenter(latlng.lat(), latlng.lng());

                    map.addMarker({
                        lat: latlng.lat(),
                        lng: latlng.lng()
                    });

                    $('input[name=lat]').val( latlng.lat() );
                    $('input[name=lng]').val( latlng.lng() );
                }

                btn.button('reset');
            }
        });
    });

});