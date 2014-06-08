(function($){
    'use strict';

    $(function(){
        $('select').chosen({allow_single_deselect: true});
        $('input.checkbox-toggle').bootstrapSwitch();
        $('input[data-role="datepicker"]').each(function(){
            var datepicker = $(this);
            datepicker.bootstrapDatePicker(datepicker.data());
        });
    });

    (function(){
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

        $.fn.dynamicAddressFields = function(dataUri){
            this.on('change', function(){
                var fieldNameFormat = $(this).attr('name').replace('countryCode', ':fieldname:');
                var countryCode     = $(this).val();
                var fieldset        = $(this).closest('fieldset');

                $.getJSON(dataUri + countryCode, function(data){
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

            return this.change();
        };
    }());

    (function(){
        function removeItem(event){
            event.preventDefault();
            $(this).closest('tr').remove();
        }

        function addInputCell(row, input){
            var td = $('<td/>');
            row.append(td);

            var formGroup = input.closest('div.form-group');

            if (formGroup.hasClass('has-error')) {
                td.addClass('has-error');
            }

            td.append(input).append(formGroup.find('ul.help-block'));
        }

        function updateElementIndex(element, index)
        {
            return element.attr('name', element.attr('name').replace('__index__', index));
        }

        $.fn.sortableItems = function(defaults){
            if (defaults !== undefined) {
                this.data('updateDefaults')(defaults);
                return this;
            }

            return this.each(function(){
                var container        = $(this);
                var legend           = container.children('legend');
                var fieldsets        = container.children('fieldset');
                var template         = $(container.children('span').data('template'));
                var defaultUnit      = null;
                var defaultUnitPrice = null;

                var table = $('<table class="table table-bordered"><thead><tr/></thead><tbody></table>');
                legend.after(table);

                var headRow = table.find('thead > tr');
                var templateElements = {
                    description: template.find('input[name*="[description]"]'),
                    quantity:    template.find('input[name*="[quantity]"]'),
                    unit:        template.find('select[name*="[unit]"]'),
                    unitPrice:   template.find('input[name*="[unitPrice]"]')
                };

                var tbody = table.children('tbody');

                var removeButton = $('<a href="#" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-minus"/></a>');
                var sortButton   = $('<a href="#" class="btn btn-default btn-sm sort"><span class="glyphicon glyphicon-sort"/></a>');
                var currentIndex = 0;

                var addButton = $('<a href="#" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"/></a>');
                addButton.on('click', function(event){
                    event.preventDefault();

                    var row = $('<tr/>');
                    row.append($('<td/>').append(removeButton.clone().on('click', removeItem)).append(' ').append(sortButton.clone()));
                    row.append($('<td/>').append(updateElementIndex(templateElements.description.clone(), currentIndex)));
                    row.append($('<td/>').append(updateElementIndex(templateElements.quantity.clone(), currentIndex)));
                    row.append($('<td/>').append(updateElementIndex(templateElements.unit.clone(), currentIndex)));
                    row.append($('<td/>').append(updateElementIndex(templateElements.unitPrice.clone(), currentIndex)));
                    tbody.append(row);
                    currentIndex++;

                    row.find('select[name*="[unit]"]').val(defaultUnit).chosen();
                    row.find('input[name*="[unitPrice]"]').val(defaultUnitPrice);
                });

                headRow.append($('<th class="col-sm-1"/>').append(addButton));
                headRow.append($('<th/>').text(templateElements.description.parent('div').prev('label').text()));
                headRow.append($('<th class="col-sm-2"/>').text(templateElements.quantity.parent('div').prev('label').text()));
                headRow.append($('<th class="col-sm-2"/>').text(templateElements.unit.parent('div').prev('label').text()));
                headRow.append($('<th class="col-sm-2"/>').text(templateElements.unitPrice.parent('div').prev('label').text()));

                fieldsets.each(function(){
                    var fieldset = $(this);
                    var row = $('<tr/>');
                    row.append($('<td/>').append(removeButton.clone().on('click', removeItem)).append(' ').append(sortButton.clone()));
                    addInputCell(row, fieldset.find('input[name*="[description]"]'));
                    addInputCell(row, fieldset.find('input[name*="[quantity]"]'));
                    addInputCell(row, fieldset.find('select[name*="[unit]"]'));
                    addInputCell(row, fieldset.find('input[name*="[unitPrice]"]'));
                    tbody.append(row);
                    row.find('select[name*="[unit]"]').chosen();
                    fieldset.remove();
                    currentIndex++;
                });

                tbody.sortable({
                    handle: '.sort'
                });

                container.data('updateDefaults', function(defaults){
                    defaultUnit      = defaults.defaultUnit;
                    defaultUnitPrice = defaults.defaultUnitPrice;

                    tbody.children('tr').each(function(){
                        var row = $(this);

                        if ($.trim(row.find('input[name*="[description]"]').val()) !== '') {
                            return;
                        }

                        row.find('select[name*="[unit]"]').val(defaultUnit).trigger('chosen:updated');
                        row.find('input[name*="[unitPrice]"]').val(defaultUnitPrice);
                    });
                });
            });
        };
    }());

    (function(){
        function updateItemDefaults(itemsFieldset, options, data, projectId){
            var project = {};

            if (projectId) {
                project = data.projects[projectId];
            }

            if (project.defaultUnitPrice) {
                itemsFieldset.sortableItems({
                    defaultUnit:      project.defaultUnit,
                    defaultUnitPrice: project.defaultUnitPrice
                });
            } else if (data.defaultUnitPrice) {
                itemsFieldset.sortableItems({
                    defaultUnit:      data.defaultUnit,
                    defaultUnitPrice: data.defaultUnitPrice
                });
            } else {
                itemsFieldset.sortableItems({
                    defaultUnit:      options.defaultUnit,
                    defaultUnitPrice: options.defaultUnitPrice
                });
            }
        }

        $.fn.updateFormFromClient = function(dataUri, options, itemsFieldset){
            this.on('change', function(){
                var fieldNameFormat = $(this).attr('name').replace('client', ':fieldname:');
                var clientId        = $(this).val();
                var fieldset        = $(this).closest('fieldset');

                var projectsSelect = fieldset.find('select[name="' + fieldNameFormat.replace(':fieldname:', 'project') + '"]');
                projectsSelect.html('');
                projectsSelect.val('');
                projectsSelect.append('<option value=""></option>');
                projectsSelect.trigger('chosen:updated');
                projectsSelect.off('change.updateFormFromClient');

                if (!clientId) {
                    fieldset.find('input[name="' + fieldNameFormat.replace(':fieldname:', 'vat') + '"]').val(options.defaultVat);
                    itemsFieldset.sortableItems(options);
                    return;
                }

                $.getJSON(dataUri + clientId, function(data){
                    $.each(data.projects, function(index, project){
                        projectsSelect.append($('<option/>').attr('value', project.id).text(project.name));
                    });
                    projectsSelect.trigger('chosen:updated');

                    fieldset.find('select[name="' + fieldNameFormat.replace(':fieldname:', 'locale') + '"]').val(data.locale).trigger('chosen:updated');
                    fieldset.find('select[name="' + fieldNameFormat.replace(':fieldname:', 'currencyCode') + '"]').val(data.currencyCode).trigger('chosen:updated');
                    fieldset.find('input[name="' + fieldNameFormat.replace(':fieldname:', 'vat') + '"]').val(data.taxable ? options.defaultVat : '');

                    projectsSelect.on('change.updateFormFromClient', function(){
                        updateItemDefaults(itemsFieldset, options, data, $(this).val());
                    });

                    updateItemDefaults(itemsFieldset, options, data, '');
                });
            });

            return this.change();
        };
    }());
}(jQuery));
