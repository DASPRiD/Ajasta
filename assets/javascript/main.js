$(function(){
    $('select').chosen();
    $('input.checkbox-toggle').bootstrapSwitch();

    $('input[data-role="datepicker"]').each(function(){
        var datepicker = $(this);
        datepicker.bootstrapDatePicker(datepicker.data());
    });
});

var addressFields = [
    'locality',
    'recipient',
    'organization',
    'addressLine1',
    'addressLine2',
    'dependentLocality',
    'administrativeArea',
    'postalCode',
    'sortingCode'
];

function dynamicAddressFields(countrySelect, dataUri) {
    countrySelect.on('change', function(e) {
        var fieldNameFormat = $(this).attr('name').replace('countryCode', ':fieldname:');
        var countryCode     = $(this).val();
        var fieldset        = $(this).closest('fieldset');

        $.getJSON(dataUri + countryCode, function (data) {
            $.each(addressFields, function(index, fieldName) {
                var field = fieldset.find('input[name="' + fieldNameFormat.replace(':fieldname:', fieldName) + '"]');
                var group = field.closest('div.form-group');

                if (!data.fields.hasOwnProperty(fieldName)) {
                    field.removeAttr('required');
                    group.hide();
                } else {
                    if (data.fields[fieldName]) {
                        field.attr('required', 'required');
                    } else {
                        field.removeAttr('required');
                    }

                    group.show();
                }
            });
        });
    });

    countrySelect.change();
}
