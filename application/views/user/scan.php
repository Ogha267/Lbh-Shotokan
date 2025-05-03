   <!-- Begin Page Content -->
   <div class="container-fluid">
       <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h2 class="h4 mb-0 text-gray-800"><?php echo $title; ?></h2>
           <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
       </div>
       <div class="row">
           <div class="col-xl-12 col-lg-5">
               <div class="card shadow mb-4">
                   <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                       <!-- <h6 class="m-0 font-weight-bold text-primary"><?php echo $title; ?></h6> -->
                       <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-user"><i class="fas fa-file-import"></i> <b>Tambah File Scanner</b></button>
                   </div>
                   <div class="card-body">
                       <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                       <?php echo $this->session->flashdata('msg'); ?>
                       <?php if (validation_errors()) { ?>
                           <div class="alert alert-danger">
                               <strong><?php echo strip_tags(validation_errors()); ?></strong>
                               <a href="" class="float-right text-decoration-none" data-dismiss="alert"><i class="fas fa-times"></i></a>
                           </div>
                       <?php } ?>
                       <div class="table-responsive">
                           <table class="table table-bordered" id="table-id">
                               <thead>
                                   <th>#</th>
                                   <th>Gambar</th>
                                   <th>Tgl Upload</th>
                                   <th>Nama Berkas Scan</th>
                                   <th>Nama Files Scan</th>
                                   <!-- <th>Edit</th> -->
                                   <th>Download</th>
                               </thead>
                               <tbody>
                                   <?php $i = 1; ?>
                                   <?php foreach ($list_file as $lu) : ?>
                                       <tr>
                                           <td><?php echo $i++; ?></td>
                                           <td><img src="<?php echo base_url('assets/images/' . $lu['scan']); ?>" alt="..." class="img-thumbnail" style="width:100px;"></td>
                                           <td><?php echo format_indo($lu['tgl_upload_scan']); ?></td>
                                           <td><?php echo $lu['nama_dokumen_scan']; ?></td>
                                           <td><?php echo $lu['scan']; ?></td>
                                           <!-- <td><a href=" #" class="tombol-edit btn btn-primary btn-block btn-sm" data-id="<?php echo $lu['id_scan']; ?>" data-toggle="modal" data-target="#edit-user"><i class="fas fa-edit"></i> Edit</a></td> -->
                                           <td><a href="<?php echo base_url('user/download_scan/') . $lu['id_scan']; ?>" class="btn btn-info btn-block btn-sm"><i class="fas fa-download"></i> Download</a> </td>
                                       </tr>
                                   <?php endforeach; ?>
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <!-- Modal -->
   <div class="modal fade" id="add-user">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title">Tambah File Scanner</h4>
               </div>
               <div class="modal-body">
                   <div class="box-body">
                       <?php echo form_open_multipart('user/scan'); ?>
                       <div class="form-group">
                           <label>Tgl Upload</label>
                           <input type="date" class="form-control form-control-sm" name="tgl_upload_scan" required>
                       </div>
                       <div class="form-group">
                           <label>Nama Dokumen</label>
                           <input type="text" class="form-control form-control-sm" name="nama_dokumen_scan" required>
                       </div>
                       <div class="form-group">
                           <input type="file" name="scan" required>
                       </div>
                       <button type="submit" class="btn btn-primary mr-2">Upload File Scan </button>
                       <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                       </form>
                       <hr>
                       * File Upload harus format JPG, JPEG, PNG.<br>
                       * Ukuran File tidak lebih dari 2 MB.<br>
                   </div>
               </div>
               <!-- /.modal-content -->
           </div>
           <!-- /.modal-dialog -->
       </div>
   </div>

   <div class="modal fade" id="edit-user">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title">Edit Dokumen</h4>
               </div>
               <div class="modal-body">
                   <div class="box-body">
                       <?php echo form_open_multipart('user/edit_scan'); ?>
                       <div class="form-group">
                           <label>Tgl Upload</label>
                           <input type="hidden" name="id_scan" id="id_scan">
                           <input type="date" class="form-control form-control-sm" name="tgl_upload_scan" id="tgl_upload_scan" required>
                       </div>
                       <div class="form-group">
                           <label>Nama Dokumen</label>
                           <input type="text" class="form-control form-control-sm" name="nama_dokumen_scan" id="nama_dokumen_scan" required>
                       </div>
                       <div class="form-group">
                           <input type="file" name="scan">
                       </div>
                       <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan </button>
                       <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                       </form>
                       <hr>
                       * File Upload harus format JPG, JPEG, PNG.<br>
                       * Ukuran File tidak lebih dari 2 MB.<br>
                   </div>
               </div>
               <!-- /.modal-content -->
           </div>
           <!-- /.modal-dialog -->
       </div>
   </div>


   <script>
       $('.tombol-edit').on('click', function() {
           const id_scan = $(this).data('id');
           $.ajax({
               url: '<?php echo base_url('user/get_scan'); ?>',
               data: {
                   id_scan: id_scan
               },
               method: 'post',
               dataType: 'json',
               success: function(data) {
                   $('#nama_dokumen_scan').val(data.nama_dokumen_scan);
                   $('#tgl_upload_scan').val(data.tgl_upload_scan);
                   $('#id_scan').val(data.id_scan);
               }
           });
       });
   </script>