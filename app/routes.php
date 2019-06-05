<?php

// Home
$app->get(
    '/',
    function($request, $response)
    {
        $viewData = [];

        return $this->view->render($response, 'pages/home.twig', $viewData);
    }
)->setName('home');

// about
$app->get(
    '/about',
    function($request, $response)
    {

        $viewData = [];

        return $this->view->render($response, 'pages/about.twig', $viewData);
    }
)->setName('about');



// contact
$app->get(
    '/contact',
    function($request, $response)
    {

        $viewData = [];

        return $this->view->render($response, 'pages/contact.twig', $viewData);
    }
)->setName('contact');


// projects
$app->get(
    '/projects',
    function($request, $response)
    {
        // Fetch projects
        $query = $this->db->query('SELECT * FROM projects');
        $projects = $query->fetchAll();

        $viewData = [];
        $viewData['projects'] = $projects;

        return $this->view->render($response, 'pages/projects.twig', $viewData);
    }
)->setName('projects');

// each projects
$app->get(
    '/projects_{id:[0-9]}',
    function($request, $response, $arguments)
    {
        // Fetch project
        $prepare = $this->db->prepare(
            'SELECT * FROM projects WHERE id = :id LIMIT 1'
        );
        $prepare->bindValue('id', $arguments['id']);
        $prepare->execute();
        $project = $prepare->fetch();

        if(!$project)
        {
            throw new \Slim\Exception\NotFoundException($request, $response);
        };

        $viewData = [];
        $viewData['projects'] = $project;
        return $this->view->render($response, 'pages/project.twig', $viewData);
    }
)->setName('project');