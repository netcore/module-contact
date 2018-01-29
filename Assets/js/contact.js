$(function () {

    $('.search-map').click(function () {

        var locale = $(this).data('locale');

        var address = $('[name="translations[' + locale + '][address_full]"]').val();
        var btn = $(this).data('loading-text', '<i class="fa fa-spinner fa-spin"></i>').button('loading');

        var map = window['map_' + locale];
        var markers = window['markers_' + locale];
        var geocoder = window['geocoder_' + locale];

        var map_lat = $('input[name="translations[' + locale + '][lat]"]').val();
        var map_lng = $('input[name="translations[' + locale + '][lng]]"').val();

        markers[window['latLong_' + locale]].setMap(null);

        geocoder.geocode({address: address}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location); // Center the map over the result
                var latlng = results[0].geometry.location;
                
                // Place a marker at the location
                markers[window['latLong_' + locale]] = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });

                $('input[name="translations[' + locale + '][lat]"]').val(latlng.lat());
                $('input[name="translations[' + locale + '][lng]"]').val(latlng.lng());
            }

            btn.button('reset');
        });
    });

    // Init switcher
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

        if (data.type === 'workdays') {
            form.find('.js-workday-fields').removeClass('hidden');
            form.find('.js-other-fields').addClass('hidden');
            form.find('.js-contact-form').addClass('hidden');

            var tableBody = form.find('.js-workday-fields table tbody').empty();
            $.each(JSON.parse(data.default_value), function (field, value) {
                tableBody.append('<tr><td>' + field + '</td><td><input type="text" value="' + value + '" name="value[]" class="form-control"></td></tr>');
            })
        } else if (data.type === 'contact-form') {
            form.find('.js-contact-form').removeClass('hidden');
            form.find('.js-other-fields').addClass('hidden');
            form.find('.js-workday-fields').addClass('hidden');

            var currentFormId = JSON.parse(btn.parent().parent().attr('data-form_id'));
            var forms = JSON.parse(btn.parent().parent().attr('data-forms'));

            var select = $('.js-contact-form select');
            select.empty();

            $.each(forms, function (index, form) {
                var formId = form.id;
                var formName = form.name;
                if (currentFormId === formId) {
                    select.append($('<option value="' + formId + '" selected>' + formName + '</option>'));
                } else {
                    select.append($('<option value="' + formId + '">' + formName + '</option>'));
                }
            });
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
                    if (response.data.type === 'contact-form') {
                        var forms = JSON.parse(btn.parent().parent().attr('data-forms'));
                        var formName = '';
                        $.each(forms, function (index, form) {
                            if (form.id == response.data.default_value) {
                                formName = form.name;
                            }
                        });

                        row.find('.js-item-value').text(formName);
                    } else if (response.data.type === 'workdays') {
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
                        errorList += '<li>' + error[0] + '</li>'
                    });

                    dangerAlert.hide().removeClass('hidden').html(errorList).fadeIn();
                    form.find('input[type="submit"]').prop('disabled', false);
                }
            });
        })
    });
});
