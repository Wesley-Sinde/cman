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
              <i class="icon-info-sign"></i> <strong>Note!:</strong> Here is the total slot reserved for this event
            </div>
          </div>

          <?php
          $result = mysqli_query($conn, 'SELECT SUM(slots) AS slots FROM sportreserve where eventDate >= now()');
          $row = mysqli_fetch_assoc($result);
          $sum = $row['slots'];
          ?>
          <div id="block_bg" class="block">
            <div class="navbar navbar-inner block-header">
              <div class="muted pull-left"></i>
                <i class="icon-user"></i>
                Reserving List History
              </div>
              <div class="muted pull-right">
                Total Number Reserving History: <span class="badge badge-info"><?php echo $sum; ?></span>
              </div>
            </div>
            <div class="block-content collapse in">
              <div class="span20">
                <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Event Name</th>
                      <th>Slots Reserved</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $user_query = mysqli_query($conn, "select * from members INNER JOIN sportreserve ON members.id=sportreserve.na where na='$session_id' and eventDate >= now()") or die(mysqli_error());
                    while ($row = mysqli_fetch_array($user_query)) {
                      $id = $row['id'];
                    ?>

                      <tr>
                        <td width="30">
                          <input id="optionsCheckbox" class="uniform_on" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                        </td>
                        <td>
                          <?php
                          $myEventId = $row['eventId'];
                          $selEventName = $conn1->query("SELECT * FROM slotsreserved WHERE eventId ='$myEventId' ")->fetch(PDO::FETCH_ASSOC);
                          echo $selEventName['title'];
                          ?>
                        </td>
                        <td><?php echo $row['slots']; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($row['created'])); ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>

              <div style="display: none; font-size:large; " style="font-weight:bold;" class="span20" id="printableArea">
                <div class="empty">
                  <div class="alert alert-success alert-dismissable">
                    Slot reserved
                  </div>
                </div>
                <table cellpadding="0" cellspacing="2" border="0" class="" id="example">
                  <thead>
                    <tr>
                      <th>Event Name</th>
                      <th>Slots</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $total = 0;
                    $user_query = mysqli_query($conn, "select * from members INNER JOIN sportreserve ON members.id=sportreserve.na where na='$session_id' and eventDate >= now()") or die(mysqli_error());
                    while ($row = mysqli_fetch_array($user_query)) {
                      $id = $row['id'];
                    ?>

                      <tr>
                        <td>
                          <?php
                          $myEventId = $row['eventId'];
                          $selEventName = $conn1->query("SELECT * FROM slotsreserved WHERE eventId ='$myEventId' ")->fetch(PDO::FETCH_ASSOC);
                          echo $selEventName['title'];
                          ?>
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
                Print Receipt
              </a>
            </div>
          </div>
          <!-- /block -->
        </div>


      </div>
    </div>
    <script>
      function printPageArea(areaID) {
        var printContent = document.getElementById(areaID);
        var WinPrint = window.open('', '', 'width=900,height=650');
        WinPrint.document.write(printContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        //   WinPrint.close();
      }
    </script>
    <?php include('footer.php'); ?>
  </div>
  <?php include('script.php'); ?>
</body>

</html>