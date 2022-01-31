
@extends('layouts.app')
@section('content')
<div class="panel panel-inverse" data-sortable-id="table-basic-1">
    <div class="panel-heading ui-sortable-handle">
        <h4 class="panel-title"></h4>
        <div class="panel-heading-btn"> 
            <button onclick="modal_type(1,{})" class="d-flex btn btn-1 btn-success">
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
                        <th>Color #1 (Fondo Tablas)</th>
                        <th>Color #2 (Color textos tabla)</th>
                        <th>Color #3 (Color primario)</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <template id="swald_template">
        <swal-html>
            <form id="form_user_create" >
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group row m-b-0">
                            <label class=" text-lg-right col-form-label"> Color #1 <span class="text-danger">*</span> </label>
                            <div class="col-lg-12">
                                <input type="text" id="color_primary" name="color_primary" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="- Vacio -" >
                                <div id="text_error_color_primary"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group row m-b-0">
                            <label class=" text-lg-right col-form-label"> Color #2 <span class="text-danger">*</span> </label>
                            <div class="col-lg-12">
                                <input type="text" id="color_secondary" name="color_secondary" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="- Vacio -" >
                                <div id="text_error_color_secondary"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group row m-b-0">
                            <label class=" text-lg-right col-form-label"> Color #3 <span class="text-danger">*</span> </label>
                            <div class="col-lg-12">
                                <input type="text"  id="color_tertiary" name="color_tertiary" class="form-control parsley-normal upper" style="color: var(--global-2) !important" placeholder="- Vacio -" >
                                <div id="text_error_color_tertiary"></div>
                            </div>
                        </div> 
                    </div>
                </div>
            </form>
        </swal-html>
    </template>
</div>
@endsection
@section('js')
<script>
    $('#palette_colors_nav').removeClass("closed").addClass("active").addClass("expand")
    let current_data = {}

    function modal_type(type, params) {
        let payload = { }
        switch (type) {
            case 1:
                payload.setting = { url: "{{ route('palette_colors.store') }}", type: "POST", id: (params) ? params.id : 0 }
                payload.swal = {
                    title: 'Crear Paleta',
                    template: '#swald_template',
                    text: false,
                    icon: false,
                    confirmButtonText: '<i class="fa fa-save"></i>',
                    showCloseButton: true,
                    confirmButtonColor: `{!! ( $palette_colors ) ? $palette_colors->color_tertiary: '#00cbff !important' !!}`,
                    allowOutsideClick: false,
                }
            break;
            case 2:
                payload.setting = { url: "{{ route('palette_colors.update', 'user_id' ) }}".replace('user_id', params.id), type: "PUT", id: (params) ? params.id : 0 }
                payload.swal = {
                    title: 'Editar Paleta',
                    template: '#swald_template',
                    text: false,
                    icon: false,
                    confirmButtonText: '<i class="fa fa-save"></i>',
                    showCloseButton: true,
                    confirmButtonColor: `{!! ( $palette_colors ) ? $palette_colors->color_tertiary: '#00cbff !important' !!}`,
                    allowOutsideClick: false,
                }
            break;
            case 3:
                payload.setting = { url: "{{ route('palette_colors.destroy', 'user_id' ) }}".replace('user_id', params.id), type: 'DELETE', id: (params) ? params.id : 0 }
                payload.swal = {
                    title: 'Estás seguro?',
                    template: false,
                    text: 'No serás capaz de recuperar el registro a borrar!',
                    icon: 'error',
                    confirmButtonText: '<i class="fa fa-save"></i>',
                    showCloseButton: true,
                    confirmButtonColor: `{!! ( $palette_colors ) ? $palette_colors->color_tertiary: '#00cbff !important' !!}`,
                    allowOutsideClick: false,
                }
            break;
            case 4:
                payload.setting = { url: "/palette_colors/perfil_colors_change", type: 'POST', id: (params) ? params.id : 0 }
                payload.swal = {
                    title: `Perfil de colores #${params.id}`,
                    template: false,
                    text: 'Seguro que desea establecer este perfil?',
                    icon: 'info',
                    confirmButtonText: '<i class="fa fa-save"></i>',
                    showCloseButton: true,
                    confirmButtonColor: `{!! ( $palette_colors ) ? $palette_colors->color_tertiary: '#00cbff !important' !!}`,
                    allowOutsideClick: false,
                }
            break;
        }
        modal_swal(payload)
    }

    function modal_swal(params) {
        let payload = params
        Swal.fire(payload.swal).then((result) => {
            if (result.isConfirmed) {
                send_data(payload)
            }
        });
    }

    function send_data(params){
        let payload = params
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: payload.setting.url,
            type: payload.setting.type,
            data: {
                "id": payload.setting.id,
                "color_primary": $('#color_primary').val(),
                "color_secondary": $('#color_secondary').val(),
                "color_tertiary": $('#color_tertiary').val(),
            },
            success: function (res) {
                if(res.type === 'error'){
                    Object.keys(res.data).find( ( item ) => {
                        $(`#${item}`).removeClass('parsley-normal').addClass('parsley-error')
                        $(`#text_error_${item}`).empty().append(`<ul class="parsley-errors-list filled"><li class="parsley-required" style="text-align: left"> ${ res.data[item] } </li></ul>`)
                    })
                }
                if(res.type === 'success'){
                    location.reload();
                }
            }
        });
    }

    dataTable("{{route('palette_colors.service')}}",[
        { data: 'id' },
        { data: 'color_primary' },
        { data: 'color_secondary' },
        { data: 'color_tertiary' },
        { 
            render: function ( data,type, row  ) {  
                let dateCurrent = (row.active === 1) ? 'ACTIVO' : ''
                return  dateCurrent;
            }
        },
        { 
            render: function ( data,type, row  ) {
                current_data = row
                return `
                    <a onclick="modal_type(3,current_data)" style="color: var(--global-2)" class="btn btn-danger btn-icon btn-circle"><i class="fa fa-times"></i></a>
                    <a onclick="modal_type(2,current_data)" style="color: var(--global-2)" class="btn btn-yellow btn-icon btn-circle"><i class="fas fa-pen"></i></a>
                    <a onclick="modal_type(4,current_data)" style="color: var(--global-2);background-color: #04c142 !important" class="btn btn-yellow btn-icon btn-circle"><i class="fas fa-star"></i></a>
                `;
            }
        },
    ])  
</script>
@endsection




