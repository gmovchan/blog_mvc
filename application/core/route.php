<?php
  /**
   *
   */
  class Route
  {
    static function start()
    {
      $controller_name = 'Main';
      $action_name = 'index';

      $routes = explode('/', $_SERVER['REQUEST_URI']);

      /*сдвинул индекс массива на 1, потому что проект находится
      в папке, которая отображается в адресной строке */
      if (!empty($routes[2])) {
        $controller_name = $routes[2];
      }

      if (!empty($routes[3])) {
        $action_name = $routes[3];
      }

      $model_name = 'Model_'.$controller_name;
      $controller_name = 'Controller_'.$controller_name;
      $action_name = 'action_'.$action_name;

      $model_file = strtolower($model_name).'.php';
      $model_path = 'application/models/'.$model_file;

      if (file_exists($model_path)) {
        include 'application/models/'.$model_file;
      }

      $controller_file = strtolower($controller_name).'.php';
      $controller_path = 'application/controllers/'.$controller_file;

//      echo $controller_path;

      if (file_exists($controller_path)) {
//        echo $controller_file;
        include 'application/controllers/'.$controller_file;
      } else {
        Route::ErrorPage404();
      }

      /*я пока не понимаю что делает код далее и до конца функции
      Если с директивой new используется строка (string), содержащая имя класса,
      то будет создан новый экземпляр этого класса.*/
      $controller = new $controller_name;
      $action = $action_name;

      if (method_exists($controller, $action)) {
        $controller -> $action();
      } else {
        Route::ErrorPage404;
      }
    }

    function ErrorPage404()
    {
      $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
      header('HTTP/1.1 404 Not Found');
      header('Status: 404 Not Found');
      header('Location:'.$host.'404');
    }

  }

?>
