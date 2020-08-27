<meta name="csrf-token" content="{{ csrf_token() }}" />

{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://datatables.yajrabox.com/css/datatables.bootstrap.css" rel="stylesheet">
<script src="//code.jquery.com/jquery.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="js/handler.js"></script>
{{-- scripts from cdn and places --}}
<div id="test">
    <label for="searchfrom">Search From : </label>
    <select name="searchfrom" id="searchfrom">
        <option value="all">All</option>
        <option value="1">Name</option>
        <option value="2">Surname</option>
        <option value="3">Username</option>
        <option value="4">Phone</option>
        <option value="5">Email</option>
    </select>
    <input type="text" id="myInputTextField" placeholder="Search">
    <button type="button" class="btn btn-primary" id="addbtn" data-toggle="modal" data-target="#AddmyModal" style="float: right;">Add</button>
    <button type="button" class="btn btn-dark" style="float: right; href="{{ route('logout') }}" onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
    </button>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <table id="users-table" class="table">
        <thead>
            {{-- simple table, filled in the js --}}
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Power</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tfoot>
            {{-- simple table, filled in the js --}}
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Power</th>
                <th>Edit</th>
            </tr>
        </tfoot>
    </table>
</div>

{{-- this modal for Add / edit--}}
<div class="modal fade" id="myModal" role="dialog">


    <div class="modal-dialog">

        {{-- content --}}
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="modalTitle" class="modal-title">Edit User</h4>
            </div>
            {{-- error to be places here --}}
            <div class="alert alert-danger" style="display:none"></div>
            <div class="modal-body">
                <form id="modalFormData" name="modalFormData" class="form-horizontal" novalidate="">


                    <div class="form-group">
                        <label for="inputLink" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="eName" placeholder="Name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLink" class="col-sm-2 control-label">Surname</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="eSurName" placeholder="Surname" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLink" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="eUser" placeholder="Username" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLink" class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ePhone" placeholder="12345678" value="">
                        </div>
                    </div>
                    <div class="form-group" id="eEmailMain">
                        <label for="inputLink" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="eEmail" placeholder="abc@cba" value="">
                        </div>
                    </div>
                    <div class="form-group" id="ePassMain">
                        <label for="inputLink" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="ePass" placeholder="Pass" value="">
                        </div>
                        <label for="inputLink" class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="ePassC" placeholder="ConfPass" value="">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="eSave" value="edit">Save</button>
                <button type="button" class="btn btn-warning" id="eDel" value="delete">Delete</button>
                <button type="button" class="btn btn-danger" id="eDel2"  value="CONFIRM">CONFIRM</button>
                {{-- this is bad security management btw  --}}
                <input type="hidden" id="link_id" name="link_id" value="0">
                <input type="hidden" id="hiddenpow" name="hiddenpow" value="0">
            </div>
        </div>

    </div>
</div>
