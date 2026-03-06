<?php include_once 'header.php'; 
require '../helpers/init_conn_db.php';?>

<?php
if(isset($_POST['del_airlines']) and isset($_SESSION['adminId'])) {
  $airline_id = $_POST['airline_id'];
  $sql = 'DELETE FROM airline WHERE airline_id=?';
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)) {
      header('Location: ../index.php?error=sqlerror');
      exit();            
  } else {  
    mysqli_stmt_bind_param($stmt,'i',$airline_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    echo("<script>location.href = 'list_airlines.php';</script>");
    exit();
  }
}
?>

<?php if(isset($_SESSION['adminId'])) { ?>
<main>
  <div class="container mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="admin-glass-panel animate-fade-in shadow-sm border-0">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="admin-header-title mb-0"><i class="fa fa-building-o mr-2 text-secondary"></i>AIRLINES LIST</h2>
            <button class="btn btn-admin-premium btn-sm px-4 rounded-pill" onclick="$('.admin-dropdown-menu form').toggle();"><i class="fa fa-plus mr-2"></i>New Airline</button>
          </div>
          <hr class="mb-4">

          <div class="table-responsive">
            <table class="table mb-0 custom-table text-center table-hover align-middle">
              <thead>
                <tr>
                  <th scope="col" class="rounded-left">S.No</th>
                  <th scope="col" class="text-left">Airline Name</th>
                  <th scope="col">Total Seats</th>
                  <th scope="col" class="rounded-right">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $cnt=1;
                $sql = 'SELECT * FROM airline ORDER BY airline_id ASC';
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);                
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if(mysqli_num_rows($result) == 0) {
                    echo '<tr><td colspan="4" class="text-center py-5 text-muted">No airlines found. Click "New Airline" to add one.</td></tr>';
                }

                while ($row = mysqli_fetch_assoc($result)) {
                  echo "
                  <tr>                  
                    <td class='font-weight-bold text-muted'>".$cnt."</td>
                    <td class='text-left font-weight-bold'>
                        <div class='d-flex align-items-center'>
                            <div class='bg-light rounded-circle p-2 mr-3 text-secondary'>
                                <i class='fa fa-plane'></i>
                            </div>
                            ".htmlspecialchars($row['name'])."
                        </div>
                    </td>
                    <td><span class='badge badge-info px-3 py-2'>".htmlspecialchars($row['seats'])." Seats</span></td>
                    <td>
                      <form action='list_airlines.php' method='post' class='m-0' onsubmit='return confirm(\"Delete this airline? This action cannot be undone.\");'>
                        <input name='airline_id' type='hidden' value='".htmlspecialchars($row['airline_id'])."'>
                        <button class='btn btn-danger btn-sm rounded-pill px-3 shadow-sm' type='submit' name='del_airlines'>
                            <i class='fa fa-trash'></i> Delete
                        </button>
                      </form>
                    </td>                  
                  </tr>
                  ";
                  $cnt++; 
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php } ?>

<?php include_once 'footer.php'; ?>
