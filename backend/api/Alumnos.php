<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim;
use Slim\App;
use controllers\AlumnoController;

require __DIR__ . '/../vendor/autoload.php';

$app = new App();

//$app->addRoutingMiddleware();

//$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/api/alumnos/{id}', function (Request $request, Response $response, $args) 
{
    $id = $args['id'];
    $alumnosController = new AlumnoController();
    $Alumno = $alumnosController->getAlumno($id);
    
    $response->getBody()->write($Alumno->ToJson());
    
    return $response;
});
    
// Run app
$app->run();