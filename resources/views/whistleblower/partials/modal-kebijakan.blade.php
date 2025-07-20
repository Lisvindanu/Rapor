{{-- resources/views/whistleblower/partials/modal-kebijakan.blade.php --}}
<!-- Modal Kebijakan Privasi -->
<div class="modal fade" id="kebijakanModal" tabindex="-1" aria-labelledby="kebijakanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kebijakanModalLabel">
                    <i class="fas fa-shield-alt"></i> Kebijakan Privasi PPKPT
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-justify">
                    <h6>1. Pengumpulan Informasi</h6>
                    <p>Satgas PPKPT Universitas Jenderal Achmad Yani mengumpulkan informasi yang Anda berikan secara sukarela melalui formulir pelaporan ini untuk tujuan penanganan kasus kekerasan seksual, diskriminasi, dan perundungan.</p>
                    
                    <h6>2. Penggunaan Informasi</h6>
                    <p>Informasi yang dikumpulkan akan digunakan untuk:</p>
                    <ul>
                        <li>Menindaklanjuti laporan yang Anda sampaikan</li>
                        <li>Melakukan investigasi sesuai prosedur yang berlaku</li>
                        <li>Memberikan dukungan dan bantuan yang diperlukan</li>
                        <li>Mencegah terjadinya kasus serupa di masa mendatang</li>
                    </ul>
                    
                    <h6>3. Kerahasiaan</h6>
                    <p>Kami berkomitmen untuk menjaga kerahasiaan identitas pelapor dan informasi yang diberikan. Akses terhadap informasi dibatasi hanya kepada tim PPKPT yang berwenang.</p>
                    
                    <h6>4. Penyimpanan Data</h6>
                    <p>Data akan disimpan dengan aman dan hanya diakses oleh pihak yang berwenang. Data akan dihapus setelah proses penanganan selesai sesuai dengan ketentuan yang berlaku.</p>
                    
                    <h6>5. Hak Pelapor</h6>
                    <p>Sebagai pelapor, Anda memiliki hak untuk:</p>
                    <ul>
                        <li>Mengetahui perkembangan penanganan laporan</li>
                        <li>Meminta perlindungan dari kemungkinan retaliasi</li>
                        <li>Mendapatkan dukungan psikologis jika diperlukan</li>
                        <li>Mengajukan keberatan atas proses penanganan</li>
                    </ul>
                    
                    <h6>6. Kontak</h6>
                    <p>Jika Anda memiliki pertanyaan mengenai kebijakan privasi ini, silakan hubungi Tim PPKPT Universitas Jenderal Achmad Yani melalui:</p>
                    <ul>
                        <li>Email: ppkpt@unjaya.ac.id</li>
                        <li>Telepon: (022) 123-4567</li>
                        <li>Alamat: Gedung Rektorat Lt. 2, Universitas Jenderal Achmad Yani</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="document.getElementById('persetujuan_kebijakan').checked = true;">
                    <i class="fas fa-check"></i> Saya Setuju
                </button>
            </div>
        </div>
    </div>
</div>