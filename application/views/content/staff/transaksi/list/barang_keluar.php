<section class="content-header">
  <h1>
    Transaksi Barang Keluar
    <small>List</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= base_url('/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">List Transaksi</li>
  </ol>
</section>

<section class="content">

  <div class="box">

    <div class="box-header">
      <div>
        <h4 style="float: left">List Barang Keluar</h4>
        <div>
          <a href="<?= base_url('staff/transaksi/keluar') ?>" class="btn btn-xs btn-success" style="float: right"><i class="fa fa-plus"></i> tambah</a>
        </div>
      </div>
    </div>

    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered" id="tListBarangMasuk">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama Pelanggan</th>
                  <th>Tanggal Penjualan / Keluar</th>
                  <!-- <th>Pelanggan Bayar</th> -->
                  <!-- <th>Kembalian</th> -->
                  <th>Total</th>
                  <th>#</th>
                </tr>
              </thead>
              <tbody>
                <?php if($list->num_rows() > 0){ ?>
                  <?php foreach($list->result() as $row){ ?>
                    <tr>
                      <td><?= $row->id_sell_item ?></td>
                      <td><?= $row->customer ?></td>
                      <td><?= date('d-M-Y', strtotime($row->sell_date)) ?></td>
                      <!-- <td>Rp. <?= currency_format($row->customer_payment) ?></td> -->
                      <!-- <td>Rp. <?= currency_format($row->customer_change) ?></td> -->
                      <td>Rp. <?= currency_format($row->total) ?></td>
                      <td><button data-id="<?= $row->id_sell_item ?>" data-toggle="modal" data-target="#ourModal" class="btn btn-xs btn-info bDetail"><i class="fas fa-info-circle"></i>  detail</button></td>
                    </tr>
                  <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="modal fade" id="ourModal" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Detail Barang Keluar</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>ID</label>
                  <input type="text" class="form-control" id="id_sell_item" readonly>
                </div>
                <div class="form-group">
                  <label>Pelanggan</label>
                  <input type="text" class="form-control" id="customer" readonly>
                </div>
                <div class="form-group">
                  <label>Tanggal Penjualan / Keluar</label>
                  <input type="text" class="form-control" id="sell_date" readonly>
                </div>
              </div>
              <div class="col-md-6">
               <!--  <div class="form-group">
                  <label>Pelanggan Bayar</label>
                  <input type="text" class="form-control" id="customer_payment" readonly>
                </div>
                <div class="form-group">
                  <label>Kembalian</label>
                  <input type="text" class="form-control" id="customer_change" readonly>
                </div> -->
                <div class="form-group">
                  <label>Staff</label>
                  <input type="text" class="form-control" id="staff" readonly>
                </div>
                <div class="form-group">
                  <label>Total</label>
                  <input type="text" class="form-control" id="total" readonly>
                </div>
              </div>
            </div>
            <hr>
            <h5 class="box-title">Detail Barang</h5>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tDetail">
                    <thead>
                      <tr>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody id="tBodyDetail"></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">close</button>
          </div>
        </div>
      </div>
    </div>

  </section>

  <script type="text/javascript">

    $(document).ready(function(){

      $('#tListBarangMasuk').DataTable();

      $(document).on('click', '.bDetail', function(e){
        e.preventDefault();

        var id = $(this).attr('data-id');

        $.ajax({
          url : '<?= base_url('staff/transaksi/ajax/keluar/detail/') ?>' + id,
          type : 'POST',
          success : function(r){
            r = $.trim(r);
            r = $.parseJSON(r);

            if(r.status == 0){
              swal(r.title, r.text, r.icon);
              $('#ourModal').modal('hide');
            }else{
              $('#id_sell_item').val(r[0].id_sell_item);
              $('#customer').val(r[0].customer);
              $('#sell_date').val(r[0].sell_date);
              $('#total').val(addCommas(r[0].total));
              // $('#customer_payment').val(addCommas(r[0].customer_payment));
              // $('#customer_change').val(addCommas(r[0].customer_change));
              $('#staff').val(addCommas(r[0].fullname));

              var html = '';
              $.each(r, function(i, item){
                html += '<tr>'
                + '<td>'+item.item_name+'</td>'
                + '<td>'+item.unit_name+'</td>'
                + '<td>'+item.qty+'</td>'
                + '<td>'+addCommas(item.price)+'</td>'
                + '<td>'+addCommas(item.subtotal)+'</td>'
                + '</tr>';
              });

              $('#tBodyDetail').html(html);
            }
          }
        })
      });

    })


    function addCommas(nStr)
    {
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      return x1 + x2;
    }

















  </script>