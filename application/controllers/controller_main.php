<?php
  /**
   *
   */
  class Controller_Main extends Controller
  {

    function __construct()
    {
      $this->model = new Model_Main();
      $this->view = new View();
    }

/*    function action_index()
    {
      $data = $this->model->get_data();
      $this->view->generate('add_view.php', 'template_view.php', $data);
    }
*/
    public function action_index()
    {
      $data = array();
      $data['posts'] = $this->model->get_posts();
      $data['tags'] = $this->model->get_tags();
      $this->view->generate('posts_view.php', 'template_view.php', $data);
    }
  }

?>
