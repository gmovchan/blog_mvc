<?php
  class Model_Posts extends Model
  {
    public function add_post()
    {
      $header = $_POST['header'];
      $text = $_POST['text'];
      $tags = $_POST['tags'];

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

      $id_post = $mysqli->insert_id;

      /*теги поступают в виде строки и разделены запятыми*/
      if (isset($tags)) {


        $tagsArr = explode(',', $tags);

        $id_tags_arr = array();

        /*цикл получает строку с тегами, разделяет ее, ищет совпадение в БД,
        добавляет новые и в таблицу posts_and_tags присваивает новому посту id
        тегов*/

        foreach ($tagsArr as $tag) {


          $tag = trim($tag);
          if (!empty($tag)) {


            $tag = mb_strtolower($tag);

            $sql = "SELECT `id` FROM `tags` WHERE `name` = '$tag'";

            var_dump($sql);

            if (!$result = $mysqli->query($sql)) {
              echo 'Ошибка выполнения запроса \n"';
              echo "Номер_ошибки: " . $mysqli->errno . "<br>";
              echo "Ошибка: " . $mysqli->error . "<br>";
              $mysqli->close();
            }

            if ($result->num_rows === 0) {

              $stmt = $mysqli->prepare("INSERT INTO tags (`name`) VALUES (?)");
              $stmt->bind_param('s', $tag);

              if (!$stmt->execute()) {
                echo 'Ошибка выполнения запроса \n"';
                echo "Номер_ошибки: " . $mysqli->errno . "<br>";
                echo "Ошибка: " . $mysqli->error . "<br>";
                $mysqli->close();
              } else {
                echo "QUERY SUCCESS!";
              }

              $id_tags_arr[] = $mysqli->insert_id;


            } else {
              while ($id_tag = $result->fetch_assoc()) {
                $id_tags_arr[] = $id_tag;
              }
            }

          }
        }

        var_dump($id_tags_arr);
        /*сразу пребразовать массив $id_tags_arr в строку не получилось, потому
        что он имеет слудующую структуру
        array (size=12)
        0 =>
          array (size=1)
            'id' => string '1' (length=1)
        1 =>
          array (size=1)
            'id' => string '8' (length=1)
        поэтому сначала потребовалось собрать его в массив проще*/

        $tagsArr = array();

        foreach ($id_tags_arr as $key => $value) {
          $tagsArr[] = $value['id'];
        }

        $id_tags_str = implode(",", $tagsArr);

        $sql = "INSERT INTO posts_and_tags (`post`, `tags`) VALUES ('$id_post', '$id_tags_str')";

        if (!$result = $mysqli->query($sql)) {
          echo 'Ошибка выполнения запроса \n"';
          echo "Номер_ошибки: " . $mysqli->errno . "<br>";
          echo "Ошибка: " . $mysqli->error . "<br>";
          $mysqli->close();
        }

      }

      $stmt->close();

      $mysqli->close();
    }

  }
?>
