<?php
/**
 * Main Entry Point (Router)
 */

require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../Router.php';


// Parse URI using the helper logic
$uri = current_route();

$router = new Router();

// --- AUTH ---
$router->get('', 'AuthController@login');
$router->get('login', 'AuthController@login');
$router->post('login', 'AuthController@login');
$router->get('logout', 'AuthController@logout');

// --- DASHBOARD ---
$router->get('dashboard', 'DashboardController@index');

// --- CLIENTS ---
$router->get('clients', 'ClientController@index');
$router->get('clients/create', 'ClientController@create');
$router->post('clients/create', 'ClientController@create');
$router->get('clients/show/{id}', 'ClientController@show');
$router->get('clients/edit/{id}', 'ClientController@edit');
$router->post('clients/edit/{id}', 'ClientController@edit');
$router->get('clients/delete/{id}', 'ClientController@delete'); // Should be POST/DELETE ideally, but GET for simplicity as per current views

// --- ASSURANCES ---
$router->get('assurances', 'AssuranceController@index');
$router->get('assurances/create', 'AssuranceController@create');
$router->post('assurances/create', 'AssuranceController@create');
$router->get('assurances/show/{id}', 'AssuranceController@show');
$router->get('assurances/edit/{id}', 'AssuranceController@edit');
$router->post('assurances/edit/{id}', 'AssuranceController@edit');
$router->get('assurances/delete/{id}', 'AssuranceController@delete');

// --- UTILISATEURS (Admin only) ---
$router->get('utilisateurs', 'UtilisateurController@index');
$router->get('utilisateurs/create', 'UtilisateurController@create');
$router->post('utilisateurs/create', 'UtilisateurController@create');
$router->get('utilisateurs/edit/{id}', 'UtilisateurController@edit');
$router->post('utilisateurs/edit/{id}', 'UtilisateurController@edit');
$router->get('utilisateurs/delete/{id}', 'UtilisateurController@delete');

// Dispatch
try {
    $router->dispatch($uri);
} catch (Exception $e) {
    echo "Erreur système : " . $e->getMessage();
}
