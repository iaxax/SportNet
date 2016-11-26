<?php
// Routes

//home page
$app->get('/[{name}]', function ($request, $response, $args) {
    return $this->renderer->render($response, 'login.html', $args);
});

require_once "controller/AccountController.php";

//Account Handler
$app->post('/controller/AccountController',
    function (\Slim\Http\Request $request, $response, $args) {
        $name = $request->getParam('name');
        $pw = $request->getParam('pw');
        $ctrl = new AccountController();
        $result = $ctrl->login(new LoginVO($name, $pw));

        return $result->getMessage();
});

