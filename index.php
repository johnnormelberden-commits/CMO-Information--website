<?php
// ============================================================
// CMO INFORMATION WEBSITE
// RAILWAY MYSQL DATABASE CONNECTION
// ============================================================

// ------------------------------------------------------------
// Read Railway environment variables
// ------------------------------------------------------------

function get_env_value($name)
{
    // Try getenv()
    $value = getenv($name);

    if ($value !== false && trim($value) !== '') {
        return trim($value);
    }

    // Try $_ENV
    if (isset($_ENV[$name]) && trim($_ENV[$name]) !== '') {
        return trim($_ENV[$name]);
    }

    // Try $_SERVER
    if (isset($_SERVER[$name]) && trim($_SERVER[$name]) !== '') {
        return trim($_SERVER[$name]);
    }

    return '';
}


// ------------------------------------------------------------
// Get MySQL variables
// ------------------------------------------------------------

$dbHost     = get_env_value('MYSQLHOST');
$dbPort     = get_env_value('MYSQLPORT');
$dbUser     = get_env_value('MYSQLUSER');
$dbPassword = get_env_value('MYSQLPASSWORD');
$dbName     = get_env_value('MYSQLDATABASE');


// ------------------------------------------------------------
// Support MYSQL_DATABASE as alternative database name
// ------------------------------------------------------------

if ($dbName === '') {
    $dbName = get_env_value('MYSQL_DATABASE');
}


// ------------------------------------------------------------
// Default port
// ------------------------------------------------------------

if ($dbPort === '') {
    $dbPort = '3306';
}


// ------------------------------------------------------------
// Check missing variables
// ------------------------------------------------------------

$missingVariables = array();

if ($dbHost === '') {
    $missingVariables[] = 'MYSQLHOST';
}

if ($dbUser === '') {
    $missingVariables[] = 'MYSQLUSER';
}

if ($dbPassword === '') {
    $missingVariables[] = 'MYSQLPASSWORD';
}

if ($dbName === '') {
    $missingVariables[] = 'MYSQLDATABASE or MYSQL_DATABASE';
}


// ============================================================
// DATABASE CONFIGURATION ERROR
// ============================================================

