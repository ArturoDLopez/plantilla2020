
<div class="container m-5 text-center" id="ve_container">
    <h1>
        Agregar Dueños
    </h1>
</div>

    <!-- Tabla de todos los duenos -->
<div class="container"  id="cls_container">

    <div class="container ve_container">
        <div class="row mb-1">
            <button onclick="llamar()" class="btn btn-success justify-content-center m-2 p-2">
                Registrar nuevo dueño
            </button>
        </div>
        
        <div class="row">
            <table id="tableV" data-url="<?= base_url()?>secciones/duenos/cargar_duenos" >
            </table>
        </div>
    </div>
</div>

<div class="modal" data-backdrop="static" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormLabel">Agregar dueños</h5>
      </div>
      <div class="modal-body">
        <form action="" method="post" id='frm_duenos'>
            <div class="row">

                <div class="form-group col-sm-4">
                    <label for="curp" class="">Curp</label>
                    <input type="text" class="form-control" required data-parsley-pattern="/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/" id="curp" name="curp" placeholder="Ingresa tu curp">
                </div>

                <div class="form-group col-sm-4">
                    <label for="nombre" class="">Nombre</label>
                    <input type="text" class="form-control" required id="nombre" name="nombre" placeholder="Ingresa tu nombre">
                </div>

                <div class="form-group col-sm-4">
                    <label for="ap" class="">Apellido paterno</label>
                    <input type="text" class="form-control" required id="ap" name="ap" placeholder="Ingresa tu apellido paterno">
                </div>

                <div class="form-group col-sm-4">
                    <label for="am" class="">Apellido materno</label>
                    <input type="text" class="form-control" required id="am" name="am" placeholder="Ingresa tu apellido materno">
                </div>
            </div>
            <div class="row">
            <div class="col-md-1">
            <button type="submit" id="btn_duenos" class="btn btn-success">Registrar</button>
        </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
                        
        <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal" onclick="cancelar_local()">Cancelar</button>

      </div>
    </div>
  </div>
</div>

<script src="../assets/js/modal.js">
    
</script>


<script>

    $(document).ready(function(){
        $('#frm_duenos').parsley();
        traer_datos(base_url + 'cargar_duenos', columns, tabla);
    });

    let base_url = "<?= base_url()?>secciones/duenos/";
    let elemento = document.getElementById('btn_duenos');
    let modal_id = "modalForm";
    let tabla = $("#tableV");
    let arreglo_campos = ['curp', 'nombre', 'ap', 'am'];
    let variable;
    let datosTabla = 0;
    let columns = [
        {
            field: 'curp', title: 'Curp'
        },
        {
            field: 'nombre', title: 'Nombre'
        },
        {
            field: 'apellido_p', title: 'Apellido paterno'
        },
        {
            field: 'apellido_m', title: 'Apellido materno'
        },
        {
            field: 'fecha_registro', title: 'Fecha de registro'
        },
        {
            field: 'id', title: 'Acciones', formatter: acciones, align: 'center'
        }

    ];

    $('#frm_duenos').on('submit', function(e){
        e.preventDefault();
        if($('#frm_duenos').parsley().isValid()){
            registrar_local();
            $('#frm_duenos').parsley().reset();
        }
    })

    function acciones(value, row, index){
        return `
            <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar(${row.id})">
                <i class="glyph-icon icon-edit"></i>
            </button>
            <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(${row.id}, '${base_url}eliminar_dueno', columns, tabla)">
                <i class="glyph-icon icon-trash"></i>
            </button>
        `;
    }

    function llamar(){
        llamar_modal(modal_id, arreglo_campos);
    }

    function rellenar(id){
        console.log('variables: '+id);
        $.ajax({
            url: base_url + 'consultar_dueno',
            method: 'POST',
            data: {'id': id},
            success: function(datos){
                datos = JSON.parse(datos);
                llamar_modal(modal_id, arreglo_campos);
                document.getElementById('modalFormLabel').innerHTML = 'Actualizar dueños';
                document.getElementById('btn_duenos').innerHTML = 'Actualizar';
                document.getElementById('curp').value = datos.curp;
                document.getElementById('nombre').value = datos.nombre;
                document.getElementById('ap').value = datos.apellido_p;
                document.getElementById('am').value = datos.apellido_m;
                variable = id;
            }
        })
    }

    function registrar_local(){
        $('#frm_duenos').parsley().reset();
        datos = {
                'curp' : document.getElementById('curp').value,
                'nombre' : document.getElementById('nombre').value,
                'ap' : document.getElementById('ap').value,
                'am' : document.getElementById('am').value,
            }
        if(elemento.innerHTML == 'Registrar'){
            document.getElementById('modalFormLabel').innerHTML = 'registrar dueño';
        }
        else{
            datos.id = variable;
        }
        registrar(base_url + 'agregar_dueno', base_url + 'editar_dueno', datos, elemento, columns, arreglo_campos, tabla);
    }

    function cancelar_local(){
        $('#frm_duenos').parsley().reset();
        cancelar('btn_duenos', 'btn_cancel', arreglo_campos);
    }
</script>