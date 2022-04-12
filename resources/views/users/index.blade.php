
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
                        <input id="search" type="text" placeholder="Buscar"  class="form-control w-100">
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="data-table-default" class="table table-bordered table-td-valign-middle" style="width:100% !important">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre y Apellido</th>
                        <th>Usuario</th>
                        <th>Departamento</th>
                        <th>Nivel</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $('#users_nav').removeClass("closed").addClass("active").addClass("expand")
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
                let url = "{{ route('users.destroy', 'user_id' ) }}".replace('user_id', id);
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
            title: 'Crear Usuario',
            showConfirmButton: false,
            html:`
                <form id="form_user_create" >
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Nombre y Apellido <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="name" name="name" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese su Nombre y Apellido" >
                                    <div id="text-error-name"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Usuario</label>
                                <div class="col-lg-12">
                                    <input type="email"  id="email" name="email" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese su Usuario" >
                                    <div id="text-error-email"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Contraseña <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="password" id="password" name="password" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese su Contraseña" >
                                    <div id="text-error-password"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Departamentos <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <select id="department_id" class="form-control w-100">
                                        <option value="" selected  >Seleccione</option>
                                        @foreach( $departments as $item )
                                            <option value="{{ $item->id }}" > {{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                    <div id="text-error-department"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Niveles </label>
                                <div class="col-lg-12">
                                    <select id="level_id" class="form-control w-100">
                                        <option value="" selected  >Seleccione</option>
                                        @foreach( $levels as $item )
                                            <option value="{{ $item->id }}" > {{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                    <div id="text-error-level"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="margin-top:20px">
                            <button onclick="create_Submit()" type="button" class="swal2-confirm swal2-styled" aria-label="" style="display: inline-block;">Crear Usuario</button>
                        </div>
                    </div>
                </form>`
        })
        $('#nacimiento').datepicker({ format: "yyyy-mm-dd", language: "en" });
    }
    function edit(params) {
        console.log(params)
        Swal.fire({
            title: 'Editar Usuario',
            showConfirmButton: false,
            html:`
                <form id="form_user_edit" >
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Nombre y Apellido <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="name" name="name" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese su Nombre y Apellido" value="${params.name}">
                                    <div id="text-error-name"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Usuario</label>
                                <div class="col-lg-12">
                                    <input type="text"  id="email" name="email" disabled class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese su Usuario" value="${params.email}">
                                    <div id="text-error-email"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Contraseña <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text"  id="password" name="password" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese su Contraseña" >
                                    <div id="text-error-password"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Departamentos </label>
                                <div class="col-lg-12">
                                    <select id="departament_id" class="form-control w-100">
                                        <option value="" selected  >Seleccione</option>
                                        @foreach( $departments as $item )
                                            <option value="{{ $item->id }}" > {{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                    <div id="text-error-department"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Niveles <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                <select id="level_id" class="form-control w-100">
                                        <option value="" selected  >Seleccione</option>
                                        @foreach( $levels as $item )
                                            <option value="{{ $item->id }}" > {{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                    <div id="text-error-level"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="margin-top:20px">
                            <button onclick="edit_Submit(${params.id})" type="button" class="swal2-confirm swal2-styled" aria-label="" style="display: inline-block;">Editar Usuario</button>
                        </div>
                    </div>
                </form>`
        })
        $('#nacimiento').datepicker({ format: "yyyy-mm-dd", language: "en" });
    };

    /* funciones para hacer el crud */
    function edit_Submit(id) {
        let nac_user_act = $('#nacimiento').val()
        let name_user_act = $('#name').val()
        let celular_user_act = $('#celular').val()
        let cedula_user_act = $('#cedula').val()
        let email_user_act = $('#email').val()
        let dateCurrent = new Date();
        let edad_new = dateCurrent.getFullYear() - nac_user_act.split('-')[0]
        let url = "{{ route('users.update', 'user_id' ) }}".replace('user_id', id);
        $.ajax({
            url: url,
            type: "PUT",
            data: {
                "_token": $("meta[name='csrf-token']").attr("content"),
                "name": name_user_act,
                "nacimiento": nac_user_act,
                "edad": edad_new,
                "celular": celular_user_act,
            },
            success: function (res) {
                if($('#celular').val().match(/[a-zA-Z]/gi)){
                    $(`#celular`).removeClass('parsley-normal').addClass('parsley-error')
                    $(`#text-error-celular`).empty().append(`<ul class="parsley-errors-list filled"><li class="parsley-required" style="text-align: left"> Ingrese solo caracteres numericos </li></ul>`)
                    return 0
                }
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
        let name_user_act = $('#name').val()
        let department_id_act = $('#department_id').val()
        let level_id_act = $('#level_id').val()
        let password_user_act = $('#password').val()
        let email_user_act = $('#email').val()
        let url = "{{ route('users.store') }}";
        $.ajax({
            url: url,
            type: "POST",
            data: {
                "_token": $("meta[name='csrf-token']").attr("content"),
                "name": name_user_act,
                "department_id": department_id_act,
                "level_id": level_id_act,
                "password": password_user_act,
                "email": email_user_act,
            },
            success: function (res) {
                if($('#password').val().match(/[A-Z0-9]/gi)){ }else{
                    $(`#password`).removeClass('parsley-normal').addClass('parsley-error')
                    $(`#text-error-password`).empty().append(`<ul class="parsley-errors-list filled"><li class="parsley-required" style="text-align: left"> La contraseña debe contener: Numeros, Mayusculas y Caracteres Especiales ([-().^+) </li></ul>`)
                    return 0
                }
                if($('#celular').val().match(/[a-zA-Z]/gi)){
                    $(`#celular`).removeClass('parsley-normal').addClass('parsley-error')
                    $(`#text-error-celular`).empty().append(`<ul class="parsley-errors-list filled"><li class="parsley-required" style="text-align: left"> Ingrese solo caracteres numericos </li></ul>`)
                    return 0
                }
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





    dataTable("{{route('users.service')}}",[
        { data: 'id' },
        { data: 'name' },
        { data: 'email' },
        {
            render: function ( data,type, row  ) {
                return row.nameDepartment;
            }
        },
        {
            render: function ( data,type, row  ) {
                return row.nameLevel;
            }
        },
        {
            render: function ( data,type, row  ) {
                data_modal_current[row.id] = row
                let url_edit = "{{ route('users.edit', 'user_id' ) }}".replace('user_id', row.id);
                let url_destroy = "{{ route('users.destroy', 'user_id' ) }}".replace('user_id', row.id);
                return `
                    <a onclick="elim(${row.id})" style="color: var(--global-2)" class="btn btn-danger btn-icon btn-circle"><i class="fa fa-times"></i></a>
                    <a onclick="edit(data_modal_current[${row.id}])" style="color: var(--global-2)" class="btn btn-yellow btn-icon btn-circle"><i class="fas fa-pen"></i></a>
                `;
            }
        },
    ])





</script>
@endsection




