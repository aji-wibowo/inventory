<section class="content-header">
  <h1>
    Supplier
    <small>Kelola Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= base_url('/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Supplier</li>
  </ol>
</section>

<section class="content">

  <div class="box">
    <div class="box-header">
      <div>
        <h4 style="float: left">Daftar Supplier</h4>
        <div>
          <a href="#" id="bTambah" data-target="#ourModal" data-toggle="modal" class="btn btn-xs btn-success" style="float: right"><i class="fa fa-plus"></i> tambah</a>
        </div>
      </div>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="tListSupplier">
          <thead>
            <tr>
              <th>Nama Supplier</th>
              <th>Alamat</th>
              <th>No. Telp</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tbody">

          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ourModal" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Default Modal</h4>
          </div>
          <div class="modal-body">
            <form id="formTambahSupplier" action="#" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama_supplier">Nama Supplier</label>
                    <input id="nama_supplier" type="text" name="nama_supplier" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" name="alamat" id="alamat"></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="telp">No. Telpon</label>
                    <input id="telp" type="number" name="telp" class="form-control">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">close</button>
            <button id="bSubmit" type="button" class="btn btn-primary">save</button>
          </div>
        </div>
      </div>
    </div>

  </section>

  <script type="text/javascript">

    $(document).ready(function(){

      load();

      $('#bTambah').click(function(e){
        e.preventDefault();
        var form = $('#formTambahSupplier');
        form.attr('action', '<?= base_url() ?>staff/supplier/ajax/save');
        form[0].reset();
        $('#ourModal .modal-title').html('Tambah Supplier');
      })

      $(document).on('click', '.bEdit', function(e){
        var dataId = $(this).attr('data-id');
        var form = $('#formTambahSupplier');
        form.attr('action', '<?= base_url() ?>staff/supplier/ajax/update/' + dataId);
        form[0].reset();
        $('#ourModal .modal-title').html('Edit Supplier');

        $.ajax({
          url : '<?= base_url('staff/supplier/ajax/get/id') ?>',
          type : 'POST',
          data : {id : dataId},
          success : function(r){
            obj = $.trim(r);
            obj = $.parseJSON(obj);
            if(obj.status == 0){
              swal(obj.title, obj.text, obj.icon);
            }else{
              $('#nama_supplier').val(obj.supplier_name);
              $('#alamat').val(obj.address);
              $('#telp').val(obj.phone);
            }
          }
        });
      });

      $(document).on('click', '.bDelete', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        swal({
          title: "Anda yakin?",
          text: "Data akan dihapus dan tidak bisa kembali!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url : '<?= base_url('staff/supplier/ajax/delete/') ?>' + id,
              type : 'post',
              success : function(data){
                obj = $.trim(data);
                obj = $.parseJSON(obj);
                load();
                swal(obj.title, obj.text, obj.icon);
              },
              error : function(err){
                swal(err);
              }
            })
          } else {
            swal("Data tidak jadi dihapus");
          }
        });
      })

      $('#bSubmit').click(function(e){
        e.preventDefault();
        var form = $('#formTambahSupplier');
        var data = new FormData(form[0]);

        $.ajax({
          url: form.attr('action'),
          type: 'POST',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function (data) {
            obj = $.trim(data);
            obj = $.parseJSON(obj);
            if(obj.status == 1){
              $('#ourModal').modal('hide');
            }
            load();
            swal(obj.title, obj.text, obj.icon);
          }
        });
      });

      function load(){
        $.ajax({
          url : '<?= base_url('staff/supplier/ajax/get/all') ?>',
          type : 'post',
          success : function(r){
            r = $.trim(r);
            r = $.parseJSON(r);
            var html = '';

            if(r.title){
              swal(r.title, r.text, r.icon);
            }else{

              $.each(r, function(i, item){
                html += '<tr>'
                + '<td>'+ item.supplier_name +'</td>'
                + '<td>'+ item.address +'</td>'
                + '<td>'+ item.phone +'</td>'
                + '<td>'+ item.button +'</td>'
                + '</tr>';
              });

              $('#tListSupplier #tbody').html(html);

              if ( $.fn.dataTable.isDataTable( '#tListSupplier' ) ) {
                $('#tListSupplier').DataTable();
              }
              else {
                $('#tListSupplier').DataTable({
                  "columnDefs": [ {
                    "order": [[ 0, "desc" ]],
                    "targets": 1,
                    "orderable": false
                  } ]
                });
              }

            }
          }
        });
      }

    })

  </script>


































