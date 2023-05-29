<?php

include('config/dbconnection.php');

$select = mysqli_query($con, "SELECT * FROM user");

if (isset($_GET['delete_id'])) {
    $delete_id = base64_decode($_GET['delete_id']);

    $delete = mysqli_query($con, "DELETE  FROM user WHERE `id`='$delete_id'");
    if ($delete) {
        $success = "delete successfully";
        header('refresh:2,url=table.php');
    } else {
        $error = "something went wronge";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data table</title>
    <!-- boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- boostrap -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">



</head>

<body>
    <div class="container">
        <div class="row">
            <h2>DATA TABLE</h2>
            <div>
                <?php if (isset($success)) { ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                <?php } ?>
            </div>
            <div>
                <?php if (isset($error)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>
            </div>
            <table class="table table-success table-striped" id="user">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>PASSWORD</th>
                        <th>CREATE</th>
                        <th>UPDATE</th>
                        <th>ACTION</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data = mysqli_fetch_assoc($select)) { ?>
                        <tr>
                            <td>
                                <?php echo $data['id']; ?>
                            </td>
                            <td>
                                <?php echo $data['name']; ?>
                            </td>
                            <td>
                                <?php echo $data['email']; ?>
                            </td>
                            <td>
                                <?php echo $data['password']; ?>
                            </td>
                            <td>
                                <?php echo $data['create']; ?>
                            </td>
                            <td>
                                <?php echo $data['update']; ?>
                            </td>
                            <td><a href="form.php?update_id=<?php echo base64_encode($data['id']); ?>"><button
                                        class="btn btn-primary"><i class="fa fa-edit"></i></button></a></td>
                            <td><a href="table.php?delete_id=<?php echo base64_encode($data['id']); ?>"><button
                                        class="btn btn-danger"><i class="fa fa-trash"></i></button></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/307f49e560.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script>
        $(document).ready(function () {
            let table = new DataTable('#user', {
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'pdf', 'excel', 'copy'
                ]
            });
        });
    </script>
</body>

</html>