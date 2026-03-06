<?php include_once 'header.php'; ?>
<?php require '../helpers/init_conn_db.php'; ?>

<?php if(isset($_SESSION['adminId'])) { ?>

<main>
<div class="container mt-5">
  <div class="row justify-content-center">
    <?php
    if(isset($_GET['error'])) {
        $msg = '';
        if($_GET['error'] === 'destless') $msg = 'Departure time cannot be after arrival time.';
        else if($_GET['error'] === 'sqlerr') $msg = 'Database error occurred.';
        else if($_GET['error'] === 'same') $msg = 'Source and destination cities cannot be the same.';
        
        if($msg) {
            echo '<div class="col-md-10"><div class="alert alert-danger border-0 small" style="background: rgba(220, 38, 38, 0.1); color: #f87171;">
                    <i class="fa fa-exclamation-circle mr-2"></i> '.$msg.'
                  </div></div>';
        }
    }
    ?>
    <div class="col-md-10">
      <div class="admin-glass-panel animate-fade-in">
        <h2 class="admin-header-title text-center"><i class="fa fa-plane-arrival mr-2 text-secondary"></i>ADD NEW FLIGHT</h2>
        <hr class="mb-5">

        <form method="POST" action="../includes/admin/flight.inc.php">

          <div class="row mb-4">
            <div class="col-md-6 mb-4 mb-md-0">
               <div class="p-4 rounded border" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                 <h5 class="font-weight-bold mb-3" style="color: var(--secondary-color);">DEPARTURE</h5>
                 <div class="form-group">
                   <label class="small font-weight-bold text-muted">DATE</label>
                   <input type="date" name="source_date" class="admin-input bg-white" required>
                 </div>
                 <div class="form-group mb-0">
                   <label class="small font-weight-bold text-muted">TIME</label>
                   <input type="time" name="source_time" class="admin-input bg-white" required>
                 </div>
               </div>
            </div>

            <div class="col-md-6">
               <div class="p-4 rounded border" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                 <h5 class="font-weight-bold mb-3" style="color: var(--secondary-color);">ARRIVAL</h5>
                 <div class="form-group">
                   <label class="small font-weight-bold text-muted">DATE</label>
                   <input type="date" name="dest_date" class="admin-input bg-white" required>
                 </div>
                 <div class="form-group mb-0">
                   <label class="small font-weight-bold text-muted">TIME</label>
                   <input type="time" name="dest_time" class="admin-input bg-white" required>
                 </div>
               </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6 form-group">
              <label class="small font-weight-bold text-muted">FROM (SOURCE)</label>
              <select name="dep_city" class="admin-input" required>
                <option value="" selected disabled>Select Departure City</option>
                <?php
                $sql = 'SELECT * FROM Cities ORDER BY city ASC';
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);         
                mysqli_stmt_execute($stmt);          
                $result = mysqli_stmt_get_result($stmt);    
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="'. htmlspecialchars($row['city'])  .'">'. htmlspecialchars($row['city']) .'</option>';
                }
                ?>
              </select>             
            </div>
            
            <div class="col-md-6 form-group">
              <label class="small font-weight-bold text-muted">TO (DESTINATION)</label>
              <select name="arr_city" class="admin-input" required>
                <option value="" selected disabled>Select Arrival City</option>
                <?php
                mysqli_data_seek($result, 0); // Reset result pointer
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="'. htmlspecialchars($row['city'])  .'">'. htmlspecialchars($row['city']) .'</option>';
                }
                ?>
              </select>                
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-4 form-group">
                <label class="small font-weight-bold text-muted">FLIGHT DURATION</label>
                <input type="text" name="dura" class="admin-input" placeholder="e.g. 2h 30m" required />
            </div>            
            <div class="col-md-4 form-group">
                <label class="small font-weight-bold text-muted">TICKET PRICE ($)</label>
                <input type="number" name="price" class="admin-input" placeholder="0.00" required />
            </div>
            <div class="col-md-4 form-group">
                <label class="small font-weight-bold text-muted">AIRLINE</label>
                <select name="airline_name" class="admin-input" required>
                  <option value="" selected disabled>Select Airline</option>
                  <?php
                  $sql = 'SELECT * FROM Airline ORDER BY name ASC';
                  $stmt = mysqli_stmt_init($conn);
                  mysqli_stmt_prepare($stmt,$sql);         
                  mysqli_stmt_execute($stmt);          
                  $result = mysqli_stmt_get_result($stmt);    
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'. htmlspecialchars($row['airline_id'])  .'">'. htmlspecialchars($row['name']) .'</option>';
                  }
                  ?>
                </select>            
            </div>
          </div>              

          <div class="text-right mt-5">
            <button name="flight_but" type="submit" class="btn btn-admin-premium btn-lg px-5">
              Publish Flight <i class="fa fa-arrow-right ml-2"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</main>

<?php } ?>
<?php include_once 'footer.php'; ?>
