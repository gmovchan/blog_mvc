<?php
  /*
    Особый смысл в создание интерфейса и трейта не вкладывал, сделал просто потому
    что могу
  */

  interface MysqlConnect {
    public function get_config($name);
    public function init_mysql_connection();
    public function MysqlQueryError($mysqli);
  }

  trait MysqlConnectTrate {
    public function get_config($name)
    {
      switch ($name) {
        case 'mysql':
          return parse_ini_file("application/configs/config.ini");
          break;

        default:
          # code...
          break;
      }
    }

    public function init_mysql_connection()
    {
      $db_login = $this->get_config('mysql');

      $mysqli = new mysqli($db_login['host'], $db_login['user'],
      $db_login['password'], $db_login['db']);

      if ($mysqli->connect_errno) {
      echo 'Ошибка соединения с БД \n"';
      echo "Номер_ошибки: " . $mysqli->errno . "<br>";
      echo "Ошибка: " . $mysqli->error . "<br>";
      $mysqli->close();
      }

      /*принудительно установил кодировку UTF-8 потому что иначе MYSQL не понимала
      со словами на русском языке*/
      if (!$mysqli->set_charset("utf8")) {
      /*printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);*/
      $mysqli->close();
      } else {
      /*printf("Текущий набор символов: %s\n", $mysqli->character_set_name());*/
      }

      return $mysqli;
    }

    /*потребовалось вынести вывод ошибки mysql в отдельную функцию потому что
    он повторяется во многих местах*/
    public function MysqlQueryError($mysqli)
    {
      echo 'Ошибка выполнения запроса \n"';
      echo "Номер_ошибки: " . $mysqli->errno . "<br>";
      echo "Ошибка: " . $mysqli->error . "<br>";
      $mysqli->close();
    }

  }


  class Model implements MysqlConnect
  {
    use MysqlConnectTrate;

    function get_data()
    {
      # code...
    }

  }

?>
