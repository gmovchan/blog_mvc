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
        $this->MysqlQueryError($mysqli);
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

            /*неоходимо добавлялся ли уже такой тег и если да, надо получить его
            id*/
            $sql = "SELECT `id` FROM `tags` WHERE `name` = '$tag'";

            var_dump($sql);

            if (!$result = $mysqli->query($sql)) {
              $this->MysqlQueryError($mysqli);
            }

            if ($result->num_rows === 0) {

              var_dump('$result->num_rows === 0');

              $stmt = $mysqli->prepare("INSERT INTO tags (`name`) VALUES (?)");
              $stmt->bind_param('s', $tag);

              if (!$stmt->execute()) {
                echo "Ошибка";
                $this->MysqlQueryError($mysqli);
              } else {
                echo "QUERY SUCCESS!";
              }

              /*приводит к строке чтобы все значения были одного типа*/
              $id_tags_arr[] = array('id' => ''.$mysqli->insert_id.'');

            } else {
              /*возвращает строку*/
              while ($id_tag = $result->fetch_assoc()) {
                $id_tags_arr[] = $id_tag;
              }
            }

          }
        }

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

        var_dump($tagsArr);

        /*избавляется от дублей*/
        $tagsArr = array_count_values($tagsArr);

        var_dump($tagsArr);

        /*
        необходимо было обязательно указать $value, иначе цикл в качестве
        возвращал значение ключа вместо его именя
        */

        foreach ($tagsArr as $key => $value) {
          var_dump($key);
          var_dump($value);
          $sql = "INSERT INTO posts_and_tags (`post`, `tag`) VALUES ('$id_post',
             '$key')";
          var_dump($sql);

          if (!$result = $mysqli->query($sql)) {
            $this->MysqlQueryError($mysqli);
          }
        }
      }

      $stmt->close();
      $mysqli->close();
    }
  }
?>
