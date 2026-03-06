<?php include_once 'header.php'; ?>
<?php require '../helpers/init_conn_db.php'; ?>

<?php
if(isset($_POST['del_flight']) and isset($_SESSION['adminId'])) {
  $flight_id = $_POST['flight_id'];
  $sql = 'DELETE FROM Flight WHERE flight_id=?';
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)) {
      header('Location: ../index.php?error=sqlerror');
      exit();            
  } else {  
    mysqli_stmt_bind_param($stmt,'i',$flight_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    echo("<script>location.href = 'all_flights.php';</script>");
    exit();
  }
}
?>

<?php if(isset($_SESSION['adminId'])) { ?>
<main>
  <div class="container-fluid px-4 mt-5 mb-5">
    <div class="admin-glass-panel animate-fade-in shadow-sm border-0">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="admin-header-title mb-0"><i class="fa fa-list-alt mr-2 text-secondary"></i>ALL FLIGHTS</h2>
        <a href="flight.php" class="btn btn-admin-premium btn-sm px-4 rounded-pill"><i class="fa fa-plus mr-2"></i>New Flight</a>
      </div>
      <hr class="mb-4">

      <div class="table-responsive">
        <table class="table mb-0 custom-table text-center table-hover align-middle">
          <thead>
            <tr>
              <th scope="col" class="rounded-left">Flight ID</th>
              <th scope="col">Airline</th>
              <th scope="col">Departure</th>
              <th scope="col">Arrival</th>
              <th scope="col">Origin &rarr; Destination</th>
              <th scope="col">Available Seats</th>
              <th scope="col">Price</th>
              <th scope="col" class="rounded-right">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = 'SELECT * FROM Flight ORDER BY flight_id DESC';
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt,$sql);                
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if(mysqli_num_rows($result) == 0) {
                echo '<tr><td colspan="8" class="text-center py-5 text-muted">No flights found in the system.</td></tr>';
            }

            while ($row = mysqli_fetch_assoc($result)) {
              echo "
              <tr>                  
                <td class='font-weight-bold text-primary'>
                  <a href='pass_list.php?flight_id=".htmlspecialchars($row['flight_id'])."'>#".htmlspecialchars($row['flight_id'])."</a>
                </td>
                <td class='font-weight-bold'>".htmlspecialchars($row['airline'])."</td>
                <td>
                  <div class='font-weight-bold'>".date('H:i', strtotime($row['departure']))."</div>
                  <div class='small text-muted'>".date('d M Y', strtotime($row['departure']))."</div>
                </td>
                <td>
                  <div class='font-weight-bold'>".date('H:i', strtotime($row['arrivale']))."</div>
                  <div class='small text-muted'>".date('d M Y', strtotime($row['arrivale']))."</div>
                </td>
                <td><span class='badge badge-light px-3 py-2 border'>".htmlspecialchars($row['source'])." &rarr; ".htmlspecialchars($row['Destination'])."</span></td>
                <td><span class='badge badge-info px-3 py-2'>".htmlspecialchars($row['Seats'])."</span></td>
                <td class='font-weight-bold text-success'>$".number_format($row['Price'], 2)."</td>
                <td>
                  <form action='all_flights.php' method='post' class='m-0' onsubmit='return confirm(\"Are you sure you want to delete this flight?\");'>
                    <input name='flight_id' type='hidden' value='".htmlspecialchars($row['flight_id'])."'>
                    <button class='btn btn-danger btn-sm rounded-pill px-3 shadow-sm' type='submit' name='del_flight'>
                    <i class='fa fa-trash'></i> Delete</button>
                  </form>
                </td>                  
              </tr>
              ";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<?php } ?>

<?php include_once 'footer.php'; ?>
