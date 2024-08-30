        //var global
        //let global;

        function buscar_datos() {
            
            var combo = document.getElementById("num_serie");
            var sel = combo.options[combo.selectedIndex].text;
            //let url = "<?php echo base_url('dashboard/buscar_datos');?>";
            let json = {
                'serie': sel
            }
            //console.log("buscar_datos: ", url);
            $.ajax({
                url: 'buscar_datos',
                type: 'POST',
                data: json,
                success: function(data){
                    console.log('datos crudos:',data);
                    var json = JSON.parse(data);
                    //global = json;
                    console.log('json.parse',json);
                    let placa = json.placa;
                    let dueno = json.nombre + ' ' + json.apellido_p;
                    document.getElementById('inp_placa').value = placa;
                    document.getElementById('inp_dueno').value = dueno;
                    
                }

            })
        }

        function enviar_datos(){
            let num_serie = document.getElementById('num_serie').value;
            let placas_id = global.placa_id;
            let duenos_id = global.placa_id;
            let descripcion = document.getElementById('descripcion').value;
            let fecha = document.getElementById('fecha_r').value;
            let json =
            {
                'num_serie' : num_serie,
                'placas_id' : placas_id,
                'duenos_id' : duenos_id,
                'descripcion' : descripcion,
                'fecha' : fecha
            }
            $.ajax({
                url: 'agregar_robo',
                type: 'POST',
                data: json,
                success: function(datos){
                    alert('Datos cargados');
                }
            })
        }
        