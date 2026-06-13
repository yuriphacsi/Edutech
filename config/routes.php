<?php

$router->get('/', 'HomeController@index');

$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@authenticate');
$router->get('/logout', 'AuthController@logout');

# 🔐 RUTAS PROTEGIDAS
$router->get('/admin', 'AdminController@index')->middleware('role:1');
$router->get('/asesor', 'AsesorController@index')->middleware('role:2');
$router->get('/alumno', 'AlumnoController@index')->middleware('role:3');

# 👤 USUARIOS
$router->get('/usuarios', 'UsuarioController@index');
$router->get('/usuarios/create', 'UsuarioController@create');
$router->post('/usuarios/store', 'UsuarioController@store');
$router->get('/usuarios/edit', 'UsuarioController@edit');
$router->post('/usuarios/update', 'UsuarioController@update');
$router->get('/usuarios/delete', 'UsuarioController@delete');
$router->get('/usuarios/toggle', 'UsuarioController@toggle');

$router->get('/cursos', 'CursoController@index');

$router->get('/cursos/create', 'CursoController@create');
$router->post('/cursos/store', 'CursoController@store');

$router->get('/cursos/edit', 'CursoController@edit');
$router->post('/cursos/update', 'CursoController@update');

$router->post('/cursos/delete', 'CursoController@delete');

$router->get('/test', 'TestController@index');