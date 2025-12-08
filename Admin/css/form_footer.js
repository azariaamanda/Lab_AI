document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('footerForm');
    if (!form) return;

    // Element input
    const urlLogoInput = document.getElementById('url_logo');
    const deskripsiInput = document.getElementById('deskripsi_footer');
    const jamKerjaInput = document.getElementById('jam_kerja');
    const emailInput = document.getElementById('email');
    const alamatInput = document.getElementById('alamat');
    const linkMapsInput = document.getElementById('link_maps');

    // Element preview
    const previewLogo = document.getElementById('previewLogo');
    const previewDeskripsi = document.getElementById('previewDeskripsi');
    const previewJamKerja = document.getElementById('previewJamKerja');
    const previewEmail = document.getElementById('previewEmail');
    const previewAlamat = document.getElementById('previewAlamat');
    const previewMapContainer = document.getElementById('previewMapContainer');

    function updatePreview() {
        // Update Logo
        if (urlLogoInput.value) {
            // Ganti ../ dengan path yang benar untuk preview
            previewLogo.src = urlLogoInput.value.replace('../', '../');
        }

        // Update Teks
        previewDeskripsi.textContent = deskripsiInput.value;
        previewJamKerja.textContent = jamKerjaInput.value;
        previewEmail.textContent = emailInput.value;
        previewAlamat.innerHTML = alamatInput.value.replace(/\n/g, '<br>');

        // Update Peta
        const mapIframe = `<iframe src="${linkMapsInput.value}" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
        previewMapContainer.innerHTML = mapIframe;
    }

    // Tambahkan event listener ke semua input
    form.addEventListener('input', updatePreview);
});
