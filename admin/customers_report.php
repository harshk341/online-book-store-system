<?php
include 'db_connect.php';
?>
<div class="container-fluid">


  <div class="col-lg-12">
    <div class="card">
      <div class="card_body pt-4">
        <div class="col-md-12">
          <table class="table table-bordered" id='report-list'>
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="">Name</th>
                <th class="">Address</th>
                <th class="">Contact</th>
                <th class="">Email</th>
                <th class="">Registration Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              $orders = $conn->query("SELECT * FROM customers c order by unix_timestamp(c.date_created) asc ");
              if ($orders->num_rows > 0):
                while ($row = $orders->fetch_array()):
              ?>
                  <tr>
                    <td class="text-center"><?php echo $i++ ?></td>

                    <td>
                      <p class="text-right"> <b><?php echo ucwords($row['name']) ?></b></p>
                    </td>
                    <td>
                      <p class="text-right"> <b><?php echo $row['address'] ?></b></p>
                    </td>
                    <td>
                      <p class="text-right"> <b><?php echo $row['contact'] ?></b></p>
                    </td>
                    <td>
                      <p class="text-right"> <b><?php echo $row['email'] ?></b></p>
                    </td>
                    <td>
                      <p> <b><?php echo date("M d,Y", strtotime($row['date_created'])) ?></b></p>
                    </td>
                  </tr>
                <?php
                endwhile;
              else:
                ?>
                <tr>
                  <th class="text-center" colspan="7">No Data.</th>
                </tr>
              <?php
              endif;
              ?>
            </tbody>
          </table>
          <hr>
          <div class="col-md-12 mb-4">
            <center>
              <button class="btn btn-success btn-sm col-sm-3" type="button" id="print"><i class="fa fa-print"></i> Print</button>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<noscript>
  <style>
    table#report-list {
      width: 100%;
      border-collapse: collapse
    }

    table#report-list td,
    table#report-list th {
      border: 1px solid
    }

    p {
      margin: unset;
    }

    .text-center {
      text-align: center
    }

    .text-right {
      text-align: right
    }
  </style>
</noscript>
<script>
  $('#month').change(function() {
    location.replace('index.php?page=sales_report&month=' + $(this).val())
  })
  $('#report-list').dataTable()
  $('#print').click(function() {
    $('#report-list').dataTable().fnDestroy()
    var _c = $('#report-list').clone();
    var ns = $('noscript').clone();
    ns.append(_c)
    var nw = window.open('', '_blank', 'width=900,height=600')
    nw.document.write('<p class="text-center"><b>Book Store Customers Report</b></p>')
    nw.document.write(ns.html())
    nw.document.close()
    nw.print()
    setTimeout(() => {
      nw.close()
      $('#report-list').dataTable()
    }, 500);
  })
</script>