if (!empty($missingVariables)) {

    die('
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Database Configuration Error</title>

    <style>

        body {
            margin: 0;
            padding: 40px;

            background: #0d1117;

            color: #ffffff;

            font-family: Arial, sans-serif;
        }

        .error-box {
            max-width: 850px;

            margin: 40px auto;

            padding: 35px;

            background: #161b22;

            border: 1px solid #30363d;

            border-radius: 15px;

            box-shadow:
                0 10px 30px
                rgba(0,0,0,0.5);
        }

        h1 {
            color: #ff6b6b;
        }

        li {
            color: #ffd700;
            margin-bottom: 8px;
        }

        .info {
            color: #58a6ff;
        }

    </style>

</head>

<body>

<div class="error-box">

    <h1>
        Database configuration is missing
    </h1>

    <p>
        The PHP application cannot see the following
        Railway environment variable(s):
    </p>

    <ul>
        ' .

        implode(
            '',
            array_map(
                function ($variable) {

                    return '<li>' .
                           htmlspecialchars($variable) .
                           '</li>';

                },
                $missingVariables
            )
        )

        . '

    </ul>

    <p>
        Make sure these variables are available to the
        <strong>CMO INFORMATION WEBSITE</strong>
        PHP/Web service.
    </p>

    <p class="info">
        Expected variables:
    </p>

    <ul>

        <li>MYSQLHOST</li>
        <li>MYSQLPORT</li>
        <li>MYSQLUSER</li>
        <li>MYSQLPASSWORD</li>
        <li>MYSQLDATABASE</li>

    </ul>

    <p class="info">
        After changing Railway Variables, redeploy or
        restart the PHP service.
    </p>

</div>

</body>

</html>
');

}


// ============================================================
// CONNECT TO MYSQL
// ============================================================

mysqli_report(MYSQLI_REPORT_OFF);

$connection = new mysqli(
    $dbHost,
    $dbUser,
    $dbPassword,
    $dbName,
    (int)$dbPort
);


// ============================================================
// CHECK MYSQL CONNECTION
// ============================================================

if ($connection->connect_error) {

    die('
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Database Connection Error</title>

    <style>

        body {
            background: #0d1117;
            color: #ffffff;
            padding: 40px;
            font-family: Arial, sans-serif;
        }

        .error-box {
            max-width: 850px;
            margin: 40px auto;
            padding: 35px;
            background: #161b22;
            border: 1px solid #30363d;
            border-radius: 15px;
        }

        h1 {
            color: #ff6b6b;
        }

        .error {
            color: #ffd700;
        }

    </style>

</head>

<body>

<div class="error-box">

    <h1>
        Database connection failed
    </h1>

    <p>
        MySQL returned:
    </p>

    <p class="error">
        ' .
        htmlspecialchars($connection->connect_error) .
        '
    </p>

    <p>
        Check your Railway MySQL variables and make sure
        the CMO INFORMATION WEBSITE is connected to the
        MySQL service.
    </p>

</div>

</body>

</html>
');

}


// ============================================================
// UTF-8
// ============================================================

$connection->set_charset('utf8mb4');


// ============================================================
// GET PERSONNEL RECORDS
// ============================================================

$sql = "SELECT * FROM military_personnel";

$result = $connection->query($sql);


// ============================================================
// CHECK QUERY
// ============================================================

if (!$result) {

    die('
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Database Query Error</title>

    <style>

        body {
            background: #0d1117;
            color: #ffffff;
            padding: 40px;
            font-family: Arial, sans-serif;
        }

        .error-box {
            max-width: 850px;
            margin: 40px auto;
            padding: 35px;
            background: #161b22;
            border: 1px solid #30363d;
            border-radius: 15px;
        }

        h1 {
            color: #ff6b6b;
        }

        .error {
            color: #ffd700;
        }

    </style>

</head>

<body>

<div class="error-box">

    <h1>
        Database query failed
    </h1>

    <p class="error">
        ' .
        htmlspecialchars($connection->error) .
        '
    </p>

    <p>
        Make sure the table
        <strong>military_personnel</strong>
        exists in your Railway MySQL database.
    </p>

</div>

</body>

</html>
');

}

?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Philippine Air Force - Personnel System
    </title>


    <!-- =====================================================
         BOOTSTRAP
    ====================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    >


    <!-- =====================================================
         DATATABLES
    ====================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css"
    >


    <!-- =====================================================
         DATATABLES BUTTONS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css"
    >


    <style>

        body {

            background:
                linear-gradient(
                    135deg,
                    #0d1117,
                    #1b2838
                );

            color: #e0e0e0;

            font-family:
                'Poppins',
                sans-serif;

            min-height: 100vh;

            margin: 0;
        }


        /* =====================================================
           PAF HEADER
        ====================================================== */

        .paf-topbar {

            width: 100%;

            padding: 15px 40px;

            background:
                rgba(0,40,90,0.45);

            backdrop-filter:
                blur(12px);

            border-bottom:
                2px solid #ffd700;

            display: flex;

            align-items: center;

            justify-content:
                space-between;

            box-shadow:
                0 5px 20px
                rgba(0,0,0,0.6);
        }


        .paf-brand {

            display: flex;

            align-items: center;

            gap: 15px;
        }


        .paf-brand img {

            height: 70px;

            width: 70px;

            object-fit: contain;

            transition: 0.4s;
        }


        .paf-brand img:hover {

            transform:
                scale(1.15)
                rotate(5deg);

            filter:
                drop-shadow(
                    0 0 12px #00b4d8
                );
        }


        .paf-text h1 {

            margin: 0;

            font-size: 1.5rem;

            font-weight: 700;

            color: #ffffff;

            letter-spacing: 1px;

            text-transform:
                uppercase;
        }


        .paf-text span {

            font-size: 0.9rem;

            color: #ffd700;
        }


        .logout-btn {

            font-size: 0.9rem;

            padding: 6px 14px;

            border-radius: 20px;
        }


        .export-menu-btn {

            font-size: 18px;

            padding: 6px 10px;

            border-radius: 50%;

            line-height: 1;
        }


        /* =====================================================
           MAIN CONTAINER
        ====================================================== */

        .container-main {

            background:
                rgba(255,255,255,0.05);

            border-radius: 15px;

            padding: 40px;

            box-shadow:
                0 8px 32px
                rgba(0,0,0,0.3);

            margin-top: 40px;
        }


        h2 {

            color: #58a6ff;

            font-weight: 600;

            margin-bottom: 25px;
        }


        .btn-primary {

            background:
                linear-gradient(
                    90deg,
                    #007bff,
                    #00b4d8
                );

            border: none;

            transition: 0.3s;
        }


        .btn-primary:hover {

            opacity: 0.9;
        }


        /* =====================================================
           TABLE
        ====================================================== */

        .table {

            color: #e0e0e0;

            background-color:
                rgba(255,255,255,0.05);

            border-radius: 10px;

            overflow: hidden;
        }


        .table th {

            background-color:
                rgba(0,123,255,0.2);

            color: #58a6ff;

            text-transform:
                uppercase;
        }


        .table td,
        .table th {

            text-align: center;

            vertical-align: middle;
        }


        .no-wrap {

            white-space: nowrap;

            min-width: 180px;
        }


        .dt-buttons {

            display: none !important;
        }


        .dataTables_length {

            float: left;

            margin-bottom: 20px;
        }


        .dataTables_filter {

            float: right;

            text-align: right;
        }


        .dataTables_wrapper
        .row:nth-child(1) {

            display: flex;

            justify-content:
                space-between;

            align-items: center;
        }

    </style>

</head>


<body>


<!-- =========================================================
     PAF HEADER
========================================================= -->

<div class="paf-topbar">


    <div class="paf-brand">


        <img
            src="cmo1.png"
            alt="Philippine Air Force Logo"
        >


        <div class="paf-text">

            <h1>
                CMO Training Squadron
            </h1>

            <span>
                Student Database Information System
            </span>

        </div>


    </div>


    <div
        class="d-flex align-items-center gap-2">


        <!-- EXPORT MENU -->

        <div class="dropdown">


            <button
                class="btn btn-outline-info btn-sm export-menu-btn"
                type="button"
                id="exportMenuBtn"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                &#9776;

            </button>


            <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="exportMenuBtn">


                <li>

                    <a
                        class="dropdown-item"
                        href="#"
                        id="exportExcel">

                        Export to Excel

                    </a>

                </li>


                <li>

                    <a
                        class="dropdown-item"
                        href="#"
                        id="exportPDF">

                        Export to PDF

                    </a>

                </li>


                <li>

                    <a
                        class="dropdown-item"
                        href="#"
                        id="exportPrint">

                        Print Table

                    </a>

                </li>


            </ul>

        </div>


        <!-- CHANGE PASSWORD -->

        <a
            href="/airforceinfo/change_password.php"
            class="btn btn-outline-warning btn-sm">

            Change Password

        </a>


        <!-- LOGOUT -->

        <a
            href="/airforceinfo/logout.php"
            class="btn btn-outline-light btn-sm logout-btn">

            Logout

        </a>


    </div>


</div>



<!-- =========================================================
     MAIN
========================================================= -->

<div class="container container-main">


    <!-- SUCCESS MESSAGE -->

    <?php if (isset($_GET['deleted'])): ?>

        <div class="alert alert-success">

            ✅ Record deleted successfully.

        </div>

    <?php endif; ?>


    <h2>
        Military Personnel Information
    </h2>


    <a
        class="btn btn-primary mb-3"
        href="/airforceinfo/create.php">

        Add New Military Personnel Information

    </a>


    <!-- =====================================================
         TABLE
    ====================================================== -->

    <div class="table-responsive">


        <table
            id="personnelTable"
            class="table table-hover table-striped">


            <thead>

                <tr>

                    <th>ID</th>

                    <th>Rank</th>

                    <th>Name</th>

                    <th>Serial Number</th>

                    <th>Branch of Service</th>

                    <th>Courses</th>

                    <th>Year Graduated</th>

                    <th>Standing</th>

                    <th>Created At</th>

                    <th>Updated At</th>

                    <th>Action</th>

                </tr>

            </thead>


            <!-- =================================================
                 T BODY
            ================================================== -->

            <tbody>


                <?php while ($row = $result->fetch_assoc()): ?>


                    <tr>


                        <td>

                            <?= htmlspecialchars(
                                $row['id']
                            ); ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['rank']
                            ); ?>

                        </td>


                        <td class="no-wrap">

                            <?= htmlspecialchars(
                                $row['name']
                            ); ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['serial_number']
                            ); ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['branch_of_service']
                            ); ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['courses']
                            ); ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['year_graduated']
                            ); ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['standing']
                            ); ?>

                        </td>


                        <td>

                            <?php

                            if (
                                !empty(
                                    $row['created_at']
                                )
                            ) {

                                echo date(
                                    'F d, Y h:i A',
                                    strtotime(
                                        $row['created_at']
                                    )
                                );

                            }

                            ?>

                        </td>


                        <td>

                            <?php

                            if (
                                !empty(
                                    $row['updated_at']
                                )
                            ) {

                                echo date(
                                    'F d, Y h:i A',
                                    strtotime(
                                        $row['updated_at']
                                    )
                                );

                            }

                            ?>

                        </td>


                        <td>


                            <!-- UPDATE -->

                            <a
                                class="btn btn-primary btn-sm"
                                href="/airforceinfo/edit.php?id=<?= urlencode($row['id']); ?>">

                                Update

                            </a>


                            <!-- DELETE -->

                            <button
                                type="button"
                                class="btn btn-danger btn-sm btn-delete"

                                data-id="<?= htmlspecialchars(
                                    $row['id'],
                                    ENT_QUOTES
                                ); ?>"

                                data-name="<?= htmlspecialchars(
                                    $row['name'],
                                    ENT_QUOTES
                                ); ?>">

                                Delete

                            </button>


                        </td>


                    </tr>


                <?php endwhile; ?>


            </tbody>


        </table>


    </div>


