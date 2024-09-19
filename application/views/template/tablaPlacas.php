<h2>Placas</h2>
        <table>
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de termino</th>
                    <th>Fecha de registro</th>
                    <th>Actual</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($placas as $placa): ?>
                    <tr>
                        <td><?= $placa->placa?></td>
                        <td><?= $placa->fecha_inicio?></td>
                        <td><?= $placa->fecha_termino?></td>
                        <td><?= $placa->fecha_registro?></td>
                        <td><?= $placa->actual == 1? 'SI' : 'NO' ?></td>
                    </tr>
                <?php endforeach?>
            </tbody>
        </table>