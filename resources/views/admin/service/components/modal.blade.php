<!-- Modal for Create and Edit -->
<div class="modal fade" id="jadwal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleModalLabel">Buat Jadwal Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="scheduleForm" style="display: none;">
                    <input type="hidden" id="serviceId" name="id_service">
                    <!-- Select Teknisi -->
                    <div class="mb-3">
                        <label for="formTeknisi" class="form-label">Teknisi</label>
                        <select class="form-select" id="formTeknisi" name="id_teknisi" required>
                            <option value="" disabled selected>Pilih Teknisi</option>
                            <!-- Contoh loop untuk users -->
                            @foreach (App\Models\User::where('role', 'Teknisi')->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-3">
                        <label for="formTanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="formTanggal" name="tanggal" required>
                    </div>

                    <!-- Waktu -->
                    <div class="mb-3">
                        <label for="formWaktu" class="form-label">Waktu</label>
                        <input type="time" class="form-control" id="formWaktu" name="waktu" required>
                    </div>



                    <!-- Estimasi Biaya -->
                    <div class="mb-3">
                        <label for="formEstimasiBiaya" class="form-label">Estimasi Biaya</label>
                        <input type="number" class="form-control" id="formEstimasiBiaya" name="estimasi_biaya"
                            min="0">
                    </div>

                    <!-- Estimasi Pengerjaan -->
                    <div class="mb-3">
                        <label for="formEstimasiPengerjaan" class="form-label">Estimasi Pengerjaan (jam)</label>
                        <input type="number" class="form-control" id="formEstimasiPengerjaan"
                            name="estimasi_pengerjaan" min="0" value="1">
                    </div>
                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="formKeterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="formKeterangan" name="keterangan" rows="3"></textarea>
                    </div>
                </form>
                <div class="" id="viewSchedule" style="display: none;">
                    tampilkan jadwal
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveScheduleBtn">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="map" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Perbesar modal dengan 'modal-lg' -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Lokasi Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tempat untuk peta -->
                <div id="mapContainer" style="height: 400px;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
