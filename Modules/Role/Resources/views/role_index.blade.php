@extends('adminlte::page')

@section('title', 'Role')

@section('content_header')
    <h1>Role / Jabatan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $roles->count() }}</h3>
                            <p>Role Terdaftar</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-tag"></i>
                        </div>
                        @can('admin')
                            <a href="javascript:void(0)" id="createRole" class="small-box-footer">
                                Tambah Role <i class="fas fa-plus-circle"></i>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $permissions->count() }}</h3>
                            <p>Permission Terdaftar</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        @can('admin')
                            <a href="javascript:void(0)" id="createPermission" class="small-box-footer">
                                Tambah Permission <i class="fas fa-plus-circle"></i>
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Role / Jabatan</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Role</th>
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $item)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @if (!empty($item->permissions))
                                                    @foreach ($item->permissions as $permission)
                                                        <label class="badge badge-success">
                                                            {{ $permission->name }}</label>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" data-tooltip="tooltip"
                                                    data-id="{{ $item->id }}" title="Edit"
                                                    class="edit btn btn-primary btn-xs btnEdit">
                                                    <i class="fas fa-edit"></i></a>

                                                <a href="javascript:void(0)" data-tooltip="tooltip"
                                                    data-id="{{ $item->id }}" title="Delete {{ $item->name }}"
                                                    class="edit btn btn-danger btn-xs btnDeletePermission">
                                                    <i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Permission</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Permission</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $item)
                                        <tr>
                                            <td>{{ ++$j }}</td>
                                            <td>
                                                <label class="badge badge-success">
                                                    {{ $item->name }}</label>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" data-tooltip="tooltip"
                                                    data-id="{{ $item->id }}" title="Edit {{ $item->name }}"
                                                    class="edit btn btn-primary btn-xs btnEditPermission">
                                                    <i class="fas fa-edit"></i></a>

                                                <a href="javascript:void(0)" data-tooltip="tooltip"
                                                    data-id="{{ $item->id }}" title="Delete {{ $item->name }}"
                                                    class="edit btn btn-danger btn-xs btnDeletePermission">
                                                    <i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalRole" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header  bg-success">
                    <h5 class="modal-title" id="modalHeading"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'admin.role.store', 'id' => 'roleForm', 'name' => 'roleForm', 'method' => 'POST', 'files' => true]) !!}
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Ada kesalahan input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="hidden" name="id" id="id">
                        {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'id' => 'name', 'placeholder' => 'Nama', 'autofocus', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="inputAlamat">Permission</label>
                        <div class="select2-blue">
                            <select name="permission[]" id="i_permission" class="select2 form-control" multiple
                                data-placeholder="Pilih Permission" data-dropdown-css-class="select2-blue">
                                @foreach ($permissions as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnSubmit"></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPermission" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="modalHeadingPermission"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'admin.permission.store', 'id' => 'formPermission', 'name' => 'formPermission', 'method' => 'POST', 'files' => true]) !!}
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Ada kesalahan input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="name_permission">Nama</label>
                        <input type="hidden" name="id" id="id_permission">
                        {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name_permission') ? ' is-invalid' : ''), 'id' => 'name_permission', 'placeholder' => 'Nama', 'autofocus', 'required']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnSubmitPermission"></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        $(function() {
            @if ($errors->any())
                $('#modalHeading').html("Role");
                $('#btnSubmit').html("Submit");
                $('#modalRole').modal('show');
            @endif

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#example2').DataTable({
                ajax: "{{ route('admin.role.index') }}",
                columns: [{
                        data: 'i',
                        name: 'i'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },{
                        data: 'name',
                        name: 'name'
                    },{
                        data: 'name',
                        name: 'name'
                    },
                ]
            });

            $('#createRole').click(function() {
                $('#roleForm').trigger("reset");
                $('#id').val('');
                $('#btnSubmit').html("Simpan");
                $('#modalHeading').html("Tambah Role / Jabatan");
                $('#modalRole').modal('show');
            });

            $('#createPermission').click(function() {
                $('#formPermission').trigger("reset");
                $('#id').val('');
                $('#btnSubmitPermission').html("Simpan");
                $('#modalHeadingPermission').html("Tambah Permission");
                $('#modalPermission').modal('show');
            });

            $('body').on('click', '.btnEdit', function() {
                var id = $(this).data('id');
                $.get("{{ route('admin.role.index') }}" + '/' + id + '/edit', function(data) {
                    $('#modalHeading').html("Edit Role");
                    $('#btnSubmit').html("Perbaharuis");
                    $('#id').val(data['role'].id);
                    $('#name').val(data['role'].name);
                    $('#i_permission').val(data['rolePermissions']).change();
                    $('#modalRole').modal('show');
                })
            });

            $('body').on('click', '.btnEditPermission', function() {
                var id = $(this).data('id');
                $.get("{{ route('admin.permission.index') }}" + '/' + id + '/edit', function(data) {
                    $('#id_permission').val(data['permission'].id);
                    $('#name_permission').val(data['permission'].name);
                    $('#modalHeadingPermission').html("Tambah Permission");
                    $('#btnSubmitPermission').html("Perbaharui");
                    $('#modalPermission').modal('show');
                })
            });

            $('body').on('click', '.btnDeletePermission', function() {
                var id = $(this).data('id');
                confirm("Apakah anda ingin menghapus data ini ?");
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.permission.store') }}" + '/' + id,
                });
            });
        });
    </script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
            });
            // $("#example2").DataTable({
            //     "responsive": true,
            //     "lengthChange": true,
            //     "autoWidth": false,
            // });
        });
    </script>
    <script>
        $(function() {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
