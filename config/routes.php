<?php

$router->get('/', 'HomeController@index');

/* =========================
   AUTH
========================= */
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@storeRegister');

$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@authenticate');
$router->get('/logout', 'AuthController@logout');

/* =========================
   DASHBOARDS PROTEGIDOS
========================= */
$router->get('/admin', 'AdminController@index')->middleware('role:1');
$router->get('/asesor', 'AsesorController@index')->middleware('role:2');
$router->get('/alumno', 'AlumnoController@index')->middleware('role:3');

/* =========================
   👤 USUARIOS (ADMIN ONLY)
========================= */
$router->get('/admin/usuarios', 'UsuarioController@index')->middleware('role:1');

$router->get('/admin/usuarios/create', 'UsuarioController@create')->middleware('role:1');
$router->post('/admin/usuarios/store', 'UsuarioController@store')->middleware('role:1');

$router->get('/admin/usuarios/edit', 'UsuarioController@edit')->middleware('role:1');
$router->post('/admin/usuarios/update', 'UsuarioController@update')->middleware('role:1');

$router->post('/admin/usuarios/delete', 'UsuarioController@delete')->middleware('role:1');
$router->post('/admin/usuarios/toggle', 'UsuarioController@toggle')->middleware('role:1');

/* =========================
   📚 CURSOS (ADMIN ONLY)
========================= */
$router->get('/admin/cursos', 'CursoController@index')->middleware('role:1');

$router->get('/admin/cursos/create', 'CursoController@create')->middleware('role:1');
$router->post('/admin/cursos/store', 'CursoController@store')->middleware('role:1');

$router->get('/admin/cursos/edit', 'CursoController@edit')->middleware('role:1');
$router->post('/admin/cursos/update', 'CursoController@update')->middleware('role:1');

$router->post('/admin/cursos/delete', 'CursoController@delete')->middleware('role:1');

/* =========================
   TEST
========================= */
$router->get('/test', 'TestController@index');