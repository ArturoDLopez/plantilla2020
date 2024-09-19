<h2>Robos</h2>
        <table>
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Descripcion</th>
                    <th>Fecha de robo</th>
                    <th>Fecha de registro</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($robos as $robo): ?>
                    <tr>
                        <td><?= $robo->placa?></td>
                        <td><?= $robo->descripcion?></td>
                        <td><?= $robo->fecha?></td>
                        <td><?= $robo->fecha_registro?></td>
                    </tr>
                <?php endforeach?>
            </tbody>
        </table>