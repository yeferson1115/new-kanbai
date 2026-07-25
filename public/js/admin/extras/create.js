$(document).ready(function() {

    $('#btnEnviarExtra').click(function(event){
        event.preventDefault();

        $('.missing_alert').hide();

        // Validación del nombre del extra principal
        if ($('#main-form-extra #display_name').val() === '') {
            $('#main-form-extra #display_name_alert').text('Campo Obligatorio').show();
            $('#main-form-extra #display_name').focus();
            return false;
        }

        var data = $('#main-form-extra').serialize();

        $('#main-form-extra input, #main-form-extra button').attr('disabled', true);
        $('#ajax-icon-extra').removeClass('fa-save').addClass('fa-spin fa-refresh');

        $.ajax({
            url: $('#main-form-extra #_urlextra').val(),
            headers: {'X-CSRF-TOKEN': $('#main-form-extra #_tokenextra').val()},
            type: 'POST',
            cache: false,
            data: data,
            success: function (response) {

                // “response” YA ES JSON — NO LO PARSEES
                let json = response;

                if (json.success) {

                    // Restaurar botones
                    $('#main-form-extra input, #main-form-extra button').prop('disabled', false);
                    $('#ajax-icon-extra').removeClass('fa-spin fa-refresh').addClass('fa-save');

                    $('#modalextra').modal('hide');

                    // Armamos lista de items
                    let items = '';

                    json.extra.items.forEach(function(item) {

                        items += `
                            <li class="list-group-item">
                                <strong>${item.name}</strong>
                                <ul class="mt-2">
                        `;

                        item.values.forEach(function(v) {
                            items += `
                                <li>
                                    Min ${v.qty_min}, Max ${v.qty_max}
                                    <span class="text-success fw-bold"> → $${v.price}</span>
                                </li>`;
                        });

                        items += `
                                </ul>
                            </li>
                        `;
                    });

                    // Agregar extra a la lista principal
                    $("#extras").append(`
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="${json.extra.id}" name="extra_id[]" checked>

                            <label class="form-check-label">
                                <strong>${json.extra.name}</strong>

                                <ul class="list-group list-group-flush mt-2">
                                    ${items}
                                </ul>
                            </label>
                        </div>
                        <hr>
                    `);

                    _alertGeneric('success', 'Muy bien!', 'Extra agregado correctamente', null);
                }
            },

            error: function (data) {
                var errors = data.responseJSON;

                $('#main-form-extra input, #main-form-extra button').prop('disabled', false);
                $('#ajax-icon-extra').removeClass('fa-spin fa-refresh').addClass('fa-save');

                $.each(errors.errors, function(key, value) {
                    _alertGeneric('error', 'Error', value, null);
                    return false;
                });
            }
        });

        return false;
    });

});
