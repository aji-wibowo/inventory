<section class="content-header">
  <h1>
    Pengguna
    <small>Kelola Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= base_url('/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Pengguna</li>
  </ol>
</section>

<section class="content">

  <div class="box">
    <div class="box-header">
      <div>
        <h4 style="float: left">Daftar Pengguna</h4>
        <div>
          <a href="#" id="bTambah" data-target="#ourModal" data-toggle="modal" class="btn btn-xs btn-success" style="float: right"><i class="fa fa-plus"></i> tambah</a>
        </div>
      </div>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="tListPengguna">
          <thead>
            <tr>
              <th>Username</th>
              <th>Nama Asli</th>
              <th>Jabatan</th>
              <th>Status</th>
              <th>#</th>
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
            <form id="formTambahPengguna" action="#" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" class="form-control" autocomplete="new-password">
                  </div>
                  <div class="form-group">
                    <label for="repassword">Re-Password</label>
                    <input id="repassword" type="password" name="repassword" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="fullname">Nama Lengkap</label>
                    <input id="fullname" type="text" name="fullname" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                  <label for="level">Level Akses</label>
                  <select class="form-control" name="level" id="level">
                    <option value="">-Pilih Level-</option>
                    <option value="admin">Admin</option>
                    <option value="staff">staff</option>
                    <option value="manager">manager</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" name="status" id="status">
                    <option value="">-Pilih Status-</option>
                    <option value="1">Aktif</option>
                    <option value="0">NonAktif</option>
                  </select>
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

  load();

  $('#bTambah').click(function(e){
    e.preventDefault();
    var form = $('#formTambahPengguna');
    form.attr('action', '<?= base_url() ?>manager/pengguna/ajax/save');
    form[0].reset();
    $('#ourModal .modal-title').html('Tambah Pengguna');
    $('#username').removeAttr('readonly');
  })

  $(document).on('click', '.bEdit', function(e){
    e.preventDefault();
    var form = $('#formTambahPengguna');
    var id = $(this).attr('data-id');
    form.attr('action', '<?= base_url() ?>manager/pengguna/ajax/update/' + id);
    $('#ourModal .modal-title').html('Edit Pengguna');

    $.ajax({
      url : '<?= base_url('manager/pengguna/ajax/get/id') ?>',
      type : 'post',
      data : {id : id},
      success : function(r){
        obj = $.trim(r);
        obj = $.parseJSON(obj);
        
        if(obj.status == 0){
          $('#ourModal').modal('hide');
        }else{
          $('#username').val(obj.username).attr('readonly', 'true');
          $('#fullname').val(obj.fullname);
          $('#level').val(obj.level);
          $('#status').val(obj.statusAktif);
        }
        swal(obj.title, obj.text, obj.icon);
      }
    })
  })

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
          url : '<?= base_url('manager/pengguna/ajax/delete/') ?>' + id,
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
    var form = $('#formTambahPengguna');
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
      url : '<?= base_url('manager/pengguna/ajax/get/all') ?>',
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
            + '<td>'+ item.username +'</td>'
            + '<td>' + item.fullname + '</td>'
            + '<td>' + item.jabatan + '</td>'
            + '<td>' + item.status + '</td>'
            + '<td>' + item.button + '</td>'
            + '</tr>';
          });

          $('#tListPengguna #tbody').html(html);

          if ( $.fn.dataTable.isDataTable( '#tListPengguna' ) ) {
            $('#tListPengguna').DataTable();
          }
          else {
            $('#tListPengguna').DataTable({
              "columnDefs": [ {
                "order": [[ 1, "desc" ]],
                "targets": 2,
                "orderable": false
              } ]
            });
          }

        }
      }
    });
  }

</script>


































