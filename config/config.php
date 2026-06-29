// Rutas del módulo de pagos
$router->post('/pago/procesar', 'PagoController@realizar');
$router->get('/alumno/pagos', 'PagoController@historialAlumno');
$router->get('/admin/pagos', 'PagoController@adminPagos');
$router->post('/admin/pagos/validar', 'PagoController@validar');
