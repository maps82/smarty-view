# Slim Framework Smarty View

This is a Slim Framework view helper built on top of the Smarty templating component. You can use this component to create and render templates in your Slim Framework application.

## Install

Via [Composer](https://getcomposer.org/)

```bash
$ composer require maps82/smarty-view
```

Requires Slim Framework 3.

## Usage

```php
// Create Slim app
$app = new \Slim\App();

// Fetch DI Container
$container = $app->getContainer();

// Register Smarty View helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Smarty('path/to/templates', [
        'compile' => 'path/to/compile',
        'config' => 'path/to/config',
        'cache' => 'path/to/cache',
        'debug' => true
    ]);
    
    // Instantiate and add Slim specific extension
    $view->addExtension(new Slim\Views\SmartyExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

// Define named route
$app->get('/hello/{name}', function ($request, $response, $args) {
    return $this->view->render($response, 'profile.tpl', [
        'name' => $args['name']
    ]);
})->setName('profile');

// Run app
$app->run();
```

## Custom template functions

This component exposes a custom `path_for` function to your Smarty templates. You can use this function to generate complete URLs to any Slim application named route. This is an example Smarty template:

    {extends "layout.tpl"}

    {block name="body"}
    <h1>User List</h1>
    <ul>
        <li><a href="{path_for name="profile" options=["name" => "josh"]}">Josh</a></li>
    </ul>
    {/block}


## Credits

This component is strongly based on the offical slim/twig-view

- [Josh Lockhart](https://github.com/codeguy)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
