<div class="container">
    <h2>Mi Historial de Pagos (EduPay)</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Curso</th>
                <th>Monto</th>
                <th>Método</th>
                <th>Referencia</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['pagos'] as $pago): ?>
            <tr>
                <td><?= $pago['curso_nombre']; ?></td>
                <td>$<?= number_format($pago['monto'], 2); ?></td>
                <td><?= strtoupper($pago['metodo_pago']); ?></td>
                <td><?= $pago['referencia'] ?: 'N/A'; ?></td>
                <td><span class="badge badge-<?= $pago['estado']; ?>"><?= ucfirst($pago['estado']); ?></span></td>
                <td><?= $pago['fecha_pago']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
