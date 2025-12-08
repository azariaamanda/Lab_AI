<?php
// Jika koneksi belum ada, buat koneksi
if (!isset($conn) || !is_resource($conn)) {
    require_once 'koneksi.php';
}

// Ambil data footer dari database
$footer_query = pg_query($conn, "SELECT * FROM footer WHERE id_footer = 1 LIMIT 1");
if ($footer_query && pg_num_rows($footer_query) > 0) {
    $footer = pg_fetch_assoc($footer_query);
} else {
    // Data fallback jika query gagal atau tabel kosong
    $footer = [
        'url_logo' => 'img/logo/logo putih.png',
        'deskripsi_footer' => 'Deskripsi default jika data tidak ditemukan.',
        'jam_kerja' => "Senin – Jumat\n08.00 – 16.00 WIB",
        'email' => 'email@default.com',
        'alamat' => 'Alamat default.',
        'link_maps' => ''
    ];
}

// Ambil data menu dari vw_navbar untuk konsistensi
$footer_nav_query = pg_query($conn, "SELECT nama_navbar, url_nav FROM vw_navbar ORDER BY id_navbar");
$footer_nav_items = [];
if ($footer_nav_query) {
    $footer_nav_items = pg_fetch_all($footer_nav_query);
}
?>
<footer class="footer">
  <div class="footer-top-border"></div>

  <div class="footer-container">
      <div class="footer-col footer-logo">
          <img src="<?php echo htmlspecialchars($footer['url_logo']); ?>" alt="Logo">
          <p><?php echo htmlspecialchars($footer['deskripsi_footer']); ?></p>
      </div>

      <div class="footer-col">
          <h4>MENU</h4>
          <ul>
              <?php if (!empty($footer_nav_items)): ?>
                  <?php foreach ($footer_nav_items as $item): ?>
                      <li><a href="<?php echo htmlspecialchars($item['url_nav']); ?>"><?php echo htmlspecialchars($item['nama_navbar']); ?></a></li>
                  <?php endforeach; ?>
              <?php endif; ?>
          </ul>
      </div>

      <div class="footer-col">
          <h4>LAYANAN</h4>
          <ul>
              <li><a href="layanan.php">Pendaftaran Asisten Lab</a></li>
              <li><a href="layanan.php">Pendaftaran Magang</a></li>
              <li><a href="peminjaman.php">Peminjaman Fasilitas</a></li>
          </ul>
      </div>

      <div class="footer-col">
          <h4>JAM KERJA</h4>
          <ul style="white-space: pre-line;"><?php echo htmlspecialchars($footer['jam_kerja']); ?></ul>
      </div>

      <div class="footer-right">
          <div class="footer-map">
              <iframe src="<?php echo htmlspecialchars($footer['link_maps']); ?>" width="360" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          <p><img src="img/footer/email.png"> <?php echo htmlspecialchars($footer['email']); ?></p>
          <p><img src="img/footer/maps.png"> <?php echo nl2br(htmlspecialchars($footer['alamat'])); ?></p>
      </div>
  </div>

  <div class="footer-bottom-border"></div>

  <div class="footer-bottom">
      Copyright © <?php echo date("Y"); ?> Lab Applied Informatics - Politeknik Negeri Malang. All Rights Reserved.
  </div>
</footer>