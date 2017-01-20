<?php

  class Model_Main extends Model
  {

    public function get_posts()
    {
      $mysqli = $this->init_mysql_connection();

      $sql = 'SELECT * FROM `posts` ORDER BY `posts`.`date` DESC';

      if (!$result = $mysqli->query($sql)) {
        $this->MysqlQueryError($mysqli);
      } else {

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

    public function get_tags()
    {
      $mysqli = $this->init_mysql_connection();

      $sql = 'SELECT * FROM `tags`';

      if (!$result = $mysqli->query($sql)) {
        $this->MysqlQueryError($mysqli);
      }

      $tagsArr =  array();

      while ($row = $result->fetch_assoc()) {
        $tagsArr[$row['id']] = array('name' => $row['name'],);
      }

      $posts_and_tags = array();

      foreach ($tagsArr as $key => $value) {

        $id_tag = $key;
        $posts_and_tags[$id_tag] = array('name' => $value['name'],
          'posts' => array());

          $sql = "SELECT * FROM `posts_and_tags` WHERE `tag` = '$id_tag'";

          if (!$result = $mysqli->query($sql)) {
            $this->MysqlQueryError($mysqli);
          }

          if ($result->num_rows === 0) {
            $posts_and_tags[$id_tag]['posts'][] = 0;
          } else {

            while ($row = $result->fetch_assoc()) {
              $posts_and_tags[$id_tag]['posts'][] = $row['post'];
            }

          }
      }

      $mysqli->close();

      /*избавляется от дублей, чтобы получить точное количество постов под
      определенным тегом*/
      foreach ($posts_and_tags as $key => $value) {
        $posts_and_tags[$key]['posts'] = array_count_values($posts_and_tags[$key]['posts']);
        $posts_and_tags[$key]['length'] = count($posts_and_tags[$key]['posts']);
      }

      /*сортирует массив по убыванию*/
      usort($posts_and_tags, function($a,$b){
          return ($b['length']-$a['length']);
      });

      $str = '<ul class="list-group">';

      foreach ($posts_and_tags as $key => $value) {
        $str .= ' <a href="#" class="list-group-item">
                    <span class="badge">'.$posts_and_tags[$key]['length'].
                    '</span>'.$posts_and_tags[$key]['name'].'
                  </a>';
      }

      $str .= '</ul>';

      return $str;
    }

  }
?>
