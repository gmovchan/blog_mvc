<?php
  class Model_Posts extends Model
  {
    public function add_post()
    {
      $header = $_POST['header'];
      $text = $_POST['text'];

      $mysqli = $this->init_mysql_connection();

      /*подготавливаемые запросы для защиты от sql инъекций*/

      $stmt = $mysqli->prepare("INSERT INTO posts (`header`, `text`) VALUES (?, ?)");
      $stmt->bind_param('ss', $header, $text);

        if (!$stmt->execute()) {
          echo 'Ошибка выполнения запроса \n"';
          echo "Номер_ошибки: " . $mysqli->errno . "<br>";
          echo "Ошибка: " . $mysqli->error . "<br>";
          $mysqli->close();
        } else {
          echo "QUERY SUCCESS!";
        }

        $stmt->close();

        $mysqli->close();
    }

  }
?>
