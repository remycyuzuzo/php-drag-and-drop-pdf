<?php
include "./config.php";
include "./manage_session.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700" rel="stylesheet" />
  <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css" />

  <title>Upload documents</title>
</head>

<body>
  <?php
  include "./nav.php";
  ?>
  <div class="container mb-3 ">
    <h1 class="my-2">Upload documents here</h1>
    <div class="form">
      <form action="./insert.php" method="post" enctype="multipart/form-data">
        <!-- <div>
          <input type="text" name="file_title" placeholder="Enter the file title" class="text" id="" required>
        </div> -->
        <div class="drop-area-container" style="text-align: center;">
          <label for="uploader" class="drop_area">
            drop file here <br />or click to choose files
          </label>
          <div class="preview"></div>
        </div>
        <div class="input">
          <input type="file" style="display: none" multiple id="uploader" name="file[]" accept=".pdf" />
        </div>
        <input type="hidden" name="form">
        <div class="d-flex justify-content-between align-items-start my-2">
          <button type="submit" name="submit_btn" class="submit" data-submitbtn>Save and Upload</button>
          <button type="button" class="btn btn-warning d-none" data-addmorefiles>Add more files</button>
        </div>
      </form>
    </div>
  </div>

  <?php
  // Select all the files from the database
  try {
    $sql = "SELECT * FROM file order by id desc";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $files = $statement->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  if (count($files) > 0) {
  ?><div class="files-container">
      <div class="files container">
        <div class="d-flex justify-content-between flex-wrap my-2">
          <h1>My files</h1>
          <form action="" method="get" class="d-inline-block m-0">
            <input type="text" class="form-control" placeholder="search files ..." data-search>
          </form>
        </div>
        <?php
        foreach ($files as $file) {
        ?>
          <div class="file align-items-start">
            <div class="thumb">
              <div class="img">
                <img src="./images/pdf-logo.jpg" alt="PDF">
              </div>
            </div>
            <div class="desc">
              <div class="links">
                <div>
                  <a href="./uploads/<?= $file["file_name"] ?>" title="<?= $file['file_name'] ?>" data-pdfpreview="./uploads/<?= $file["file_name"] ?>"><?= ($file["file_title"] != "") ? $file["file_title"] : $file["file_name"] ?></a>
                  <small class="date d-block text-muted">Uploaded on <?= $file["date_uploaded"] ?></small>
                </div>
                <a href="./uploads/<?= $file["file_name"] ?>" download>Download</a>
              </div>
            </div>
            <a href="delete.php?file_id=<?= $file["id"] ?>&action=delete" class="close-btn" title="Delete this file">&times;</a>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  <?php
  }
  ?>
  <div class="pdf-preview hidden">
    <div class="header" style="margin-bottom: 20px;">
      <a href="#" class="close" title="Close" data-closepdfpreview>&times;</a>
    </div>
    <div class="preview-area"></div>
  </div>
  <script src="./script.js"></script>
  <script src="./src/js/filter.js"></script>



</body>

</html>