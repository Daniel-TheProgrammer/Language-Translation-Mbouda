<?php session_start(); ?>
<?php
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php include '../layout/navbar.php' ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include '../layout/sidebar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit</h1>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <?php
                include("../../database/connection.php");
                include("../../helper.php");

                if (isset($_POST['submit'])) {
                    $word = $_POST['word'];
                    $translation = $_POST['translation'];
                    $description = $_POST['description'] ?? "";
                    if (!file_exists($_FILES['pronunciation_file']['tmp_name']) || !is_uploaded_file($_FILES['pronunciation_file']['tmp_name'])) {
                        $file_name = $_FILES["pronunciation_file"]["name"];
                        $file_size = $_FILES["pronunciation_file"]["size"];
                        $target_dir = "../uploads/";
                        $target_file = strtolower($target_dir . basename($file_name));
                        $upload_ok = 1;
                        $img_file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                        $temp_file_name = $_FILES["pronunciation_file"]["tmp_name"];
                        $filename = slugify($word) . "_" . round(microtime(true))
                            . "." . $img_file_type;
                    }


                    if ($word == "") {
                        $_SESSION['error'] = "Word field cannot be empty";
                        unset($_POST);
                    } else if ($translation == "") {
                        $_SESSION['error'] = "Translation field cannot be empty";
                        unset($_POST);
                    } else if (!file_exists($_FILES['pronunciation_file']['tmp_name']) || !is_uploaded_file($_FILES['pronunciation_file']['tmp_name'])) {
                        $_SESSION['error'] = "Pronunciation file cannot be empty";
                        unset($_POST);
                    } else {

                        $date = date('Y-m-d H:i:s');
                        if (move_uploaded_file($temp_file_name, $target_dir . $filename)) {
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


                //getting id from url
                $id = $_GET['id'];

                //selecting data associated with this particular id
                $result = mysqli_query($mysqli, "SELECT * FROM translation WHERE id=$id");

                while ($res = mysqli_fetch_array($result)) {
                    $word = $res['word'];
                    $translation = $res['translation'];
                    $pronunciation = $res['word_pronunciation'];
                    $description = $res['description'];
                }

                ?>

                <div class="row">
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Translation Set</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" enctype="multipart/form-data" action="edit.php">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="word">Word</label>
                                        <input type="text" class="form-control" id="word" name="word"
                                               placeholder="Enter word" value="<?= $word ?? "" ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="pronunciation_file">Word Pronunciation File : </label>
                                        <?= "<a href='" . route("uploads/" . $pronunciation) . "'>$pronunciation</a>" ?>
                                        <audio controls>
                                            <source src="<?= route("uploads/" . $pronunciation) ?>">
                                        </audio>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="pronunciation_file"
                                                       name="pronunciation_file" accept="audio/*">
                                                <label class="custom-file-label" for="pronunciation_file">Choose
                                                    file</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="translation">Translation</label>
                                        <input type="text" class="form-control" id="translation" name="translation"
                                               placeholder="Enter Translation" value="<?= $translation ?? "" ?>">
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
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include '../layout/footer.php' ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php include '../layout/scripts.php' ?>
<!-- Page specific script -->
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
</body>
</html>
