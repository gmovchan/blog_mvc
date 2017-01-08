<?php
  /**
   *
   */
  class Model_Main extends Model
  {

    public function get_posts()
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

      $sql = 'SELECT * FROM `posts` ORDER BY `posts`.`date` DESC';



      if (!$result = $mysqli->query($sql)) {
        echo 'Ошибка выполнения запроса \n"';
        echo "Номер_ошибки: " . $mysqli->errno . "<br>";
        echo "Ошибка: " . $mysqli->error . "<br>";
        $mysqli->close();
      } else {
//        echo "QUERY SUCCESS!";
      }

      $html = '';

      while ($post = $result->fetch_assoc()) {
        $html = $html.'
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="panel-title">'.$post['header'].'
            </span><span class="pull-right text-muted">'.$post['date'].'</span>
          </div>
          <div class="panel-body">
            '.$post['text'].'
          </div>
          <div class="panel-footer">
            <a href="#">Комментировать</a>
            <span class="pull-right">
              <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true">10</span>
              <span class="glyphicon glyphicon glyphicon-thumbs-down" aria-hidden="true">0</span>
            </span>
          </div>
        </div>
        ';
      }

      $mysqli->close();

      return $html;
    }
  }

?>
