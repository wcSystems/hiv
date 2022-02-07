
@extends('layouts.app')
@section('content')
<div class="panel panel-inverse" data-sortable-id="table-basic-1">
    <div class="panel-heading ui-sortable-handle">
        <h4 class="panel-title"></h4>
        <div class="panel-heading-btn">
            <button onclick="create()" class="d-flex btn btn-1 btn-success">
                <i class="m-auto fa fa-lg fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 form-inline mb-3">
                <div class="form-group w-100">
                    <div class="px-0 col-xs-12 col-sm-7 col-md-6 col-lg-8">
                        <input id="search" type="text" placeholder="Buscar Host"  class="form-control w-100">
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 form-inline mb-3">
                <div class="form-group w-100">
                    <div class="px-0 col-xs-12 col-sm-7 col-md-6 col-lg-8">
                        <select id="search_network" class="form-control w-100">
                            <option value="" selected >Nodos</option>
                            @foreach( $networks as $item )
                                <option value="{{ $item->id }}" > {{ $item->a }}.{{ $item->b }}.{{ $item->c }}.0 </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 form-inline mb-3">
                <div class="form-group w-100">
                    <div class="px-0 col-xs-12 col-sm-7 col-md-6 col-lg-8">
                        <select id="search_type" class="form-control w-100">
                            <option value="" selected  >Tipos</option>
                            @foreach( $types as $item )
                                <option value="{{ $item->id }}" > {{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 form-inline mb-3">
                <div class="form-group w-100">
                    <div class="px-0 col-xs-12 col-sm-7 col-md-6 col-lg-8">
                        <select id="search_block" class="form-control w-100">
                            <option value="" selected >Bloques</option>
                            @foreach( $blocks as $item )
                                <option value="{{ $item->id }}" > {{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="data-table-default" class="table table-bordered table-td-valign-middle" style="width:100% !important">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ip</th>
                        <th>Tipo</th>
                        <th>Bloque</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>SSID</th>
                        <th>Contraseña SSID</th>
                        <th>MAC</th>
                        <th>Descripcion</th>
                        {{-- <th>Acciones</th> --}}
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    let blocks = {!! $blocks !!}
    let types = {!! $types !!}
    let networks = {!! $networks !!}
    $('#devices_nav').removeClass("closed").addClass("active").addClass("expand")
    let data_modal_current = []

    /* funciones para ejecutar la modal */
    function elim(id) {
        Swal.fire({
            title: 'Estás seguro?',
            text: 'No serás capaz de recuperar el registro a borrar!',
            icon: 'error',
            showCancelButton: false
        }).then((result) => {
            if (result.isConfirmed) {
                let url = "{{ route('devices.destroy', 'id_replace' ) }}".replace('id_replace', id);
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        "_token": $("meta[name='csrf-token']").attr("content")
                    },
                    success: function (res) {
                        if(res.type === 'success'){
                            location.reload();
                        }
                    }
                });
            }
        });
    };
    function create() {
        Swal.fire({
            title: 'Crear',
            showConfirmButton: false,
            html:`
                <form id="form_user_create" >
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Nodo <span class="text-danger">*</span> </label>
                                <select id="network_id" class="form-control w-100">
                                    <option value="0" selected disabled >Seleccione ...</option>
                                    @foreach( $networks as $item )
                                        <option value="{{ $item->id }}" > {{ $item->a }}.{{ $item->b }}.{{ $item->c }}.0 </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Host <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="number" id="host" name="host" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." >
                                    <div id="text-error-host"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Tipo <span class="text-danger">*</span> </label>
                                <select id="type_id" class="form-control w-100">
                                    <option value="0" selected disabled >Seleccione ...</option>
                                    @foreach( $types as $item )
                                        <option value="{{ $item->id }}" > {{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Nombre <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="name" name="name" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." >
                                    <div id="text-error-name"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Bloque <span class="text-danger">*</span> </label>
                                <select id="block_id" class="form-control w-100">
                                    <option value="0" selected disabled >Seleccione ...</option>
                                    @foreach( $blocks as $item )
                                        <option value="{{ $item->id }}" > {{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Usuario <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="username" name="username" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." >
                                    <div id="text-error-username"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Contraseña <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="password" name="password" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." >
                                    <div id="text-error-password"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> SSID <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="ssid" name="ssid" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." >
                                    <div id="text-error-ssid"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Contraseña SSID <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="ssid_password" name="ssid_password" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." >
                                    <div id="text-error-ssid_password"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> MAC <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="mac" name="mac" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." >
                                    <div id="text-error-mac"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Descripcion <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <textarea type="text" id="description" name="description" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." ></textarea>
                                    <div id="text-error-description"></div>
                                </div>
                            </div>
                        </div>



                        <div class="col-sm-12" style="margin-top:20px">
                            <button onclick="create_Submit()" type="button" class="swal2-confirm swal2-styled" aria-label="" style="display: inline-block;">Crear</button>
                        </div>
                    </div>
                </form>`
        })
    }
    function edit(params) {

        Swal.fire({
            title: 'Editar',
            showConfirmButton: false,
            html:`
                <form id="form_user_edit" >
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Nodo <span class="text-danger">*</span> </label>
                                <select id="network_id" class="form-control w-100">
                                    <option value="0" selected disabled >Seleccione ...</option>
                                    @foreach( $networks as $item )
                                        <option value="{{ $item->id }}" > {{ $item->a }}.{{ $item->b }}.{{ $item->c }}.0 </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Host <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="number" id="host" name="host" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." value="${params.host}" >
                                    <div id="text-error-host"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Tipo <span class="text-danger">*</span> </label>
                                <select id="type_id" class="form-control w-100">
                                    <option value="0" selected disabled >Seleccione ...</option>
                                    @foreach( $types as $item )
                                        <option value="{{ $item->id }}" > {{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Nombre <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="name" name="name" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." value="${params.name}" >
                                    <div id="text-error-name"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Bloque <span class="text-danger">*</span> </label>
                                <select id="block_id" class="form-control w-100">
                                    <option value="0" selected disabled >Seleccione ...</option>
                                    @foreach( $blocks as $item )
                                        <option value="{{ $item->id }}" > {{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Usuario <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="username" name="username" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." value="${params.username}" >
                                    <div id="text-error-username"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Contraseña <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="password" name="password" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." value="${params.password}" >
                                    <div id="text-error-password"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> SSID <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="ssid" name="ssid" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." value="${params.ssid}" >
                                    <div id="text-error-ssid"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Contraseña SSID <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="ssid_password" name="ssid_password" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." value="${params.ssid_password}" >
                                    <div id="text-error-ssid_password"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> MAC <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="mac" name="mac" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." value="${params.mac}" >
                                    <div id="text-error-mac"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Descripcion <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <textarea type="text" id="description" name="description" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." >${params.description}</textarea>
                                    <div id="text-error-description"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="margin-top:20px">
                            <button onclick="edit_Submit(${params.id})" type="button" class="swal2-confirm swal2-styled" aria-label="" style="display: inline-block;">Editar</button>
                        </div>
                    </div>
                </form>`
        })
        $('#network_id').val(params.network_id)
        $('#type_id').val(params.type_id)
        $('#block_id').val(params.block_id)
    };

    /* funciones para hacer el crud */
    function edit_Submit(id) {
        let network_id = $('#network_id').val()
        let host = parseInt($('#host').val())
        let type_id = $('#type_id').val()
        let name = $('#name').val()
        let block_id = $('#block_id').val()
        let username = $('#username').val()
        let password = $('#password').val()
        let ssid = $('#ssid').val()
        let ssid_password = $('#ssid_password').val()
        let mac = $('#mac').val()
        let description = $('#description').val()
        let url = "{{ route('devices.update', 'id_replace' ) }}".replace('id_replace', id);
        $.ajax({
            url: url,
            type: "PUT",
            data: {
                "_token": $("meta[name='csrf-token']").attr("content"),
                "network_id": network_id,
                "host": host,
                "type_id": type_id,
                "name": name,
                "block_id": block_id,
                "username": username,
                "password": password,
                "ssid": ssid,
                "ssid_password": ssid_password,
                "mac": mac,
                "description": description,
            },
            success: function (res) {
                if(res.type === 'error'){
                    Object.keys(res.data).find( ( item ) => {
                        $(`#${item}`).removeClass('parsley-normal').addClass('parsley-error')
                        $(`#text-error-${item}`).empty().append(`<ul class="parsley-errors-list filled"><li class="parsley-required" style="text-align: left"> ${ res.data[item] } </li></ul>`)
                    })
                }
                if(res.type === 'success'){
                    location.reload();
                }
            }
        });

    }
    function create_Submit() {
        let network_id = $('#network_id').val()
        let host = $('#host').val()
        let type_id = $('#type_id').val()
        let name = $('#name').val()
        let block_id = $('#block_id').val()
        let username = $('#username').val()
        let password = $('#password').val()
        let ssid = $('#ssid').val()
        let ssid_password = $('#ssid_password').val()
        let mac = $('#mac').val()
        let description = $('#description').val()
        let url = "{{ route('devices.store') }}";
        $.ajax({
            url: url,
            type: "POST",
            data: {
                "_token": $("meta[name='csrf-token']").attr("content"),
                "network_id": network_id,
                "host": host,
                "type_id": type_id,
                "name": name,
                "block_id": block_id,
                "username": username,
                "password": password,
                "ssid": ssid,
                "ssid_password": ssid_password,
                "mac": mac,
                "description": description,
            },
            success: function (res) {
                if(res.type === 'error'){
                    Object.keys(res.data).find( ( item ) => {
                        $(`#${item}`).removeClass('parsley-normal').addClass('parsley-error')
                        $(`#text-error-${item}`).empty().append(`<ul class="parsley-errors-list filled"><li class="parsley-required" style="text-align: left"> ${ res.data[item] } </li></ul>`)
                    })
                }
                if(res.type === 'success'){
                    location.reload();
                }
            }
        });

    }





    dataTable("{{route('devices.service')}}",[
        { data: 'id' },
        {
            render: function ( data,type, row  ) {
                let ip = `${networks.find( i => i.id === row.network_id).a}.${networks.find( i => i.id === row.network_id).b}.${networks.find( i => i.id === row.network_id).c}.${row.host}`
                return ip;
            }
        },
        {
            render: function ( data,type, row  ) {

                return types.find( i => i.id === row.type_id).name;
            }
        },
        {
            render: function ( data,type, row  ) {

                return blocks.find( i => i.id === row.block_id).name;
            }
        },
        { data: 'name' },
        { data: 'username' },
        { data: 'password' },
        { data: 'ssid' },
        { data: 'ssid_password' },
        { data: 'mac' },
        { data: 'description' },
        /* {
            render: function ( data,type, row  ) {
                data_modal_current[row.id] = row
                let url_edit = "{{ route('devices.edit', 'id_replace' ) }}".replace('id_replace', row.id);
                let url_destroy = "{{ route('devices.destroy', 'id_replace' ) }}".replace('id_replace', row.id);
                return `
                    <a onclick="elim(${row.id})" style="color: var(--global-2)" class="btn btn-danger btn-icon btn-circle"><i class="fa fa-times"></i></a>
                    <a onclick="edit(data_modal_current[${row.id}])" style="color: var(--global-2)" class="btn btn-yellow btn-icon btn-circle"><i class="fas fa-pen"></i></a>
                `;
            }
        }, */
    ])





</script>
@endsection