</div>



<!-- =========================================================
     DELETE MODAL
========================================================= -->

<div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-hidden="true">


    <div
        class="modal-dialog modal-dialog-centered">


        <div
            class="modal-content"
            style="
                background-color:#0f1724;
                color:#e6edf3;
                border:1px solid #1f3b63;
            ">


            <div class="modal-header">


                <h5 class="modal-title">

                    Confirm Deletion

                </h5>


                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>


            </div>


            <div class="modal-body">


                Are you sure you want to delete this record?


                <br>


                <strong
                    id="deletePersonName"
                    style="color:#ffd700;">
                </strong>


            </div>


            <div class="modal-footer">


                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cancel

                </button>


                <a
                    id="confirmDeleteBtn"
                    class="btn btn-danger">

                    Delete

                </a>


            </div>


        </div>


    </div>


</div>



<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script
    src="https://code.jquery.com/jquery-3.7.1.min.js">
</script>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>


<script
    src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js">
</script>


<script
    src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js">
</script>


<!-- DATATABLE BUTTONS -->

<script
    src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js">
</script>


<script
    src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js">
</script>


<script
    src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js">
</script>


<script
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js">
</script>


<script
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js">
</script>


<script
    src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js">
</script>


<script
    src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js">
</script>



<script>

$(document).ready(function () {


    // ========================================================
    // DATATABLE
    // ========================================================

    var table =
        $('#personnelTable').DataTable({

            order: [[0, 'asc']],

            pageLength: 5,

            lengthMenu:
                [5, 10, 25, 50],

            dom:
                'lBfrtip',


            buttons: [

                {
                    extend:
                        'excelHtml5',

                    title:
                        'Military Personnel Information'
                },


                {
                    extend:
                        'pdfHtml5',

                    title:
                        'Military Personnel Information',

                    orientation:
                        'landscape',

                    pageSize:
                        'A4'
                },


                {
                    extend:
                        'print',

                    title:
                        'Military Personnel Information'
                }

            ]

        });


    // ========================================================
    // EXPORT EXCEL
    // ========================================================

    $('#exportExcel').on(
        'click',
        function (e) {

            e.preventDefault();

            table
                .button(
                    '.buttons-excel'
                )
                .trigger();

        }
    );


    // ========================================================
    // EXPORT PDF
    // ========================================================

    $('#exportPDF').on(
        'click',
        function (e) {

            e.preventDefault();

            table
                .button(
                    '.buttons-pdf'
                )
                .trigger();

        }
    );


    // ========================================================
    // PRINT
    // ========================================================

    $('#exportPrint').on(
        'click',
        function (e) {

            e.preventDefault();

            table
                .button(
                    '.buttons-print'
                )
                .trigger();

        }
    );


    // ========================================================
    // DELETE MODAL
    // ========================================================

    const deleteModalEl =
        document.getElementById(
            'deleteModal'
        );


    const deleteModal =
        new bootstrap.Modal(
            deleteModalEl
        );


    const confirmDeleteBtn =
        document.getElementById(
            'confirmDeleteBtn'
        );


    const deletePersonName =
        document.getElementById(
            'deletePersonName'
        );


    // ========================================================
    // DELETE BUTTON
    // ========================================================

    $('#personnelTable').on(
        'click',
        '.btn-delete',
        function () {


            const id =
                $(this).data('id');


            const name =
                $(this).data('name');


            deletePersonName.textContent =
                name
                    ? 'Personnel: ' + name
                    : '';


            confirmDeleteBtn.href =
                '/airforceinfo/delete.php?id=' +
                encodeURIComponent(id);


            deleteModal.show();

        }
    );


});

</script>


</body>

</html>
