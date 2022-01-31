
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
                        <th>Tipos</th>
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
    $('#types_nav').removeClass("closed").addClass("active").addClass("expand")
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
                let url = "{{ route('types.destroy', 'id_replace' ) }}".replace('id_replace', id);
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
                        <div class="col-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Tipo de Dispositivo <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="name" name="name" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." >
                                    <div id="text-error-name"></div>
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
                        <div class="col-sm-12">
                            <div class="form-group row m-b-0">
                                <label class=" text-lg-right col-form-label"> Tipo de Dispositivo <span class="text-danger">*</span> </label>
                                <div class="col-lg-12">
                                    <input type="text" id="name" name="name" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="Ingrese ..." value="${params.name}">
                                    <div id="text-error-name"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="margin-top:20px">
                            <button onclick="edit_Submit(${params.id})" type="button" class="swal2-confirm swal2-styled" aria-label="" style="display: inline-block;">Editar</button>
                        </div>
                    </div>
                </form>`
        })
    };

    /* funciones para hacer el crud */
    function edit_Submit(id) {
        let name_act = $('#name').val()
        let url = "{{ route('types.update', 'id_replace' ) }}".replace('id_replace', id);
        $.ajax({
            url: url,
            type: "PUT",
            data: {
                "_token": $("meta[name='csrf-token']").attr("content"),
                "name": name_act,
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
        let name_act = $('#name').val()
        let url = "{{ route('types.store') }}";
        $.ajax({
            url: url,
            type: "POST",
            data: {
                "_token": $("meta[name='csrf-token']").attr("content"),
                "name": name_act,
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





    dataTable("{{route('types.service')}}",[
        { data: 'id' },
        { data: 'name' },
        {
            render: function ( data,type, row  ) {
                data_modal_current[row.id] = row
                let url_edit = "{{ route('types.edit', 'id_replace' ) }}".replace('id_replace', row.id);
                let url_destroy = "{{ route('types.destroy', 'id_replace' ) }}".replace('id_replace', row.id);
                return `
                    <a onclick="elim(${row.id})" style="color: var(--global-2)" class="btn btn-danger btn-icon btn-circle"><i class="fa fa-times"></i></a>
                    <a onclick="edit(data_modal_current[${row.id}])" style="color: var(--global-2)" class="btn btn-yellow btn-icon btn-circle"><i class="fas fa-pen"></i></a>
                `;
            }
        },
    ])





</script>
@endsection




