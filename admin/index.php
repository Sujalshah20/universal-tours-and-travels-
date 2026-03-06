<?php include_once 'header.php'; 
require '../helpers/init_conn_db.php';?>

<?php if(isset($_SESSION['adminId'])) { ?>
<main>
  <div class="container mt-4 pb-5">

    <!-- Dashboard Cards -->
    <div class="row mb-5">
      <div class="col-md-3 mb-4 mb-md-0">
        <div class="admin-glass-panel text-center h-100 animate-fade-in text-white" style="background: linear-gradient(135deg, #1e293b, #0f172a);">
          <div class="mb-3">
            <i class="fa fa-users fa-3x" style="color: var(--accent-color);"></i>
          </div>
          <h6 class="font-weight-bold text-uppercase" style="letter-spacing: 1px; color: #cbd5e1;">Total Passengers</h6>
          <?php
            $sql = "SELECT COUNT(*) as count FROM passenger_profile";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            echo '<h2 class="mb-0 font-weight-bold mt-2">'.$row['count'].'</h2>';
          ?>
        </div>
      </div>
      
      <div class="col-md-3 mb-4 mb-md-0">
        <div class="admin-glass-panel text-center h-100 animate-fade-in text-white" style="background: linear-gradient(135deg, #047857, #064e3b);">
          <div class="mb-3">
            <i class="fa fa-money fa-3x" style="color: #34d399;"></i>
          </div>
          <h6 class="font-weight-bold text-uppercase" style="letter-spacing: 1px; color: #d1fae5;">Total Revenue</h6>
          <?php
            $sql = "SELECT SUM(cost) as total FROM ticket";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            echo '<h2 class="mb-0 font-weight-bold mt-2">$'.($row['total'] ?? 0).'</h2>';
          ?>
        </div>
      </div>
      
      <div class="col-md-3 mb-4 mb-md-0">
        <div class="admin-glass-panel text-center h-100 animate-fade-in text-white" style="background: linear-gradient(135deg, #be123c, #881337);">
          <div class="mb-3">
            <i class="fa fa-plane fa-3x" style="color: #fda4af;"></i>
          </div>
          <h6 class="font-weight-bold text-uppercase" style="letter-spacing: 1px; color: #ffe4e6;">Total Flights</h6>
          <?php
            $sql = "SELECT COUNT(*) as count FROM flight";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            echo '<h2 class="mb-0 font-weight-bold mt-2">'.$row['count'].'</h2>';
          ?>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="admin-glass-panel text-center h-100 animate-fade-in text-white" style="background: linear-gradient(135deg, #1d4ed8, #1e3a8a);">
          <div class="mb-3">
            <i class="fa fa-building fa-3x" style="color: #93c5fd;"></i>
          </div>
          <h6 class="font-weight-bold text-uppercase" style="letter-spacing: 1px; color: #dbeafe;">Listed Airlines</h6>
          <?php
            $sql = "SELECT COUNT(*) as count FROM airline";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            echo '<h2 class="mb-0 font-weight-bold mt-2">'.$row['count'].'</h2>';
          ?>
        </div>
      </div>
    </div>

    <!-- Quick Navigation Filters -->
    <div class="d-flex justify-content-center mb-4">
      <div class="btn-group" role="group">
        <a href="#flight" class="btn btn-outline-secondary font-weight-bold text-uppercase">Today's Flights</a>
        <a href="#issue" class="btn btn-outline-danger font-weight-bold text-uppercase">Issues</a>
        <a href="#dep" class="btn btn-outline-info font-weight-bold text-uppercase">Departed</a>
        <a href="#arr" class="btn btn-outline-success font-weight-bold text-uppercase">Arrived</a>
      </div>
    </div>

    <?php $curr_date = date('Y-m-d'); ?>

    <!-- Today's Flights Section -->
    <div class="card border-0 shadow-sm mb-5" style="border-radius: 1rem; overflow: hidden;" id="flight">
      <div class="card-header bg-white py-3 border-0">
        <h5 class="mb-0 font-weight-bold" style="color: var(--primary-color);"><i class="fa fa-calendar-day mr-2 text-secondary"></i>Scheduled Today</h5>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table mb-0 custom-table text-center table-hover">
            <thead>
              <tr>
                <th>Flight ID</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Origin -> Dest</th>
                <th>Airline</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>              
              <?php
                $sql = "SELECT * FROM Flight WHERE DATE(departure)=?";
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,'s',$curr_date);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if(mysqli_num_rows($result) == 0) {
                    echo '<tr><td colspan="6" class="text-center py-4">No flights scheduled for today.</td></tr>';
                }
                
                while ($row = mysqli_fetch_assoc($result)) {
                  if($row['status']== '') {
                    echo '
                <tr>     
                  <td class="font-weight-bold text-primary">
                    <a href="pass_list.php?flight_id='.$row['flight_id'].'">#'.$row['flight_id'].'</a>
                  </td>
                  <td>'.date('H:i', strtotime($row['departure'])).'</td>
                  <td>'.date('H:i', strtotime($row['arrivale'])).'</td>
                  <td><span class="badge badge-light px-2 py-1">'.$row['source'].' -> '.$row['Destination'].'</span></td>
                  <td class="font-weight-bold">'.$row['airline'].'</td> 
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-light btn-sm px-3 dropdown-toggle" type="button" data-toggle="dropdown">
                        Manage
                      </button>  
                      <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius: 1rem;">
                        <form class="px-3 py-2" action="../includes/admin/admin.inc.php" method="post">
                          <input type="hidden" name="flight_id" value="'.$row['flight_id'].'">
                          <div class="form-group mb-2">
                            <label class="small text-muted font-weight-bold">Delay (minutes)</label>
                            <input type="number" class="form-control form-control-sm" name="issue" placeholder="e.g. 120" required>
                          </div>  
                          <button type="submit" name="issue_but" class="btn btn-danger btn-sm btn-block mb-2">Report Delay</button>
                          <hr class="my-2">
                          <button type="submit" name="dep_but" class="btn btn-info btn-sm btn-block">Mark as Departed</button>
                        </form>
                      </div>
                    </div>  
                  </td>                
                </tr>' ; 
                  }
                } 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Flight Issues Section -->
    <div class="card border-0 shadow-sm mb-5" style="border-radius: 1rem; overflow: hidden;" id="issue">
      <div class="card-header bg-white py-3 border-0">
        <h5 class="mb-0 font-weight-bold text-danger"><i class="fa fa-exclamation-triangle mr-2 text-danger"></i>Delayed / Issues</h5>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table mb-0 custom-table text-center table-hover">
            <thead>
              <tr>
                <th>Flight ID</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Origin -> Dest</th>
                <th>Airline</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = "SELECT * FROM Flight WHERE DATE(departure)=? AND status='issue'";
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,'s',$curr_date);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if(mysqli_num_rows($result) == 0) {
                    echo '<tr><td colspan="6" class="text-center py-4 text-success"><i class="fa fa-check-circle mr-2"></i>No delayed flights.</td></tr>';
                }
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo ' 
                <tr class="table-danger">             
                  <td class="font-weight-bold text-danger">#'.$row['flight_id'].'</td>
                  <td>'.date('H:i', strtotime($row['departure'])).'</td>
                  <td>'.date('H:i', strtotime($row['arrivale'])).'</td>
                  <td><span class="badge badge-light px-2 py-1">'.$row['source'].' -> '.$row['Destination'].'</span></td>
                  <td class="font-weight-bold">'.$row['airline'].'</td> 
                  <td>
                    <form action="../includes/admin/admin.inc.php" method="post" class="m-0">
                      <input type="hidden" name="flight_id" value="'.$row['flight_id'].'">  
                      <button type="submit" name="issue_soved_but" class="btn btn-success btn-sm px-3 rounded-pill">
                        <i class="fa fa-check mr-1"></i> Resolve
                      </button>
                    </form>
                  </td>                
                </tr>' ; 
                } 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div> 

    <div class="row">
      <!-- Departed Flights Section -->
      <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; overflow: hidden;" id="dep">
          <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 font-weight-bold text-info"><i class="fa fa-plane-departure mr-2"></i>Departed</h5>
          </div>
          <div class="card-body p-0">
            <table class="table mb-0 custom-table text-center table-hover">
              <thead class="bg-info text-white">
                <tr>
                  <th>Flight ID</th>
                  <th>Origin -> Dest</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql = "SELECT * FROM Flight WHERE DATE(departure)=? AND status='dep'";
                  $stmt = mysqli_stmt_init($conn);
                  mysqli_stmt_prepare($stmt,$sql);
                  mysqli_stmt_bind_param($stmt,'s',$curr_date);
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                  
                  if(mysqli_num_rows($result) == 0) {
                      echo '<tr><td colspan="3" class="text-center py-4">No departed flights recorded today.</td></tr>';
                  }
                  
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo '       
                  <tr>       
                    <td class="font-weight-bold text-info">#'.$row['flight_id'].'</td>
                    <td class="small">'.$row['source'].' &rarr; '.$row['Destination'].'</td>
                    <td>
                        <form action="../includes/admin/admin.inc.php" method="post" class="m-0">
                          <input type="hidden" name="flight_id" value="'.$row['flight_id'].'">  
                          <button type="submit" name="arr_but" class="btn btn-success btn-sm px-3 rounded-pill">Mark Arrived</button>
                        </form>
                    </td>                
                  </tr>' ; 
                  } 
                ?>
              </tbody>
            </table>
          </div>
        </div>       
      </div>

      <!-- Arrived Flights Section -->
      <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; overflow: hidden;" id="arr">
          <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 font-weight-bold text-success"><i class="fa fa-plane-arrival mr-2"></i>Arrived</h5>
          </div>
          <div class="card-body p-0">
            <table class="table mb-0 custom-table text-center table-hover">
              <thead class="bg-success text-white">
                <tr>
                  <th>Flight ID</th>
                  <th>Origin -> Dest</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql = "SELECT * FROM Flight WHERE DATE(departure)=? AND status='arr'";
                  $stmt = mysqli_stmt_init($conn);
                  mysqli_stmt_prepare($stmt,$sql);
                  mysqli_stmt_bind_param($stmt,'s',$curr_date);
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                  
                  if(mysqli_num_rows($result) == 0) {
                      echo '<tr><td colspan="3" class="text-center py-4">No arrived flights recorded today.</td></tr>';
                  }
                  
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo '   
                  <tr>           
                    <td class="font-weight-bold text-success">#'.$row['flight_id'].'</td>
                    <td class="small">'.$row['source'].' &rarr; '.$row['Destination'].'</td>
                    <td><i class="fa fa-check-circle text-success" title="Successfully Arrived"></i></td>                
                  </tr>' ; 
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
