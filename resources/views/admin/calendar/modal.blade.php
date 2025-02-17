 <!-- Modal untuk Detail Event -->
 <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="eventModalLabel">Detail Jadwal Service <span class="badge bg-warning"
                         id="badgeStatus">test</span></h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <table class="table table-bordered">
                     <tr>
                         <td colspan="2">
                             <center>
                                 <img id="modal-image" src=""
                                     style="width: 200px;height:200px; object-fit:cover;">
                             </center>
                         </td>
                     </tr>
                     <tr>
                         <td class="bg-primary text-white">Id Service</td>
                         <td><span id="modal-id-service"></span></td>
                     </tr>
                     <tr>
                         <td class="bg-primary text-white">Customer</td>
                         <td><span id="modal-title"></span></td>
                     </tr>
                     <tr>
                         <td class="bg-primary text-white">Alamat</td>
                         <td><span id="modal-alamat"></span></td>
                     </tr>
                     <tr>
                         <td class="bg-primary text-white">Keluhan</td>
                         <td><span id="modal-keluhan"></span></td>
                     </tr>
                     <tr>
                         <td class="bg-primary text-white">Tanggal</td>
                         <td><span id="modal-tanggal"></span></td>
                     </tr>
                     <tr>
                         <td class="bg-primary text-white">Waktu</td>
                         <td><span id="modal-waktu"></span></td>
                     </tr>
                     <tr>
                         <td class="bg-primary text-white">Teknisi</td>
                         <td><span id="modal-teknisi"></span></td>
                     </tr>
                     <!-- Add hidden fields for latitude and longitude -->
                     <tr>
                         <td class="bg-primary text-white">Latitude</td>
                         <td><span id="modal-latitude"></span></td>
                     </tr>
                     <tr>
                         <td class="bg-primary text-white">Longitude</td>
                         <td><span id="modal-longitude"></span></td>
                     </tr>
                 </table>
             </div>
             <div class="modal-footer justify-content-center">
                 @if (Auth::user()->role != 'Admin' || Auth::user()->role != 'K_teknisi')
                     <button type="button" id="start-pengerjaan" class="btn btn-primary">Mulai Pengerjaan</button>
                     <button type="button" id="alat-pengerjaan" class="btn btn-primary" style="display: none;">Update
                         Pengerjaan</button>
                 @endif
                 <a target="__blank" href="" id="modal-phone" class="btn btn-success">Hubungi Customer</a>
                 <a target="__blank" href="" id="modal-rute" class="btn btn-warning">Lihat Rute</a>
             </div>
         </div>
     </div>
 </div>
 <!-- Modal Timer -->
 <div class="modal fade" id="timerModal" tabindex="-1" aria-labelledby="timerModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="timerModalLabel">Timer Menuju Lokasi</h5>
             </div>
             <div class="modal-body">
                 <div class="timer-container">
                     <!-- Circle timer -->
                     <div style="position: relative; display: inline-block;">
                         <svg class="circle-timer" width="120" height="120" viewBox="0 0 120 120">
                             <circle class="background-circle" cx="60" cy="60" r="50" stroke="#e6e6e6"
                                 stroke-width="10" fill="none" />
                             <circle id="progress-circle" class="progress-circle" cx="60" cy="60" r="50"
                                 stroke="#4caf50" stroke-width="10" fill="none" stroke-dasharray="314.159"
                                 stroke-dashoffset="0" />
                         </svg>
                         <!-- Icon motor -->
                         <div class="icon-center">
                             <i class="bx bx-run bx-lg"></i>
                         </div>
                     </div>

                     <!-- Timer text -->
                     <div class="timer-text">
                         <span id="timer-display">00:00</span>
                     </div>
                     <div class="mt-2 p-2 border" style="border-radius:10px;">
                         <strong>Menuju <span id="nama-customer" class="text-primary"></span> di <span
                                 id="alamat-dituju" class="text-primary"></span></strong>
                     </div>
                     <div class="mt-3 text-center">
                         <p class="text-danger">Jangan tutup halaman ini hingga sampai pada lokasi</p>
                     </div>
                 </div>
             </div>
             <div class="modal-footer justify-content-center">
                 <button type="button" class="btn btn-success" id="stop-timer">
                     Sampai di lokasi
                 </button>
             </div>
         </div>
     </div>
 </div>
 <!-- Modal Konfirmasi -->
 <div class="modal fade" id="confirmStopModal" tabindex="-1" aria-labelledby="confirmStopModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-sm">
         <div class="modal-content bg-danger text-white">
             <div class="modal-header">
                 <h5 class="modal-title text-white" id="confirmStopModalLabel"><b>Konfirmasi</b></h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 Apakah Anda yakin telah sampai di lokasi dan ingin menghentikan timer?
                 <form id="formConfirmStop">
                     <input type="hidden" name="id_service" id="idServiceConfirm">
                     <input type="hidden" name="latitude" id="latitudeConfirm">
                     <input type="hidden" name="longitude" id="longitudeConfirm">
                     <input type="hidden" name="waktu_perjalanan" id="timeArrifConfirm">
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Batal</button>
                 <button type="button" class="btn btn-light" id="confirmStopButton" data-bs-dismiss="modal">
                     Sampai di lokasi
                 </button>
             </div>
         </div>
     </div>
 </div>
 <!-- Modal -->
 <div class="modal fade" id="addAlatModal" tabindex="-1" aria-labelledby="addAlatModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <form id="alatForm" enctype="multipart/form-data">
                 <div class="modal-header">
                     <h5 class="modal-title" id="addAlatModalLabel">Update Pengerjaan</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <div id="alatInputs">
                         <input type="hidden" name="id_service" id="idServiceTool">
                         <div class="border border-primary p-2 mb-4">
                             <div class="mb-3">
                                 <label>Jenis Kerusakan</label>
                                 <select name="jenis_kerusakan" id="" class="form-select">
                                     <option value="Berat">Berat</option>
                                     <option value="Sedang">Sedang</option>
                                     <option value="Ringan">Ringan</option>
                                 </select>
                             </div>
                             <div class="mb-3">
                                 <label>Foto Hasil Pekerjaan</label>
                                 <input type="file" name="foto_hasil" class="form-control">
                             </div>
                             <div class="mb-3">
                                 <label>Ketarangan</label>
                                 <textarea name="keterangan" class="form-control"></textarea>
                             </div>
                             <div class="mb-3">
                                 <label>Waktu Pengerjaan (jam)</label>
                                 <input type="number" class="form-control" name="waktu_penyelesaian"
                                     value="1">
                             </div>
                         </div>

                         <!-- Input group template -->
                         <div class="row g-3 alat-group">
                             <div class="col-md-6">
                                 <label for="alat" class="form-label">Alat</label>
                                 <input type="text" class="form-control" name="alat[]" placeholder="Nama alat"
                                     required>
                             </div>
                             <div class="col-md-3">
                                 <label for="jumlah" class="form-label">Jumlah</label>
                                 <input type="number" class="form-control" name="jumlah[]" min="1"
                                     value="1" required>
                             </div>
                             <div class="col-md-3">
                                 <label for="jenis" class="form-label">Jenis</label>
                                 <select class="form-select" name="jenis[]" required>
                                     <option value="Penggantian" selected>Penggantian</option>
                                     <option value="Perbaikan">Perbaikan</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                     <button type="button" class="btn btn-link mt-3" id="addMore">+ Tambah Alat</button>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                     <button type="submit" class="btn btn-primary" id="saveToolService">Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
