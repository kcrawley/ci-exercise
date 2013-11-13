var campaign = {
    initialize: function () {
        this.events();
    },
    events: function () {
        $(document).on('click', '.addNewModal', function () {
            var modalType = $(this).attr('id'),
                modalClient = '',
                modalTitle;

            switch (modalType) {
                case 'client':
                    modalTitle = 'Client Manager';
                    break;
                case 'contact':
                    modalTitle = 'Contact Manager';
                    modalClient = $("select[name='client_names_id'] option:selected").val();
                    break;
                case 'brand':
                    modalTitle = 'Brand Manager';
                    break;
            }

            $.get('/index.php/campaignmodal', { modalType: modalType, modalTitle: modalTitle, modalClient: modalClient },
                function (data) {
                    $('#modal').html(data);
                });
            $('#modal').modal();
        });

        $(document).on('click', '#triggerSave', function () {
            var formData = $(document).find('form#modal-form').serialize();

            $.post('/index.php/campaignmodal/save', formData, function (data) {
                if (data.status === true) {
                    campaign.reloadAndSetDropDown(data.id,
                        $(document).find('input.data-a').val(),
                        $(document).find('input[name="modalType"]').val()
                    );
                } else {
                    $('#modal').html(data.html);
                }
            }, 'json');
        });

        $(document).on('change', 'select[name="client_names_id"]', function () {
            if ($(this).val() !== '0') {
                window.location = '/index.php/campaigneditor/load/' + $(this).val();
            } else {
                window.location = '/';
            }
        });
    },
    reloadAndSetDropDown: function (targetId, targetValue, targetType) {
        $('#modal').modal('hide');

        switch (targetType) {
            case 'client':
                // force reloads the page in order to reset and load client
                window.location = '/index.php/campaigneditor/load/' + targetId;
                break;
            case 'contact':
                $("select[name='client_contacts_id']").append('<option value=' + targetId + '>' + targetValue + '</option>');
                $("select[name='client_contacts_id']").removeAttr('selected');
                $("select[name='client_contacts_id']").find('option[value="' + targetId + '"]').attr("selected", true);
                break;
            case 'brand':
                $("select[name='brand_options_id']").append('<option value=' + targetId + '>' + targetValue + '</option>');
                $("select[name='brand_options_id']").removeAttr('selected');
                $("select[name='brand_options_id']").find('option[value="' + targetId + '"]').attr("selected", true);
                break;
        }

        return false;
    }
};