<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'layout/head.php' ?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php include 'layout/navbar.php' ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include 'layout/sidebar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Translation Set</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Translation Set</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <?php
                include("../database/connection.php");

                if(isset($_POST['submit'])) {
                    $word = $_POST['word'];
                    $translation = $_POST['translation'] ?? "";
                    $description = $_POST['description'] ?? "";

                    $file_name      = $_FILES["pronunciation_file"]["name"];
                    $file_size      = $_FILES["pronunciation_file"]["size"];
                    $target_dir     = "../uploads/";
                    $target_file    = strtolower($target_dir . basename($file_name));
                    $upload_ok      = 1;
                    $img_file_type  = pathinfo($target_file, PATHINFO_EXTENSION);
                    $temp_file_name = $_FILES["pronunciation_file"]["tmp_name"];

                    if($word == "") {
                        $_SESSION['error'] = "Word field cannot be empty";
                        unset($_POST);
                    } else if($translation == "") {
                        $_SESSION['error'] = "Translation field cannot be empty";
                        unset($_POST);
                    } else if(!file_exists($_FILES['pronunciation_file']['tmp_name']) || !is_uploaded_file($_FILES['pronunciation_file']['tmp_name'])) {
                        $_SESSION['error'] = "Pronunciation file cannot be empty";
                        unset($_POST);
                    } else {
                        $filename = slugify($word) . "_" . round(microtime(true))
                            . "." . $img_file_type;
                        $date = date('Y-m-d H:i:s');
                        if(move_uploaded_file($temp_file_name, $target_dir . $filename)) {
                            $query = "INSERT INTO translation( word, word_pronunciation, translation, translation_pronunciation, descriptions, created_at, updated_at)
                          VALUES('$word','$filename','$translation',null,'$description', '$date','$date')";
                            mysqli_query($mysqli, $query)
                        or die("Could not execute the insert query $date. " . mysqli_error($mysqli) . " $query");

                            $_SESSION['success'] = "Registration successfully";
                        } else {
                            $_SESSION['error'] = "Some Error occurred";
                            unset($_POST);
                        }
                    }
                }

                if (isset($_SESSION['error'])) {
                    echo showError($_SESSION['error']);
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    echo showSuccess($_SESSION['success']);
                    unset($_SESSION['success']);
                }
                ?>                <div class="row">
                    <div class="col-md-4">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Translation Set</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" enctype="multipart/form-data" action="index.php">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="word">Word</label>
                                        <input type="text" class="form-control" id="word" name="word" placeholder="Enter word">
                                    </div>
                                    <div class="form-group">
                                        <label for="pronunciation_file">Word Pronunciation File</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="pronunciation_file" name="pronunciation_file" accept="audio/*">
                                                <label class="custom-file-label" for="pronunciation_file">Choose file</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="translation">Translation</label>
                                        <input type="text" class="form-control" id="translation" name="translation" placeholder="Enter Translation">
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->



                    </div>
                    <div class="col-md-8">
                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Translations</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <?php

                                $result = mysqli_query($mysqli, "SELECT * FROM translation ORDER BY id DESC");


                                ?>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>English Word</th>
                                        <th>Translation</th>
                                        <th>Pronunciation</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php


                                    while ($res = mysqli_fetch_array($result)) {

                                        echo "<tr>";
                                        echo "<td>".$res['word']."</td>";
                                        echo "<td>".$res['translation']."</td>";
                                        echo "<td><audio controls>
                                              <source src=\"". route( "uploads/" . $res['word_pronunciation']) . "\" type=\"audio/mp3\">
                                              
                                            Your browser does not support the audio element.
                                            </audio></td>";
                                        echo "<td> <a href=\"translation_set/delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";

                                    }
                                    ?>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>English Word</th>
                                        <th>Translation</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'layout/footer.php' ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include 'layout/scripts.php' ?>
<!-- Page specific script -->
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
        });

    });
</script>
</body>
</html>
