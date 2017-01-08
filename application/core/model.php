<?php
  /**
   *
   */
  class Model
  {
    function get_config($name)
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

    function get_data()
    {
      # code...
    }
  }

?>
