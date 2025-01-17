<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />

  <title>Upload documents</title>
</head>

<body>
  <div class="container">
    <h1>Upload documents here</h1>
    <div class="form">
      <form action="./insert.php" method="post" enctype="multipart/form-data">
        <div class="drop-area-container">
          <label for="uploader" class="drop_area">
            drop file here or click to upload
          </label>
          <div class="preview"></div>
        </div>
        <div class="input">
          <input type="file" style="display: none" id="uploader" name="file" accept=".pdf" />
        </div>
        <button type="submit" name="submit_btn" class="submit">Upload</button>
      </form>
    </div>
    <?php
    include "./config.php";

    $sql = "SELECT * FROM file order by id desc";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
    ?>
      <div class="files">
        <?php
        while ($row = $res->fetch_assoc()) {
        ?>
          <div class="file">
            <div class="thumb">
              <div class="img">
                <img src="./images/pdf-logo.jpg" alt="PDF">
              </div>
            </div>
            <div class="desc">
              <a href="./uploads/<?= $row["file_name"] ?>"><?= $row["file_name"] ?></a>
              &nbsp;
              <a href="./uploads/<?= $row["file_name"] ?>" download>Download</a>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    <?php }
    ?>
  </div>
  <script src="./script.js"></script>
</body>

</html>