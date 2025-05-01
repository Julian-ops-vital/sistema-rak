<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Controllers\dtos\AlumnoDtoInsert;
use Controllers\dtos\AlumnoDtoUpdate;

$app->get('/alumnos/{id}', function (Request $request, Response $response, $args)
{
	try
	{
		$alumnosController = new Controllers\AlumnosController();
		$id = $args['id'];
		
		$response->getBody()->write($alumnosController->getAlumno($id)->ToJson());
	}
	catch (Exception $e)
	{
		Throw new Exception("Error encontrado: $e->getMessage()");
	}
	
	return $response->withStatus(200)->withHeader('Content-type', 'application/json');
});

$app->get('/alumnos', function (Request $request, Response $response)
{
	try
	{
		$alumnosController = new Controllers\AlumnosController();
		
		$response->getBody()->write(json_encode((array)$alumnosController->getAlumnos()));
	}
	catch (Exception $e)
	{
		Throw new Exception("Error encontrado: $e->getMessage()");
	}
	
	return $response->withStatus(200)->withHeader('Content-type', 'application/json');
});

$app->post('/alumnos', function (Request $request, Response $response, $args)
{
	try
	{
		$alumnosController = new Controllers\AlumnosController();
		
		$response->getBody()->write(json_encode($alumnosController->AddAlumno(new AlumnoDtoInsert($request->getParsedBody()['Alumno']))));
	}
	catch (Exception $e)
	{
		Throw new Exception("Error encontrado: $e->getMessage()");
	}
	
	return $response->withStatus(200)->withHeader('Content-type', 'application/json');
});

$app->put('/alumnos/{id}', function (Request $request, Response $response, $args)
{
	try
	{
		$id = $args['id'];
		
		$alumnosController = new Controllers\AlumnosController();
		
		$response->getBody()->write(json_encode($alumnosController->UpdateAlumno(new AlumnoDtoUpdate($request->getParsedBody()['Alumno'], $id))));
	}
	catch (Exception $e)
	{
		Throw new Exception("Error encontrado: $e->getMessage()");
	}
	
	return $response->withStatus(200)->withHeader('Content-type', 'application/json');
});

$app->delete('/alumnos/{id}', function (Request $request, Response $response, $args)
{
	try
	{
		$id = $args['id'];
		
		$alumnosController = new Controllers\AlumnosController();
		
		if($alumnosController->DeleteAlumno($id))
		{
			$response->withStatus(200);
		}
		else
		{
			$response->withStatus(404, 'alumno no encontrado');
		}
	}
	catch (Exception $e)
	{
		Throw new Exception("Error encontrado: $e->getMessage()");
	}
	
	return $response;
});