jQuery(document).ready(function ($) {
    var table = jQuery('#users-table').DataTable({
        // datatables 
        processing: true,
        serverSide: true,
        ajax: 'http://127.0.0.1:8000/user_infos/get_data',
        columns: [{
            data: 'id'
        },
        {
            data: 'name'
        },
        {
            data: 'surname'
        },
        {
            data: 'address'
        },
        {
            data: 'age'
        },
        {
            data: 'salary',
            // format 
            render: $.fn.DataTable.render.number(',', '.', 0, '$')
        },
        {
            data: null,
            render: function (data, type, row) {
                // adds edit button on the last collumn
                return '<button type="button" id="editbtn">Edit</button>';
            },
            targets: 'no-sort',
            orderable: false,
            searchable: false
        },
        ],
        pageLength: 10,
    });
    jQuery('#addbtn').click(function () {
        // some hide/show/reset stuff
        jQuery('#modalTitle').text("Add New User");
        jQuery('#modalFormData').trigger("reset");
        jQuery('#eSave').val("add");
        jQuery('#eDel').hide();
        jQuery('#myModal').modal('show');
        jQuery('.alert-danger').hide();
    });

    jQuery('#users-table tbody').on('click', 'button', function () {
        var data = table.row(jQuery(this).parents('tr')).data();
        // gets the table info to find the row data
        var link_id = data.id;
        console.log(link_id);
        jQuery('#eName').val(data.name);
        jQuery('#eSurName').val(data.surname);
        jQuery('#eAdr').val(data.address);
        jQuery('#eAge').val(data.age);
        jQuery('#eSalary').val(data.salary);
        jQuery('#eSave').val("edit");
        jQuery('#eDel').show();
        jQuery('#link_id').val(link_id);
        //changes data to show in fields
        jQuery("#myModal").modal('show');
        jQuery('.alert-danger').hide();
    });

    jQuery('#eDel').click(function () {
        // delete from db
        var link_id = jQuery('#link_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "DELETE",
            url: 'user_infos/' + link_id,
            success: function (data) {
                console.log("delete"+data);
                $("#link_id" + link_id).remove();
                table.ajax.reload(null, false);
                jQuery('#modalFormData').trigger("reset");
                jQuery('#myModal').modal('hide');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    $("#eSave").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        //data to be sent 
        var formData = {
            name: jQuery('#eName').val(),
            surname: jQuery('#eSurName').val(),
            address: jQuery('#eAdr').val(),
            age: jQuery('#eAge').val(),
            salary: jQuery('#eSalary').val(),
        };
        //check for button edit or add
        var state = jQuery('#eSave').val();
        var type = "POST";
        var link_id = jQuery('#link_id').val();
        var ajaxurl = 'user_infos/add';
        if (state == "edit") {
            type = "PUT";
            console.log("Linking b4 send" + link_id);
            ajaxurl = 'user_infos/' + link_id;
        }
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                table.ajax.reload(null, false);
                // reloads using ajax
                jQuery('#modalFormData').trigger("reset");
                jQuery('#myModal').modal('hide');
                //hides the modal after completion
            },
            error: function (data) {
                //error to be shown in modal
                console.log('Error:', data);
                jQuery('.alert-danger').html('');
                jQuery.each(data.responseJSON.errors, function (key, value) {
                    jQuery('.alert-danger').show();
                    jQuery('.alert-danger').append('<li>' + value + '</li>');
                });
            }
        });
    });
});