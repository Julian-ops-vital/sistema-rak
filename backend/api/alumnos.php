<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use controllers\AlumnoController;

require __DIR__ . '\..\..\vendor\autoload.php';

$app = AppFactory::create();

$app->setBasePath("/sistema-rak/backend/api");
//$app->addRoutingMiddleware();

$app->addErrorMiddleware(true, true, true);

$app->get('/alumnos/{id}', function (Request $request, Response $response, $args) 
{
    $id = $args['id'];
    //$alumnosController = new AlumnoController();
    //$Alumno = $alumnosController->getAlumno($id);
    
    $response->getBody()->write("Hola $id");
    
    return $response;
});
    
// Run app
$app->run();