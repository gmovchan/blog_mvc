<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Блог</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1>Header</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <a href="/" class="btn btn-default" role="button">
              Блог
          </a>
          <button type="button" name="button" class="btn btn-default">Обо мне</button>
          <button type="button" name="button" class="btn btn-default">Работы</button>
          <span class="pull-right">
            <a href="/posts/add" class="btn btn-default" role="button">
                Добавить пост
            </a>
            <button type="button" class="btn btn-default">
              Войти
            </button>
          </span>
        </div>

      </div>
      <br>
      <div class="row">
        <div class="col-md-8">

        <?php include 'application/views/'.$content_view ?>
        <?php echo $data['posts']; ?>

        </div>
        <div class="col-md-4">
          <h4>Tags</h4>
          <?php echo $data['tags']; ?>
          <h4>Архив</h4>
          <ul class="list-group">
            <li class="list-group-item">
              <span class="badge">10</span>
              Январь
            </li>
            <li class="list-group-item">
              <span class="badge">20</span>
              Февраль
            </li>
          </ul>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
