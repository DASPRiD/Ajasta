$(function(){
    var labels = {
        'area': 'Area',
        'county': 'County',
        'department': 'Department',
        'district': 'District',
        'do_si': 'Do',
        'emirate': 'Emirate',
        'island': 'Island',
        'oblast': 'Oblast',
        'parish': 'Parish',
        'prefecture': 'Prefecture',
        'province': 'Province',
        'state': 'State',
        'city': 'City',
        'post_town': 'Post Town',
        'neighborhood': 'Neighborhood',
        'village_township': 'Village / Township',
        'suburb': 'Suburb',
        'postal': 'Postal Code',
        'zip': 'ZIP code',
        'pin': 'PIN code'
    };

    function updateLabels(fieldset, data)
    {
        if (null !== data.administrativeAreaType) {
            fieldset.find('[name$="administrativeArea"]').prev().text(
                labels[data.administrativeAreaType] + ':'
            );
        }

        if (null !== data.localityType) {
            fieldset.find('[name$="locality"]').prev().text(
                labels[data.localityType] + ':'
            );
        }

        if (null !== data.dependentLocalityType) {
            fieldset.find('[name$="dependentLocality"]').prev().text(
                labels[data.dependentLocalityType] + ':'
            );
        }

        if (null !== data.postalCodeType) {
            fieldset.find('[name$="postalCode"]').prev().text(
                labels[data.postalCodeType] + ':'
            );
        }
    }

    function updateAdministrativeAreaField(fieldset, administrativeAreaChoices)
    {
        if (!$.isEmptyObject(administrativeAreaChoices)) {
            var newAdministrativeAreaField = $('<select>');

            $.each(administrativeAreaChoices, function(index, value){
                var option = $('<option>');
                option.attr('value', index);
                option.text(value);

                newAdministrativeAreaField.append(option);
            });
        } else {
            var newAdministrativeAreaField = $('<input type="text">');
        }

        var oldAdministrativeAreaField = fieldset.find('[name$="administrativeArea"]');
        newAdministrativeAreaField.attr('name', oldAdministrativeAreaField.attr('name'));
        newAdministrativeAreaField.attr('id', oldAdministrativeAreaField.attr('id'));
        newAdministrativeAreaField.attr('class', oldAdministrativeAreaField.attr('class'));
        newAdministrativeAreaField.val(oldAdministrativeAreaField.val());
        oldAdministrativeAreaField.after(newAdministrativeAreaField).remove();
    }

    function updatePostalCodeField(fieldset, postalCodePattern)
    {
        if (null === postalCodePattern) {
            fieldset.find('[name$="postalCode"]').removeAttr('pattern');
            return;
        }

        fieldset.find('[name$="postalCode"]').attr('pattern', postalCodePattern);
    }

    $('fieldset[role="address"]').each(function(){
        var fieldset = $(this);
        var countryCodeField = fieldset.find('select[name$="countryCode"]');
        var prefix = countryCodeField.attr('name').replace(/countryCode$/, '');

        var updateFieldset = function(){
            var countryCode = countryCodeField.val();

            $.get('/address/get-country-data/' + countryCode, function(data) {
                fieldset.find('div.form-group').hide();
                countryCodeField.parent().show();

                updateLabels(fieldset, data);
                updateAdministrativeAreaField(fieldset, data.administrativeAreaChoices);
                updatePostalCodeField(fieldset, data.postalCodePattern);

                fieldset.find('input, select').removeAttr('required');

                $.each(data.usedFields, function(index, value){
                    fieldset.find('[name$="' + value + '"]').parent().show();
                });

                $.each(data.requiredFields, function(index, value){
                    fieldset.find('[name$="' + value + '"]').attr('required', 'required');
                });
            });
        };

        countryCodeField.on('change', updateFieldset);
        updateFieldset();
    });
});