@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <h1>User / Pengguna</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="jumlah_user">{{ $users->total() }}</h3>
                            <p>User Terdaftar</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        @can('admin')
                            <a href="javascript:void(0)" id="createNewProduct" class="small-box-footer">
                                Tambah User <i class="fas fa-plus-circle"></i>
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data User</h3>
                </div>
                <div class="card-body">


                    <div class="dataTables_wrapper dataTable">
                        <div class="row">
                            <div class="col-sm-12">
                                @php
                                    $heads = ['ID', 'NIK', 'Name', 'Username'];
                                    $config['paging'] = false;
                                    $config['lengthMenu'] = false;
                                    $config['searching'] = false;
                                    $config['info'] = false;
                                @endphp
                                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered
                                    compressed>
                                    @foreach ($users as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->nik }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->username }}</td>
                                        </tr>
                                    @endforeach
                                </x-adminlte-datatable>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="dataTables_info">
                                    Tampil {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari total
                                    {{ $users->total() }}
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="dataTables_paginate pagination-sm">
                                    {{ $users->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header  bg-success">
                    <h5 class="modal-title" id="modelHeading"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- {!! Form::open(['route' => 'admin.user.store', 'id' => 'productForm', 'name' => 'productForm', 'method' => 'POST', 'files' => true]) !!}
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
                        <label for="nik">NIK</label>
                        <input type="hidden" name="id" id="id">
                        {!! Form::text('nik', null, ['class' => 'form-control' . ($errors->has('nik') ? ' is-invalid' : ''), 'id' => 'nik', 'placeholder' => 'NIK', 'autofocus']) !!}
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'id' => 'name', 'placeholder' => 'Nama', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="role">Role / Jabatan</label>
                        {!! Form::select('role', $roles, null, ['class' => 'form-control' . ($errors->has('roles') ? ' is-invalid' : ''), 'id' => 'role', 'placeholder' => 'Pilih Role / Jabatan', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="phone">Nomor Telephone</label>
                        {!! Form::text('phone', null, ['class' => 'form-control' . ($errors->has('phone') ? ' is-invalid' : ''), 'id' => 'phone', 'placeholder' => 'Nomor Telephone']) !!}
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        {!! Form::email('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'id' => 'email', 'placeholder' => 'Email', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        {!! Form::text('username', null, ['class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : ''), 'id' => 'username', 'placeholder' => 'Username', 'required']) !!}
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'id' => 'password', 'placeholder' => 'Password']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!} --}}
            </div>
        </div>
    </div>

@stop

@section('plugins.Datatables', true)
@section('js')
    <script type="text/javascript">
        @if ($errors->any())
            $('#ajaxModel').modal('show');
        @endif
    </script>

    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // var table = $('#example1').DataTable({
            //     serverSide: false,
            //     ajax: {
            //         url: '{{ route('admin.user.index') }}',
            //         data: function(data) {
            //             data.params = {
            //                 sac: "helo"
            //             }
            //         }
            //     },
            //     buttons: false,
            //     searching: true,
            //     scrollY: 500,
            //     // scrollX: true,
            //     scrollCollapse: true,
            //     columns: [{
            //             data: 'DT_RowIndex',
            //         },
            //         {
            //             data: 'nik',
            //         },
            //         {
            //             data: 'name',
            //         },
            //         {
            //             data: 'email',
            //         },
            //         {
            //             data: 'username',
            //         },
            //         {
            //             data: 'roles',
            //         },
            //         {
            //             data: 'action',
            //             orderable: false,
            //             searchable: false
            //         },
            //     ],
            // });

            $('#createNewProduct').click(function() {
                // $('#saveBtn').val("create-product");
                $('#id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Tambah User");
                $('#ajaxModel').modal('show');
            });
            $('body').on('click', '.editProduct', function() {
                var id = $(this).data('id');
                $.get("{{ route('admin.user.index') }}" + '/' + id + '/edit', function(data) {
                    $('#modelHeading').html("Edit Product");
                    // $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#id').val(data['user'].id);
                    $('#nik').val(data['user'].nik);
                    $('#name').val(data['user'].name);
                    // $('#role').val(data['role'][0]);
                    $('#phone').val(data['user'].phone);
                    $('#email').val(data['user'].email);
                    $('#username').val(data['user'].username);
                })
            });
        });
    </script>
    <script>
        // $(function() {
        //     $('#example1').DataTable({
        //         "lengthChange": false
        //     });
        // });
    </script>
@endsection
