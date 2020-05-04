<section class="content-header">
  <h1>
    Transaksi Barang Masuk
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
        <h4 style="float: left">List Barang Masuk</h4>
        <div>
          <a href="<?= base_url('staff/transaksi/masuk') ?>" class="btn btn-xs btn-success" style="float: right"><i class="fa fa-plus"></i> tambah</a>
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
                  <th>No. Faktur</th>
                  <th>Nama Supplier</th>
                  <th>Tanggal Pembelian</th>
                  <th>Total</th>
                  <th>#</th>
                </tr>
              </thead>
              <tbody>
                <?php if($list->num_rows() > 0){ ?>
                  <?php foreach($list->result() as $row){ ?>
                    <tr>
                      <td><?= $row->id_buy_item ?></td>
                      <td><?= $row->invoice_number ?></td>
                      <td><?= $row->supplier_name ?></td>
                      <td><?= date('d-M-Y', strtotime($row->buy_date)) ?></td>
                      <td>Rp. <?= currency_format($row->total) ?></td>
                      <td><button data-id="<?= $row->id_buy_item ?>" data-toggle="modal" data-target="#ourModal" class="btn btn-xs btn-info bDetail"><i class="fas fa-info-circle"></i>  detail</button></td>
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
            <h4 class="modal-title">Detail Barang Masuk</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>ID</label>
                  <input type="text" class="form-control" id="id_buy_item" readonly>
                </div>
                <div class="form-group">
                  <label>Tanggal Pembelian</label>
                  <input type="text" class="form-control" id="buy_date" readonly>
                </div>
                <div class="form-group">
                  <label>Supplier</label>
                  <input type="text" class="form-control" id="supplier" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>No. Faktur</label>
                  <input type="text" class="form-control" id="invoice_number" readonly>
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
          url : '<?= base_url('staff/transaksi/ajax/masuk/detail/') ?>' + id,
          type : 'POST',
          success : function(r){
            r = $.trim(r);
            r = $.parseJSON(r);

            if(r.status){
              swal(r.title, r.text, r.icon);
              $('#ourModal').modal('hide');
            }else{
              $('#id_buy_item').val(r[0].id_buy_item);
              $('#invoice_number').val(r[0].invoice_number);
              $('#supplier').val(r[0].supplier_name);
              $('#total').val(addCommas(r[0].total));
              $('#buy_date').val(r[0].buy_date);

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