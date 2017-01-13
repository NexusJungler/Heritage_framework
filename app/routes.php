<?php

use Aston\Factory\EntityManagerFactory;
use Aston\Core\ServiceContainer;
use Aston\Entity\BookEntity;
use Aston\Entity\AuthorEntity;
use Slim\Csrf\Guard;
use Respect\Validation\Validator as v;

$router->add('/', 'GET', function () {

    $twig = ServiceContainer::getInstance()->get('twig');
    return $twig->render('home.html.twig');
});

$router->add('/book/list', 'GET', function () {

    $twig = ServiceContainer::getInstance()->get('twig');
    $manager = EntityManagerFactory::get('BookEntity');
    $books = $manager->getLastEntities(0, 10);
    $entities = [];
    if ($books) {
        foreach ($books as $book) {
            $entities[] = BookEntity::create($book);
        }
    }
    return $twig->render('book_list.html.twig', ['books' => $entities]);
});

$router->add('/book/add', 'GET', function () {

    $c = ServiceContainer::getInstance();
    // Generate tokens
    $slimGuard = $c->get('csrf');
    $slimGuard->validateStorage();
    $csrfNameKey = $slimGuard->getTokenNameKey();
    $csrfValueKey = $slimGuard->getTokenValueKey();
    $keyPair = $slimGuard->generateToken();

    $token = [
        'name' => $csrfNameKey,
        'value' => $csrfValueKey,
        'keypair' => $keyPair
    ];

    //\Kint::dump($token);
    /* LARAVEL
    $c->get('capsule');
    $authors = \Aston\Entity\author::all();
    $genres = \Aston\Entity\genre::all();
    */
    $twig = $c->get('twig');
    return $twig->render('book_form.html.twig', ['token' => $token]);
});

$router->add('/author/add', 'GET', function () {

    $twig = ServiceContainer::getInstance()->get('twig');
    return $twig->render('author_form.html.twig');
});

$router->add('/admin/log', 'GET', function () {

    $twig = ServiceContainer::getInstance()->get('twig');
    $log_file = '../log/aston.log';

    $logs = null;
    if (file_exists($log_file)) {
        $content = file_get_contents($log_file);
        $data = explode('[] []', $content);
        $logs = [];

        foreach ($data as $line) {
            $line = trim($line);
            if ($line) {

                $elements = explode(' ', $line);
                $elements[3] = str_replace('+', ' ', $elements[3]);
                $logs[] = $elements;
            }
        }

    }
    return $twig->render('log_admin.html.twig', ['logs' => $logs]);
});

$router->add('/book/delete/{n:id}', 'GET', function ($id) {

    $twig = ServiceContainer::getInstance()->get('twig');
    return $twig->render('confirm.html.twig', ['id' => $id]);
});

$router->post('/book/post/add', function () {

    // validation du formulaire
    $numValidator = v::intVal()->between(1, 200);
    $stringValidator = v::alpha()->length(1, 100);

    foreach ($_POST as $field => $value) {
        if (is_string($value)) {
            if (!$stringValidator->validate($value)) {
                header('Location: /book/add');
            }
        }
        if (is_numeric($value)) {
            if (!$numValidator->validate($value)) {
                header('Location: /book/add');
            }
        }
    }

    $title = $_POST['title'];
    if (!v::alpha()->length(1, 50)->validate($title)) {
        header('Location: /book/add');
    }

    $slimGuard = new Guard;
    $slimGuard->validateStorage();
    $slimGuard->validateToken($_POST['csrf_name'], $_POST['csrf_value']);

    if(key_exists($_POST['csrf_name'], $_SESSION['csrf'])) {
        if($_SESSION['csrf'][$_POST['csrf_name']] != $_POST['csrf_value']) {
            header('Location: /', true, 302);
        }
    } else {
        header('Location: /', true, 302);
    }
    $entity = BookEntity::create($_POST);
    $entity->save();
    /* Laravel
       Il faut changer le nom des champs du formulaire pour genre_id et author_id pour que çà fonctionne!
       book::create($_POST);


    */
    header('Location: /book/add');
});

$router->add('/book/add', 'GET', function () {

    $twig = ServiceContainer::getInstance()->get('twig');
    return $twig->render('book_form.html.twig');
});

$router->post('/author/post/add', function () {
    $entity = AuthorEntity::create($_POST);
    $entity->save();
    header('Location: /author/add');
});

$router->post('/book/delete/confirm', function () {
    $entity = BookEntity::load($_POST['id']);
    $entity->delete();
    header('Location: /book/list');
});

// $router->add('/docs/{*:url}', 'GET', function($url) {
// 	return $url;
// });
//
// $router->add('/hello/{a:firstname}/{?:lastname}', 'GET', function($firstname, $lastname = '') {
// 	return 'hello '.$firstname.' '.$lastname;
// });
//
// $router->add('/user/{a:id}/edit', 'GET|POST', 'App\Controllers\UserController::show');