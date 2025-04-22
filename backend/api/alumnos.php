<?php
require_once '..\controllers\AlumnosController.php';
require_once '..\models\AlumnoModel.php';


use controllers\AlumnosController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


require __DIR__ . '\..\..\vendor\autoload.php';

$app = AppFactory::create();

$app->setBasePath("/sistema-rak/backend/api");

$app->addErrorMiddleware(true, true, true);

$alumnosController = new AlumnosController();

$app->get('/alumnos/{id}', function (Request $request, Response $response, $args) use ($alumnosController) 
{
	$newResponse = null;
	
	try 
	{
		//$newResponse = $response->withStatus(200)->withHeader('Content-type', 'application/json');
		$id = $args['id'];
		
		$response->withStatus(200)->withHeader('Content-type', 'application/json')->getBody()->write($alumnosController->getAlumno($id)->ToJson());
		//$response->withStatus(200)->withHeader('Content-type', 'application/json')->getBody()->write("Hola $id");
	} 
	catch (Exception $e) 
	{
		Throw new Exception("Error encontrado: $e->getMessage()");
	}
    
	return $response;
});
    
// Run app
$app->run();