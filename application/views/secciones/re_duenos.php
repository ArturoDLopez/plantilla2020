
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
            <table id="tableV" data-url="<?= base_url()?>secciones/duenos/cargar_duenos" 
                data-pagination="true"
                data-side-pagination="server"
                data-page-size="10"
                data-page-list= "[10, 20, 30]"
                data-query-params= "queryParams"
            >
            <thead>
                <tr>
                    <th data-field="curp" >Curp</th>
                    <th data-field="nombre" >Nombre</th>
                    <th data-field="apellido_p" >Apellido paterno</th>
                    <th data-field="apellido_m" >Apellido Materno</th>
                    <th data-field="fecha_registro" >Fecha de registro</th>
                    <th data-field="id" data-formatter="acciones" data-align="center">Acciones</th>
                </tr>
            </thead>
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

<script src="../assets/js/modal.js"></script>
<script src="../assets/js/duenos.js"></script>