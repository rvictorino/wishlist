<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Wishlist</title>
  </head>
  <body>
    <?php
      require_once('controller/WishController.php');
      $wc = new WishController();
      $array = $wc->list();
    ?>
    <ul>
      <?php foreach($array as $value): ?>
      <li>
          <?php echo $value->getTitle(); ?>
      </li>
      <?php endforeach; ?>
    </ul>
  </body>
</html>
