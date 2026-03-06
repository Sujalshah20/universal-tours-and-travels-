<?php include_once 'header.php'; 
require '../helpers/init_conn_db.php';?>

<?php if(isset($_SESSION['adminId'])) { ?>
<main>
  <div class="container mt-5 mb-5 px-4">
    <div class="row justify-content-center">
      <div class="col-md-11">
        <div class="admin-glass-panel animate-fade-in shadow-sm border-0">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="admin-header-title mb-0"><i class="fa fa-users mr-2 text-secondary"></i>PASSENGER LIST</h2>
            <a href="all_flights.php" class="btn btn-outline-secondary btn-sm px-4 rounded-pill"><i class="fa fa-arrow-left mr-2"></i>Back to Flights</a>
          </div>
          <p class="text-muted font-weight-bold">Listing passengers for Flight ID: <span class="badge badge-primary px-2 py-1">#<?php echo htmlspecialchars($_GET['flight_id']); ?></span></p>
          <hr class="mb-4">

          <div class="table-responsive">
            <table class="table mb-0 custom-table text-center table-hover align-middle">
              <thead>
                <tr>
                  <th scope="col" class="rounded-left">S.No</th>
                  <th scope="col" class="text-left">Passenger Name</th>
                  <th scope="col">Contact</th>
                  <th scope="col">D.O.B</th>
                  <th scope="col">Paid By (Account)</th>
                  <th scope="col" class="rounded-right">Amount Paid</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $cnt=1;
                $flight_id = $_GET['flight_id'];
                $stmt_t = mysqli_stmt_init($conn);
                $sql_t = 'SELECT * FROM Ticket WHERE flight_id=?';
                if(!mysqli_stmt_prepare($stmt_t,$sql_t)) {
                    header('Location: ticket.php?error=sqlerror');
                    exit();            
                } else {
                    mysqli_stmt_bind_param($stmt_t,'i',$flight_id);            
                    mysqli_stmt_execute($stmt_t);
                    $result_t = mysqli_stmt_get_result($stmt_t);
                    
                    if(mysqli_num_rows($result_t) == 0) {
                         echo '<tr><td colspan="6" class="text-center py-5 text-muted">No passengers booked on this flight yet.</td></tr>';
                    }

                    while($row_t = mysqli_fetch_assoc($result_t)) {                  
                      $sql = 'SELECT * FROM Passenger_profile WHERE passenger_id=?';  
                      $stmt = mysqli_stmt_init($conn);
                      mysqli_stmt_prepare($stmt,$sql);  
                      mysqli_stmt_bind_param($stmt,'i',$row_t['passenger_id']);          
                      mysqli_stmt_execute($stmt);
                      $result = mysqli_stmt_get_result($stmt);                
                      
                      if ($row = mysqli_fetch_assoc($result)) {
                          $sql_p = 'SELECT * FROM PAYMENT WHERE flight_id=? AND user_id=?';  
                          $stmt_p = mysqli_stmt_init($conn);
                          mysqli_stmt_prepare($stmt_p,$sql_p);  
                          mysqli_stmt_bind_param($stmt_p,'ii',$flight_id,$row['user_id']);          
                          mysqli_stmt_execute($stmt_p);
                          $result_p = mysqli_stmt_get_result($stmt_p);                
                          
                          if ($row_p = mysqli_fetch_assoc($result_p)) {
                            $sql_u = 'SELECT * FROM Users WHERE user_id=?';  
                            $stmt_u = mysqli_stmt_init($conn);
                            mysqli_stmt_prepare($stmt_u,$sql_u);  
                            mysqli_stmt_bind_param($stmt_u,'i',$row['user_id']);          
                            mysqli_stmt_execute($stmt_u);
                            $result_u = mysqli_stmt_get_result($stmt_u);                
                            
                            if ($row_u = mysqli_fetch_assoc($result_u)) {
                              echo "                  
                              <tr>
                                <td class='font-weight-bold text-muted'>".$cnt."</td>
                                <td class='text-left font-weight-bold'>
                                    <div class='d-flex align-items-center'>
                                        <i class='fa fa-user-circle text-secondary fa-lg mr-2'></i>
                                        ".$row['f_name']." ".$row['m_name']." ".$row['l_name']."
                                    </div>
                                </td>
                                <td>".$row['mobile']."</td>
                                <td>".date('d M Y', strtotime($row['dob']))."</td>
                                <td scope='row'><span class='badge badge-light px-3 py-2 border'>".$row_u['username']."</span></td>
                                <td class='font-weight-bold text-success'>$".number_format($row_p['amount'], 2)."</td>
                              </tr>
                              "; 
                            }                       
                          }                    
                      }
                      $cnt++; 
                    }
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
