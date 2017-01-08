<form class="" action="/posts/add" method="post">
  <div class="form-group">
    <label for="header">Заголовок</label>
    <input type="text" name="header" value="" class="form-control">
  </div>
  <div class="form-group">
    <label for="text">Текст поста</label>
    <textarea  name="text" value="" class="form-control" rows="20"></textarea>
  </div>
  <div class="form-group">
    <label for="tags">Теги</label>
    <input type="text" name="tags" value="" class="form-control">
    <span class="help-block">Перечислйте через запятую</span>
  </div>
  <button type="submit" name="button" class="btn btn-default">Сохранить</button>
</form>
