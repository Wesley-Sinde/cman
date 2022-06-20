  <?php
    @$eventId = $_GET['eventId'];
    if ($eventId != '') {


        $selEventData = $conn1->query("SELECT * FROM slotsreserved WHERE eventId='$eventId ' ");
        $selslotsRow = $selEventData->fetch(PDO::FETCH_ASSOC);
        if ($selEventData->rowCount() > 0) {
            $Totseats = $selslotsRow['slots'];
            $eventDate = $selslotsRow['eventDate'];
        }
    ?>

      <?php

        if (isset($_POST['send'])) {

            //add formsend delete
            $formreceived = $_POST['formsend'];
            if ($formreceived == 'add') {


                $slots = $_POST['slots'];
                $insData = $conn->query("INSERT into  sportreserve  (slots, na, eventId,eventDate) VALUES ('$slots','$session_id','$eventId','$eventDate')");
                //mysqli_query($conn, "insert into sportreserve (slots,na) values('$slots','$session_id')") or die(mysqli_error());
                if ($insData) {
                    echo ('Reserve added');
        ?>
                  <script>
                      window.location = "myReserve.php";
                      $.jGrowl("The Reserve Successfully added", {
                          header: 'Reserve added'
                      });
                  </script>
              <?php
                } else {
                    echo ('failed');
                ?>
                  <script>
                      window.location = "myReserve.php";
                      $.jGrowl("The Reserve failed to be added", {
                          header: 'Reserve save failed'
                      });
                  </script>
              <?php
                }
                ?>
              <?php
            } else {
                $slots = $_POST['slots'];
                $insData = $conn->query("DELETE FROM `sportreserve` WHERE `sportreserve`.`na` = '$session_id' and eventId='$eventId'");

                // $insData = $conn->query("INSERT into  sportreserve  (slots, na, eventId,eventDate) VALUES ('$slots','$session_id','$eventId','$eventDate')");
                // //mysqli_query($conn, "insert into sportreserve (slots,na) values('$slots','$session_id')") or die(mysqli_error());
                if ($insData) {
                    echo ('Reserve deleted');
                ?>
                  <script>
                      //   window.location = "myReserve.php";
                      $.jGrowl("The Reserve Successfully deleted", {
                          header: 'Reserve deleted'
                      });
                  </script>
              <?php
                } else {
                    echo ('failed');
                ?>
                  <script>
                      //   window.location = "myReserve.php";
                      $.jGrowl("The Reserve failed to be deleted", {
                          header: 'Reserve deleted failed'
                      });
                  </script>
              <?php
                }
                ?>
      <?php
            }
        }





        $sresult = mysqli_query($conn, "SELECT SUM(slots) AS slots FROM sportreserve where eventId='$eventId'");
        $srow = mysqli_fetch_assoc($sresult);
        $ssum = $srow['slots'];
        $seats = $Totseats - $ssum;
        ?>





      <div class="row-fluid">
          <!-- block -->
          <div class="block">
              <div class="navbar navbar-inner block-header">
                  <div class="muted pull-left"><i class="icon-plus-sign icon-large"> Reserve Your Spot</i></div>
                  <hr>
                  <div class="muted pull-left"> </div>
                  <div class="empty">
                      <div class="alert alert-success alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <i class="icon-info-sign"></i>
                          <strong>Note!:</strong>
                          Spot Reserved:
                          <?php echo $ssum;
                            if ($ssum === null) {
                                echo '0';
                            } ?> <span style="color: red;"> To delete your slots click on any of the buttons below.</span>
                      </div>
                  </div>
              </div>

              <?php
                $con = mysqli_connect("localhost", "root", "", "cman");
                // Check connection
                if (mysqli_connect_errno()) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }

                $sql = "SELECT * FROM sportreserve where eventId='$eventId' and na='$session_id'";

                if ($result = mysqli_query($con, $sql)) {
                    $rowcount = mysqli_num_rows($result);
                    $slotsRamining = 5 - $rowcount;
                }
                mysqli_close($con);
                ?>
              <div class="block-content collapse in">
                  <div class="span12">
                      <?php
                        if ($slotsRamining <= 0) { ?>
                          <style>
                              .svg:hover {
                                  fill: blue;
                                  color: blue;
                              }

                              .svg {
                                  fill: #000066;
                                  font-size: 2;
                                  color: #000066;

                              }

                              .svgr:hover {
                                  fill: red;
                                  color: red;
                              }

                              .svgr {
                                  fill: blue;
                                  color: blue;
                              }
                          </style>
                      <?php } else { ?>
                          <style>
                              .svg:hover {
                                  fill: blue;
                                  color: blue;
                              }

                              .svg {
                                  fill: #00cc66;
                                  font-size: 2;
                                  color: #00cc66;

                              }

                              .svgr:hover {
                                  fill: red;
                                  color: red;
                              }

                              .svgr {
                                  fill: blue;
                                  color: blue;
                              }
                          </style>
                      <?php } ?>
                      <div>
                          <?php
                            $x = 1;
                            $Seats = 1;
                            while ($x <= $ssum) {
                            ?> <form method="post" class="span2">
                                  <input name="slots" type="hidden" value="1" id="slots">
                                  <input name="formsend" type="hidden" value="delete" id="slots">
                                  <button <?php if ($slotsRamining < 0) {
                                                echo "disabled";
                                            }; ?> type="submit" id="submit" name="send" class="btn btn-primary btn-lg flex block svgr">

                                      <span style="position: absolute; padding-top:20px; padding-left:15px;  font-weight: bolder; color:white">

                                          <?php
                                            echo $Seats;
                                            $x++;
                                            $Seats += 1;
                                            ?>
                                      </span>
                                      <svg style="width: 40; " class="w-6 h-6 svgr" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                      </svg>

                                  </button>
                              </form>
                          <?php
                            }
                            ?>
                      </div>
                      <div class="row-fluid">
                          <!-- <div class="empty">
                              <div class="alert alert-success alert-dismissable">
                                  <i class="icon-info-sign"></i>
                                  <strong>Note!:</strong>
                                  Spot remaining:
                                  <?php echo $seats;
                                    if ($seats === null) {
                                        echo '0';
                                    }
                                    ?>
                                  You have <?php echo $slotsRamining  ?> slots remaining to reserve
                              </div>
                          </div> -->

                      </div>
                      <div class="empty">
                          <div class="alert alert-success alert-dismissable">
                              <i class="icon-info-sign"></i>
                              <strong>Note!:</strong>
                              Spot remaining:
                              <?php echo $seats;
                                if ($seats === null) {
                                    echo '0';
                                }
                                ?>
                              <span style="color: red;"> You have <?php echo $slotsRamining  ?> slots remaining to reserve</span>
                          </div>
                      </div>
                      <div class="row-fluid">
                          <?php
                            $x = 1;
                            while ($x <= $seats) {
                            ?>
                              <form method="post" class="span2">
                                  <input name="slots" type="hidden" value="1" id="slots">
                                  <input name="formsend" type="hidden" value="add" id="slots">
                                  <button <?php if ($slotsRamining <= 0) {
                                                echo "disabled";
                                            }; ?> type="submit" id="submit" name="send" class="btn btn-primary btn-lg flex block svg">
                                      <span style="position: absolute; padding-top:20px; padding-left:15px;  font-weight: bolder; color:white">

                                          <?php
                                            echo $Seats;
                                            $x++;
                                            $Seats += 1;
                                            ?>
                                      </span>
                                      <svg style="width: 40; " class="w-6 h-6 svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                      </svg>
                                  </button>
                              </form>
                          <?php
                                $x++;
                                $Seats += 1;
                            }
                            ?>
                      </div>


                      <!-- <form method="post">
                          <div class="control-group">
                              <div class="controls">

                                  <input class="input focused" name="slotsAvailable" value="<?php echo $seats; ?>" required id="slotsAvailable" type="hidden" class="form-control">



                                  <input name="slots" required id="slots" placeholder="Enter Total Of The Sports You Want To Reserve..." class="form-control">

                                  <br>
                                  <hr>
                                  <button onclick="checkSlots()" class="btn btn-info" data-placement="right" title="Click to Check">
                                      <i class="icon-info-sign icon-large"> Check Validity</i>
                                  </button>
                                  <br>
                                  <hr>
                                  <button disabled type="submit" id="submit" name="send" class="btn btn-primary btn-lg">
                                      Reserve Slot(s)
                                  </button>
                                  <p style="color: red; font-weight: bold;" id="errorMessage"></p>

                              </div>
                          </div>
                          <p style="color: red; font-weight: bold;" id="message"></p>
                      </form> -->
                  </div>
              </div>
          </div>
          <!-- /block -->
      </div>

      </script>
      <script>
          function checkSlots() {
              event.preventDefault();
              var status = document.getElementById("errorMessage");
              var submit = document.getElementById("submit");

              status.innerHTML = "You Are Ok To Submit";
              status.style.color = color = 'green';
              submit.removeAttribute("disabled");

              if (document.getElementById("slots").value === "") {
                  status.style.color = color = 'red';
                  status.innerHTML = "Check On Your Slots, they must be less than or equal to the remaining slots";
                  submit.setAttribute("disabled", "disabled");
              }
              return;

              if (document.getElementById("slotsAvailable").value >= document.getElementById("slots").value)
                  return;
              status.style.color = color = 'red';
              status.innerHTML = "Check On Your Slots, they mustbe less than or equal to the remaining slots And not Empty";
              submit.setAttribute("disabled", "disabled");
          }

          //   document.getElementById("slotsAvailable").addEventListener("change", function(event) {
          //       checkSlots();
          //   });
          //   document.getElementById("slots").addEventListener("onblur", function(event) {
          //       checkSlots();
          //   });
          //   document.getElementById("slots").addEventListener("Keydown", function(event) {
          //       checkSlots();
          //   });
          //   document.getElementById("slots").addEventListener("onblur", function(event) {
          //       checkSlots();
          //   });
      </script>
  <?php
    }
    ?>