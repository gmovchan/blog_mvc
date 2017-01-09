<?php
  /**
   *
   */
  class Model_Main extends Model
  {

    public function get_posts()
    {
      $mysqli = $this->init_mysql_connection();

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
