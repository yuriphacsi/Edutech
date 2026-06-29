<div class="container">
    <h2>Control de Transacciones Recibidas</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Curso</th>
                <th>Monto</th>
                <th>Referencia</th>
                <th>Estado Actual</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['pagos'] as $pago): ?>
            <tr>
                <td><?= $pago['alumno_nombre']; ?></td>
                <td><?= $pago['curso_nombre']; ?></td>
                <td>$<?= number_format($pago['monto'], 2); ?></td>
                <td><?= $pago['referencia']; ?></td>
                <td><strong><?= strtoupper($pago['estado']); ?></strong></td>
                <td>
                    <?php if($pago['estado'] === 'pendiente'): ?>
                        <form action="/admin/pagos/validar" method="POST" style="display:inline;">
                            <input type="hidden" name="pago_id" value="<?= $pago['id']; ?>">
                            <button name="estado" value="aprobado" class="btn btn-success">Aprobar</button>
                            <button name="estado" value="rechazado" class="btn btn-danger">Rechazar</button>
                        </form>
                    <?php else: ?>
                        Procesado
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
