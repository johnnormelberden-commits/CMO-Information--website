<?php
// ============================================================
// SUCCESS MESSAGE
// ============================================================
if (isset($_GET['deleted'])):
?>
<div class="alert alert-success">
  ✅ Record deleted successfully.
</div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Philippine Air Force - Personnel System</title>

  <!-- Bootstrap + DataTables CSS -->
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

  <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

  <!-- DataTables Buttons CSS -->
  <link rel="stylesheet"
        href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">


  <style>

    body {
      background: linear-gradient(135deg, #0d1117, #1b2838);
      color: #e0e0e0;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      margin: 0;
    }


    /* ============================================================
       PAF HEADER
    ============================================================ */

    .paf-topbar {
      width: 100%;
      padding: 15px 40px;
      background: rgba(0, 40, 90, 0.45);
      backdrop-filter: blur(12px);
      border-bottom: 2px solid #ffd700;

      display: flex;
      align-items: center;
      justify-content: space-between;

      box-shadow: 0 5px 20px rgba(0,0,0,0.6);
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
      transform: scale(1.15) rotate(5deg);
      filter: drop-shadow(0 0 12px #00b4d8);
    }


    .paf-text h1 {
      margin: 0;
      font-size: 1.5rem;
      font-weight: 700;
      color: #ffffff;
      letter-spacing: 1px;
      text-transform: uppercase;
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


    /* ============================================================
       MAIN CONTAINER
    ============================================================ */

    .container-main {
      background: rgba(255, 255, 255, 0.05);
      border-radius: 15px;
      padding: 40px;

      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);

      margin-top: 40px;
    }


    h2 {
      color: #58a6ff;
      font-weight: 600;
      margin-bottom: 25px;
    }


    .btn-primary {
      background: linear-gradient(90deg, #007bff, #00b4d8);
      border: none;
      transition: 0.3s;
    }


    .btn-primary:hover {
      opacity: 0.9;
    }


    /* ============================================================
       TABLE STYLES
    ============================================================ */

    .table {
      color: #e0e0e0;
      background-color: rgba(255, 255, 255, 0.05);
      border-radius: 10px;
      overflow: hidden;
    }


    .table th {
      background-color: rgba(0, 123, 255, 0.2);
      color: #58a6ff;
      text-transform: uppercase;
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


    /* Hide default DataTables buttons */
    .dt-buttons {
      display: none !important;
    }


    /* Show entries LEFT */
    .dataTables_length {
      float: left;
      margin-bottom: 20px;
    }


    /* Search RIGHT */
    .dataTables_filter {
      float: right;
      text-align: right;
    }


    /* Same row */
    .dataTables_wrapper .row:nth-child(1) {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

  </style>

</head>


<body>


<!-- ============================================================
     PHILIPPINE AIR FORCE HEADER
============================================================ -->

<div class="paf-topbar">


  <!-- LEFT SIDE -->
  <div class="paf-brand">

    <img src="cmo1.png"
         alt="Philippine Air Force Logo">

    <div class="paf-text">

      <h1>CMO Training Squadron</h1>

      <span>
        Student Database Information System
      </span>

    </div>

  </div>


  <!-- RIGHT SIDE -->
  <div class="d-flex align-items-center gap-2">


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



<!-- ============================================================
     MAIN CONTENT
============================================================ -->

<div class="container container-main">


  <!-- DELETE SUCCESS -->

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



  <!-- ============================================================
       TABLE
  ============================================================ -->

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



      <!-- ========================================================
           T BODY + DATABASE CONNECTION
      ======================================================== -->

      <tbody>

<?php

// ============================================================
// RAILWAY MYSQL DATABASE CONNECTION
// ============================================================

// Get Railway variables
$dbHost = getenv('MYSQLHOST');
$dbPort = getenv('MYSQLPORT');
$dbUser = getenv('MYSQLUSER');
$dbPassword = getenv('MYSQLPASSWORD');
$dbName = getenv('MYSQLDATABASE');

// Remove accidental spaces
$dbHost = $dbHost !== false ? trim($dbHost) : '';
$dbPort = $dbPort !== false ? trim($dbPort) : '';
$dbUser = $dbUser !== false ? trim($dbUser) : '';
$dbPassword = $dbPassword !== false ? trim($dbPassword) : '';
$dbName = $dbName !== false ? trim($dbName) : '';


// ============================================================
// FALLBACK FOR MYSQL_DATABASE
// ============================================================
//
// You said Railway also has MYSQL_DATABASE.
// If MYSQLDATABASE is empty, use MYSQL_DATABASE.
// ============================================================

if ($dbName === '') {

    $mysqlDatabase = getenv('MYSQL_DATABASE');

    if ($mysqlDatabase !== false) {
        $dbName = trim($mysqlDatabase);
    }
}


// ============================================================
// DEFAULT MYSQL PORT
// ============================================================

if ($dbPort === '') {
    $dbPort = '3306';
}


// ============================================================
// CHECK WHICH VARIABLES ARE MISSING
// ============================================================

$missingVariables = [];

if ($dbHost === '') {
    $missingVariables[] = 'MYSQLHOST';
}

if ($dbPort === '') {
    $missingVariables[] = 'MYSQLPORT';
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
// STOP IF VARIABLES ARE MISSING
// ============================================================

if (!empty($missingVariables)) {

    die(
        '<div style="
            background:#0d1117;
            color:#ffffff;
            padding:30px;
            font-family:Arial,sans-serif;
            min-height:100vh;
        ">
            <h2 style="color:#ff6b6b;">
                Database configuration is missing
            </h2>

            <p>
                The PHP application cannot see the following Railway
                environment variable(s):
            </p>

            <ul style="color:#ffd700;">' .

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

            . '</ul>

            <p>
                Go to your Railway project and make sure these variables
                are available to the <strong>PHP/Web application service</strong>
                that is running index.php.
            </p>

            <p style="color:#58a6ff;">
                After changing Variables, redeploy/restart the PHP service.
            </p>

        </div>'
    );
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
// CHECK CONNECTION
// ============================================================

if ($connection->connect_error) {

    die(
        '<div style="
            background:#0d1117;
            color:#ffffff;
            padding:30px;
            font-family:Arial,sans-serif;
            min-height:100vh;
        ">

            <h2 style="color:#ff6b6b;">
                Database connection failed
            </h2>

            <p>
                MySQL returned:
            </p>

            <p style="color:#ffd700;">
                ' .
                htmlspecialchars($connection->connect_error) .
                '
            </p>

            <p>
                Check the Railway MySQL connection variables,
                especially MYSQLHOST and MYSQLPORT.
            </p>

        </div>'
    );
}


// ============================================================
// UTF-8
// ============================================================

$connection->set_charset("utf8mb4");


// ============================================================
// GET PERSONNEL RECORDS
// ============================================================

$sql = "SELECT * FROM military_personnel";

$result = $connection->query($sql);


// ============================================================
// CHECK QUERY
// ============================================================

if (!$result) {

    die(
        '<div style="
            background:#0d1117;
            color:#ffffff;
            padding:30px;
            font-family:Arial,sans-serif;
            min-height:100vh;
        ">

            <h2 style="color:#ff6b6b;">
                Database query failed
            </h2>

            <p style="color:#ffd700;">
                ' .
                htmlspecialchars($connection->error) .
                '
            </p>

            <p>
                Make sure the table
                <strong>military_personnel</strong>
                exists in your Railway database.
            </p>

        </div>'
    );
}


// ============================================================
// DISPLAY PERSONNEL
// ============================================================

while ($row = $result->fetch_assoc()):

?>

<tr>

  <!-- ID -->

  <td>
    <?= htmlspecialchars($row['id']); ?>
  </td>


  <!-- RANK -->

  <td>
    <?= htmlspecialchars($row['rank']); ?>
  </td>


  <!-- NAME -->

  <td class="no-wrap">
    <?= htmlspecialchars($row['name']); ?>
  </td>


  <!-- SERIAL NUMBER -->

  <td>
    <?= htmlspecialchars($row['serial_number']); ?>
  </td>


  <!-- BRANCH -->

  <td>
    <?= htmlspecialchars($row['branch_of_service']); ?>
  </td>


  <!-- COURSES -->

  <td>
    <?= htmlspecialchars($row['courses']); ?>
  </td>


  <!-- YEAR GRADUATED -->

  <td>
    <?= htmlspecialchars($row['year_graduated']); ?>
  </td>


  <!-- STANDING -->

  <td>
    <?= htmlspecialchars($row['standing']); ?>
  </td>


  <!-- CREATED -->

  <td>

    <?php

    if (!empty($row['created_at'])) {

        echo date(
            'F d, Y h:i A',
            strtotime($row['created_at'])
        );

    }

    ?>

  </td>


  <!-- UPDATED -->

  <td>

    <?php

    if (!empty($row['updated_at'])) {

        echo date(
            'F d, Y h:i A',
            strtotime($row['updated_at'])
        );

    }

    ?>

  </td>


  <!-- ACTION -->

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
      data-id="<?= htmlspecialchars($row['id'], ENT_QUOTES); ?>"
      data-name="<?= htmlspecialchars($row['name'], ENT_QUOTES); ?>">

      Delete

    </button>


  </td>

</tr>


<?php endwhile; ?>


      </tbody>

    </table>

  </div>

</div>



<!-- ============================================================
     DELETE CONFIRMATION MODAL
============================================================ -->

<div
  class="modal fade"
  id="deleteModal"
  tabindex="-1"
  aria-hidden="true">


  <div class="modal-dialog modal-dialog-centered">


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



<!-- ============================================================
     SCRIPTS
============================================================ -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>


<!-- DataTables Buttons -->

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>



<script>

$(document).ready(function () {


  // ==========================================================
  // INITIALIZE DATATABLE
  // ==========================================================

  var table = $('#personnelTable').DataTable({

    order: [[0, 'asc']],

    pageLength: 5,

    lengthMenu: [5, 10, 25, 50],

    dom: 'lBfrtip',


    buttons: [

      {
        extend: 'excelHtml5',
        title: 'Military Personnel Information'
      },


      {
        extend: 'pdfHtml5',
        title: 'Military Personnel Information',
        orientation: 'landscape',
        pageSize: 'A4'
      },


      {
        extend: 'print',
        title: 'Military Personnel Information'
      }

    ]

  });



  // ==========================================================
  // EXPORT EXCEL
  // ==========================================================

  $('#exportExcel').on('click', function (e) {

    e.preventDefault();

    table.button('.buttons-excel').trigger();

  });



  // ==========================================================
  // EXPORT PDF
  // ==========================================================

  $('#exportPDF').on('click', function (e) {

    e.preventDefault();

    table.button('.buttons-pdf').trigger();

  });



  // ==========================================================
  // PRINT
  // ==========================================================

  $('#exportPrint').on('click', function (e) {

    e.preventDefault();

    table.button('.buttons-print').trigger();

  });



  // ==========================================================
  // DELETE MODAL
  // ==========================================================

  const deleteModalEl =
    document.getElementById('deleteModal');


  const deleteModal =
    new bootstrap.Modal(deleteModalEl);


  const confirmDeleteBtn =
    document.getElementById('confirmDeleteBtn');


  const deletePersonName =
    document.getElementById('deletePersonName');



  // ==========================================================
  // DELETE BUTTON
  // ==========================================================

  $('#personnelTable').on(
    'click',
    '.btn-delete',
    function () {


      const id =
        $(this).data('id');


      const name =
        $(this).data('name');


      // Display name

      deletePersonName.textContent =
        name
          ? 'Personnel: ' + name
          : '';


      // Delete URL

      confirmDeleteBtn.href =
        '/airforceinfo/delete.php?id=' + id;


      // Show modal

      deleteModal.show();

    }

  );

});

</script>


</body>
</html>
