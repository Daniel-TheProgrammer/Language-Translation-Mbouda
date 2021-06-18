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
                        <h1>Quiz</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Quiz</li>
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
                    $question = $_POST['question'];
                    $active = $_POST['active'] ?? true;
                    
                    $is_correct_1 = isset($_POST['is_correct_1']) ? 1 : 0;
                    $is_correct_2 = isset($_POST['is_correct_2']) ? 1 : 0;
                    $is_correct_3 = isset($_POST['is_correct_3']) ? 1 : 0;
                    $is_correct_4 = isset($_POST['is_correct_4']) ? 1 : 0;

                    // fixme dot slugify
                    $option_1      = $_FILES["option_1"]["name"];
                    $target_dir_1     = "../uploads/";
                    $target_file_1    = strtolower($target_dir_1 . (basename($option_1)));
                    $upload_ok_1      = 1;
                    $img_file_type_1  = pathinfo($target_file_1, PATHINFO_EXTENSION);
                    $temp_file_name_1 = $_FILES["option_1"]["tmp_name"];

                    $option_2      = $_FILES["option_2"]["name"];
                    $target_dir_2     = "../uploads/";
                    $target_file_2    = strtolower($target_dir_2 . (basename($option_2)));
                    $upload_ok_2      = 1;
                    $img_file_type_2  = pathinfo($target_file_2, PATHINFO_EXTENSION);
                    $temp_file_name_2 = $_FILES["option_2"]["tmp_name"];

                    $option_3      = $_FILES["option_3"]["name"];
                    $target_dir_3     = "../uploads/";
                    $target_file_3    = strtolower($target_dir_3 . (basename($option_3)));
                    $upload_ok_3      = 1;
                    $img_file_type_3  = pathinfo($target_file_3, PATHINFO_EXTENSION);
                    $temp_file_name_3 = $_FILES["option_3"]["tmp_name"];

                    $option_4      = $_FILES["option_4"]["name"];
                    $target_dir_4     = "../uploads/";
                    $target_file_4    = strtolower($target_dir_4 . (basename($option_4)));
                    $upload_ok_4      = 1;
                    $img_file_type_4  = pathinfo($target_file_4, PATHINFO_EXTENSION);
                    $temp_file_name_4 = $_FILES["option_4"]["tmp_name"];

                    if($question == "") {
                        $_SESSION['error'] = "Question field cannot be empty";
                        unset($_POST);
                    } else if(!file_exists($temp_file_name_1) || !is_uploaded_file($temp_file_name_1)) {
                        $_SESSION['error'] = "Option (A) file cannot be empty";
                        unset($_POST);
                    } else if(!file_exists($temp_file_name_2) || !is_uploaded_file($temp_file_name_2)) {
                        $_SESSION['error'] = "Option (B) file cannot be empty";
                        unset($_POST);
                    } else if(!file_exists($temp_file_name_3) || !is_uploaded_file($temp_file_name_3)) {
                        $_SESSION['error'] = "Option (C) file cannot be empty";
                        unset($_POST);
                    } else if(!file_exists($temp_file_name_4) || !is_uploaded_file($temp_file_name_4)) {
                        $_SESSION['error'] = "Option (D) file cannot be empty";
                        unset($_POST);
                    } else {

                        $date = date('Y-m-d H:i:s');

                        // Insert question
                        $question_query = "INSERT INTO questions(question, active, created_at, updated_at)
                         VALUES('$question',1, '$date', '$date')";
                        mysqli_query($mysqli, $question_query) or die("Error: ". mysqli_error($mysqli));
                        $question_id = mysqli_insert_id($mysqli);


                        $file_1 = slugify($option_1) . "." . $img_file_type_1;
                        if(move_uploaded_file($temp_file_name_1, $target_dir_1 . $file_1)) {
                            $query = "INSERT INTO options(`id`, `question_id`, `option`, `is_correct`, `created_at`, `updated_at`)
                          VALUES(null,$question_id,'" . $file_1 ."',$is_correct_1, '$date','$date')";
                            mysqli_query($mysqli, $query)
                        or die("Could not execute the insert query $date. " . mysqli_error($mysqli) . " $query");

                            $_SESSION['success'] = "Registration successfully";
                        } else {
                            $_SESSION['error'] = "Some Error occurred";
                            unset($_POST);
                        }

                        $file_2 = slugify($option_2) . "." . $img_file_type_2;
                        if(move_uploaded_file($temp_file_name_2, $target_dir_2 . $file_2)) {
                            $query = "INSERT INTO options(`id`, `question_id`, `option`, `is_correct`, `created_at`, `updated_at`)
                          VALUES(null,$question_id,'$file_2',$is_correct_2, '$date','$date')";
                            mysqli_query($mysqli, $query)
                        or die("Could not execute the insert query $date. " . mysqli_error($mysqli) . " $query");

                            $_SESSION['success'] = "Registration successfully";
                        } else {
                            $_SESSION['error'] = "Some Error occurred";
                            unset($_POST);
                        }


                        $file_3 = slugify($option_3) . "." . $img_file_type_3;
                        if(move_uploaded_file($temp_file_name_3, $target_dir_3 . $file_3)) {
                            $query = "INSERT INTO options(`id`, `question_id`, `option`, `is_correct`, `created_at`, `updated_at`)
                          VALUES(null,$question_id,'$file_3',$is_correct_3, '$date','$date')";
                            mysqli_query($mysqli, $query)
                        or die("Could not execute the insert query $date. " . mysqli_error($mysqli) . " $query");

                            $_SESSION['success'] = "Registration successfully";
                        } else {
                            $_SESSION['error'] = "Some Error occurred";
                            unset($_POST);
                        }


                        $file_4 = slugify($option_4) . "." . $img_file_type_4;
                        if(move_uploaded_file($temp_file_name_4, $target_dir_4 . $file_4)) {
                            $query = "INSERT INTO options(`id`, `question_id`, `option`, `is_correct`, `created_at`, `updated_at`)
                          VALUES(null,$question_id,'$file_4',$is_correct_4, '$date','$date')";
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
                ?>
                <div class="row">
                    <div class="col-md-4">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Quiz</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" enctype="multipart/form-data" action="quiz.php">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="question">Question</label>
                                        <input type="text" class="form-control" id="question" name="question" placeholder="Enter Question">
                                    </div>
                                    <div class="form-group">
                                        <label for="is_correct_1">Option (A)</label>
                                        <input type="checkbox" id="is_correct_1" value="1" name="is_correct_1">
                                        <label for="option_1">Is Correct</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="option_1" name="option_1" accept="audio/*">
                                                <label class="custom-file-label" for="option_1">Choose file</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_correct_2">Option (B)</label>
                                        <input type="checkbox" id="is_correct_2" value="1" name="is_correct_2">
                                        <label for="option_2">Is Correct</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="option_2" name="option_2" accept="audio/*">
                                                <label class="custom-file-label" for="option_2">Choose file</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_correct_3">Option (C)</label>
                                        <input type="checkbox" id="is_correct_3" value="1" name="is_correct_3">
                                        <label for="option_3">Is Correct</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="option_3" name="option_3" accept="audio/*">
                                                <label class="custom-file-label" for="option_3">Choose file</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_correct_4">Option (D)</label>
                                        <input type="checkbox" id="is_correct_4" value="1" name="is_correct_4">
                                        <label for="option_4">Is Correct</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="option_4" name="option_4" accept="audio/*">
                                                <label class="custom-file-label" for="option_4">Choose file</label>
                                            </div>

                                        </div>
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

                                $result = mysqli_query($mysqli, "SELECT * FROM questions ORDER BY id DESC");


                                ?>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Question</th>
                                        <th>Is Active</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php


                                    while ($res = mysqli_fetch_array($result)) {

                                        echo "<tr>";
                                        echo "<td>".$res['question']."</td>";
                                        echo "<td>".($res['active'] == 1 ? "ACTIVE" : "INACTIVE") ."</td>";
                                        echo "<td> <a href=\"translation_set/delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";

                                    }
                                    ?>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Question</th>
                                        <th>Is Active</th>
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
