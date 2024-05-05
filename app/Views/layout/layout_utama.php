<!doctype html>
<html>

<head>
  <title>CodeIgniter Tutorial</title>
</head>

<body>
  <h1><?= esc($title) ?></h1>
  <?= $this->include('komponen/sidebar') ?>
  <?= $this->renderSection('content') ?>
  <footer style="background-color: burlywood;">
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo rerum hic eius eaque exercitationem itaque quod fuga eveniet. Illo eveniet praesentium at quae doloribus eos numquam dolor saepe maiores sequi.</p>
  </footer>
</body>

</html>