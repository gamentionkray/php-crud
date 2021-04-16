<?php
session_start();
include("includes/functions.php");

$sql = "SELECT * FROM pc_students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Student CRUD</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="assets/css/style.css" />
  <script src="assets/js/main.js"></script>
</head>

<body>
  <div class="container-div">
    <div class="form-div">
      <form action="index.php" method="POST">
        <div class="kt-header">
          <h4 class="kt-title"><?= $_SESSION["button"] === "add" ? "Add" : "Update" ?> Student</h4>
        </div>
        <div class="kt-body">
          <div class="form-module">
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" class="form-control" value="<?= $_SESSION["button"] === "add" ? "" : $_SESSION["name"] ?>" required />
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="text" name="phone" class="form-control" value="<?= $_SESSION["button"] === "add" ? "" : $_SESSION["phone"] ?>" required />
            </div>
          </div>
          <div class="form-module">
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="<?= $_SESSION["button"] === "add" ? "" : $_SESSION["email"] ?>" required />
            </div>
            <div class="form-group">
              <label>Address</label>
              <input type="text" name="address" class="form-control" value="<?= $_SESSION["button"] === "add" ? "" : $_SESSION["address"] ?>" required />
            </div>
          </div>
        </div>
        <div class="kt-footer">
          <input type="submit" name="<?= $_SESSION["button"] === "add" ? "add" : "update" ?>" class="btn btn-success" value="<?= $_SESSION["button"] === "add" ? "Add" : "Update" ?>" />
        </div>
        <!-- Error Box -->
        <div class="error-box" style="display: <?php echo (!empty($errors)) ? "block" : "none"; ?>">
          <?php
          if (!empty($errors)) {
            foreach ($errors as $key => $value) {
              echo $value . "<br>";
            }
          } else {
            echo "";
          }
          ?>
        </div>
        <!-- Success Box -->
        <div class="success-box" style="display: <?php echo (!empty($success)) ? "block" : "none"; ?>">
          <?php
          if (!empty($success)) {
            foreach ($success as $key => $value) {
              echo $value . "<br>";
            }
          } else {
            echo "";
          }
          ?>
        </div>
      </form>
    </div>
  </div>

  <div class="container-xl">
    <div class="table-responsive">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-12">
              <h2><strong>MCA</strong> Student Details</h2>
            </div>
          </div>
        </div>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Address</th>
              <th>Phone</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            //Displaying a user
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["student_name"] . "</td>";
                echo "<td>" . $row["student_email"] . "</td>";
                echo "<td>" . $row["student_address"] . "</td>";
                echo "<td>" . $row["student_phone"] . "</td>"; ?>
                <td>
                  <a href='index.php?update_id=<?php echo $row['student_id']; ?>'><i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i></a>
                  <a href='index.php?delete_id=<?php echo $row['student_id']; ?>'><i class='material-icons' data-toggle='tooltip' title='Delete'>&#xE872;</i></a>
                </td>
            <?php echo "</tr>";
              }
            } else {
              echo "<tr>";
              echo "<td>NA</td>";
              echo "<td>NA</td>";
              echo "<td>NA</td>";
              echo "<td>NA</td>";
              echo "<td>NA</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>