<?php include('header.php'); ?>
<?php include('session.php'); ?>

<body>
  <?php include('navbar.php'); ?>
  <div class="container-fluid">
    <div class="row-fluid">
      <?php include('sidebar.php'); ?>

      <div class="span9" id="">
        <div class="row-fluid">
          <!-- block -->

          <div class="empty">
            <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="icon-info-sign"></i> <strong>Note!:</strong> Here is the records from your previous slot reservation
            </div>
          </div>

          <?php
          $result = mysqli_query($conn, 'SELECT SUM(slots) AS slots FROM sportreserve where eventDate >= now()');
          $row = mysqli_fetch_assoc($result);
          $sum = $row['slots'];
          ?>
          <div id="block_bg" class="block">
            <div class="navbar navbar-inner block-header">
              <div class="muted pull-left"></i><i class="icon-user"></i> Reserving List History</div>
              <div class="muted pull-right">
                Total Number Reserving History: <span class="badge badge-info"><?php echo $sum; ?></span>
              </div>
            </div>
            <div class="block-content collapse in">


              <div style="display: ; font-size:large; " style="font-weight:bold;" class="span20" id="printableArea">
                <div class="empty">
                  <div class="alert alert-success alert-dismissable">
                    Slot reserved
                  </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="1" class="table" tyle="width:100%" id="example">
                  <thead>
                    <tr>
                      <th>Event Name</th>
                      <th> &#160 By &#160</th>
                      <th> &#160 Slots &#160</th>
                      <th style="margin-right:16; margin-left:8; padding-left:16"> Date Booked</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $total = 0;
                    $user_query = mysqli_query($conn, "select * from members INNER JOIN sportreserve ON members.id=sportreserve.na where eventDate >= now()") or die(mysqli_error());
                    while ($row = mysqli_fetch_array($user_query)) {
                      $id = $row['id'];
                    ?>

                      <tr>
                        <td>
                          <?php
                          //echo $row['eventId'];
                          $myEventId = $row['eventId'];

                          $query = "select * from slotsreserved WHERE eventId ='$myEventId' limit 1"; // Fetch all the data from the table customers
                          $result = mysqli_query($conn1, $query);
                          $singleRow = mysqli_fetch_row($result);
                          ?>
                          <span class="card-text"><?php echo $singleRow['2']; ?> </span><br>

                        </td>
                        <td style="text-align: center;">
                          <?php echo $row['fname'] . ' &#160' . $row['sname']; ?>
                        </td>
                        <td style="text-align: center;"><?php echo $row['slots'];
                                                        $total += 1; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($row['created'])); ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <?php echo $total; ?> Total Slots Reserved
              </div>
              <a class=" btn btn-primary btn-lg" style="background-color: blue;" href="javascript:void(0);" onclick="printPageArea('printableArea')">
                Print report
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include('footer.php'); ?>
  </div>
  <?php include('script.php'); ?>
</body>

</html>