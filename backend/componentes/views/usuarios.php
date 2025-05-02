<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Controllers\UsuariosController;
use Controllers\dtos\Usuarios\LoginDto;
use Controllers\dtos\Usuarios\UsuarioDtoInsert;

$app->post('/login', function (Request $request, Response $response, $args)
{
	try
	{
		$controller = new UsuariosController();
		
		$response->getBody()->write(json_encode($controller->Login(new LoginDto($request->getParsedBody()['Login']))));
	}
	catch (Exception $e)
	{
		Throw new Exception("Error encontrado: $e->getMessage()");
	}
	
	return $response->withStatus(200)->withHeader('Content-type', 'application/json');
});

$app->post('/usuarios', function (Request $request, Response $response, $args)
{
	try
	{
		$UsuariosController = new UsuariosController();
		
		$response->getBody()->write(json_encode($UsuariosController->AddUsuario(new UsuarioDtoInsert($request->getParsedBody()['Usuario']))));
	}
	catch (Exception $e)
	{
		Throw new Exception("Error encontrado: $e->getMessage()");
	}
	
	return $response->withStatus(200)->withHeader('Content-type', 'application/json');
});

$app->put('/usuarios/{id}', function (Request $request, Response $response, $args)
{
	try
	{
		$id = $args['id'];
		
		$UsuariosController = new UsuariosController();
		
		$response->getBody()->write(json_encode($UsuariosController->UpdateUsuario(new UsuarioDtoUpdate($request->getParsedBody()['Usuario'], $id))));
	}
	catch (Exception $e)
	{
		Throw new Exception("Error encontrado: $e->getMessage()");
	}
	
	return $response->withStatus(200)->withHeader('Content-type', 'application/json');
});

$app->put('/usuarios/{id}/password', function (Request $request, Response $response, $args)
{
	try
	{
		$id = $args['id'];
		$newPassword = (string)$request->getParsedBody()['Password'];
		
		$UsuariosController = new UsuariosController();
		
		$response->getBody()->write(json_encode($UsuariosController->CambiarPassword($id, $newPassword)));
	}
	catch (Exception $e)
	{
		Throw new Exception("Error encontrado: $e->getMessage()");
	}
	
	return $response->withStatus(200)->withHeader('Content-type', 'application/json');
});

