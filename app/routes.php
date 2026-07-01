<?php

$router->get('', 'LoginController@index');
$router->get('login', 'LoginController@index');
$router->post('login', 'LoginController@efetuaLogin');
$router->get('logout', 'LoginController@logout');

$router->get('admin/index', 'IndexController@index');

$router->get('admin/reservas', 'ReservasController@index');
$router->post('admin/reservas/criar', 'ReservasController@criar');
$router->post('admin/reservas/checkin', 'ReservasController@checkin');
$router->post('admin/reservas/atualizar', 'ReservasController@atualizar');
$router->post('admin/reservas/deletar', 'ReservasController@deletar');

$router->get('admin/financeiro', 'FinanceiroController@index');
$router->post('admin/financeiro/abrir-caixa', 'FinanceiroController@abrirCaixa'); 
$router->post('admin/financeiro/sangria', 'FinanceiroController@sangria');
$router->post('admin/financeiro/fechar-caixa', 'FinanceiroController@fecharCaixa');

$router->get('admin/quartos', 'QuartosController@index');
$router->post('admin/quartos/status', 'QuartosController@updateStatus');

$router->get('admin/hospedes', 'HospedesController@index');
$router->post('admin/hospedes', 'HospedesController@store');
$router->post('admin/hospedes/update', 'HospedesController@update');
$router->post('admin/hospedes/delete', 'HospedesController@delete');
$router->get('admin/hospedes/buscar', 'HospedesController@buscar');

$router->get('admin/equipe', 'EquipeController@index');
$router->post('admin/equipe/create', 'EquipeController@create');
$router->post('admin/equipe/edit', 'EquipeController@edit');
$router->post('admin/equipe/delete', 'EquipeController@delete');

$router->get('admin/checkout', 'CheckoutController@index');
$router->post('admin/checkout/confirmar', 'CheckoutController@confirmar');
$router->post('admin/checkout/adicionarConsumo', 'CheckoutController@adicionarConsumo');
$router->post('checkout/confirmar-json', 'CheckoutController@confirmarJson');
