jQuery(document).ready(function ($) {
    var lockedlinkid;
    var cuser = $.getJSON("http://127.0.0.1:8000/user_infos/get_cuser",
        function (data, textStatus, jqXHR) {
            console.log(cuser.responseJSON);

            var table = jQuery('#users-table').DataTable({
                // datatables lftipr
                sDom: 'tipr',
                processing: true,
                serverSide: true,
                ajax: 'http://127.0.0.1:8000/user_infos/get_data',
                columns: [{
                    data: 'id',
                },
                {
                    data: 'name'
                },
                {
                    data: 'surname'
                },
                {
                    data: 'username'
                },
                {
                    data: 'phone',
                    render: $.fn.DataTable.render.number('-', '.', 0, '+66 8-'),
                },
                {
                    data: 'email',
                },
                {
                    data: 'power',
                    orderable: false,
                    searchable: false
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        // adds edit button on the last collumn
                        //buttons are disabled for similar level
                        if (cuser.responseJSON.power <= data.power) {
                            return '<button type="button" class="btn btn-default" id="editbtn" disabled>Edit</button>';
                        }
                        else {
                            return '<button type="button" class="btn btn-info" id="editbtn">Edit</button>';
                        }
                    },
                    orderable: false,
                    searchable: false
                }
                ],
                pageLength: 10,
            });
            $('#searchfrom').on('change', function () {
                jQuery('#myInputTextField').val('');
                table.search('').draw();
                table.columns('').search('').draw();
                //resets search once the type changes 
            });
            $('#myInputTextField').keyup(function () {
                $searchfrom = jQuery('#searchfrom').val();
                if ($searchfrom == "all") {
                    table.search($(this).val()).draw();
                }
                else {
                    table.columns($searchfrom).search($(this).val()).draw();
                }
            });
            console.log(cuser.responseJSON.power);
            //only power 2 can add, this is only UI, technically can be bypassed by directly asking controller
            //update - already have a fail safe, but left open for testing 
            if (cuser.responseJSON.power != 2) {
                jQuery('#addbtn').hide();
            }
            else {
                jQuery('#addbtn').show();
            }
            jQuery('#addbtn').click(function () {
                // some hide/show/reset stuff
                jQuery('#modalTitle').text("Add New User");
                jQuery('#modalFormData').trigger("reset");
                jQuery('#eSave').val("add");
                jQuery('#eDel').hide();
                jQuery('#eDel2').hide();
                // jQuery('#eEmailMain').show();
                jQuery('#ePassMain').show();
                jQuery('#myModal').modal('show');
                jQuery('.alert-danger').hide();
            });
            // edit
            jQuery('#users-table tbody').on('click', 'button', function () {
                // jQuery(this).hide();
                var data = table.row(jQuery(this).parents('tr')).data();
                // gets the table info to find the row data
                var hiddenpow = data.power;
                var link_id = data.id;
                lockedlinkid = data.id;
                if (cuser.responseJSON.power <= hiddenpow) {
                    console.log("denied");
                    //incase ppl change thru inspect
                }
                else {
                    jQuery('#modalTitle').text("Edit User");
                    jQuery('#eName').val(data.name);
                    jQuery('#eSurName').val(data.surname);
                    jQuery('#eUser').val(data.username);
                    jQuery('#ePhone').val(data.phone);
                    // jQuery('#eEmailMain').hide();
                    jQuery('#eEmail').val(data.email);
                    jQuery('#ePassMain').hide();
                    jQuery('#eSave').val("edit");
                    jQuery('#eDel').show();
                    jQuery('#eDel2').hide();
                    jQuery('#link_id').val(link_id);
                    jQuery('#hiddenpow').val(hiddenpow);
                    //changes data to show in fields
                    jQuery("#myModal").modal('show');
                    jQuery('.alert-danger').hide();
                }
            });
            jQuery('#eDel2').hide();
            jQuery('#eDel').click(function () {  
                jQuery('#eDel2').show();
                console.log(lockedlinkid);
                jQuery('#eDel').hide();
            });
            jQuery('#eDel2').click(function () {
                
                // delete from db
                //jQuery('#eDel').addClass('class="btn btn-danger"');
                var link_id = jQuery('#link_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                console.log(lockedlinkid);
                $.ajax({
                    type: "DELETE",
                    url: 'user_infos/' + lockedlinkid,
                    success: function (data) {
                        console.log(link_id);
                        $("#link_id" + lockedlinkid).remove();
                        table.ajax.reload(null, false);
                        jQuery('#modalFormData').trigger("reset");
                        jQuery('#myModal').modal('hide');
                        jQuery('#eDel').show();
                        jQuery('#eDel2').hide();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        jQuery('.alert-danger').html('');
                        jQuery.each(data.responseJSON.errors, function (key, value) {
                            jQuery('.alert-danger').show();
                            jQuery('.alert-danger').append('<li>' + value + '</li>');
                        });
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
                    username: jQuery('#eUser').val(),
                    phone: jQuery('#ePhone').val(),
                    email: jQuery('#eEmail').val(),
                    power: jQuery('#hiddenpow').val(),
                    password: jQuery('#ePass').val(),
                    passwordConfirm: jQuery('#ePassC').val(),
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
                        jQuery('#eDel').show();
                        jQuery('#eDel2').hide();
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

});