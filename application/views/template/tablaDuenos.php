<h2>Propietarios</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de termino</th>
                    <th>Fecha de registro</th>
                    <th>Actual</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($duenos as $dueno): ?>
                    <tr>
                        <td><?= $dueno->nombre?></td>
                        <td><?= $dueno->fecha_inicio?></td>
                        <td><?= $dueno->fecha_termino?></td>
                        <td><?= $dueno->fecha_registro?></td>
                        <td><?= $dueno->actual == 1? 'SI' : 'NO' ?></td>
                    </tr>
                <?php endforeach?>
            </tbody>
        </table>