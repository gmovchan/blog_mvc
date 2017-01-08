<?php
  class Controller_Posts extends Controller {

    function __construct()
    {
      $this->model = new Model_Posts();
      $this->view = new View();
    }

    public function action_add()
    {
      if (!isset($_POST['header'])) {

        $this->view->generate('add_view.php', 'template_view.php');

      } else if (!empty($_POST['header'])){

        $this->model->add_post();
        $this->view->generate('add_successful_view.php', 'template_view.php');

      } else {

        $this->view->generate('add_error_view.php', 'template_view.php');

      }
    }
  }
?>
