document.addEventListener("DOMContentLoaded", function () {
  AOS.init({
    duration: 850,
    once: true,
  });

  document.querySelectorAll(".nav-link").forEach((link) => {
    link.addEventListener("click", () => {
      const nav = document.querySelector(".navbar-collapse");
      if (nav && nav.classList.contains("show")) {
        bootstrap.Collapse.getOrCreateInstance(nav).hide();
      }
    });
  });

  const newsSection = document.getElementById("berita");
  const newsTriggers = document.querySelectorAll(".news-trigger, .news-trigger-link");

  function tampilkanBerita(event) {
    if (event) event.preventDefault();
    if (!newsSection) return;

    newsSection.classList.remove("d-none");

    requestAnimationFrame(() => {
      const offset = 88;
      const top = newsSection.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top, behavior: "smooth" });
      if (window.AOS) AOS.refresh();
    });
  }

  newsTriggers.forEach((trigger) => {
    trigger.addEventListener("click", tampilkanBerita);
  });

  const dataBerita = {
    1: {
      judul: "Donor Darah Bersama Mahasiswa UNPAS",
      tanggal: "9 Desember 2025",
      date: "2025-12-09",
      gambar: "assets/img/berita1.jpg",
      ringkasan: "Kegiatan donor darah sebagai bentuk kepedulian sosial.",
      konten: `
        <p>Bandung. KSR PMI Unit Universitas Pasundan kembali menyelenggarakan kegiatan Donor Darah Sukarela sebagai bentuk nyata kepedulian terhadap sesama dan dukungan terhadap ketersediaan stok darah di Palang Merah Indonesia (PMI).</p>
        <p>Kegiatan ini dilaksanakan di lingkungan Universitas Pasundan dan diikuti oleh mahasiswa, civitas akademika, serta masyarakat umum. Antusiasme peserta terlihat dari tingginya jumlah pendaftar yang secara sukarela mendonorkan darahnya demi membantu pasien yang membutuhkan.</p>
        <p>Ketua KSR PMI Unit Universitas Pasundan menyampaikan bahwa kegiatan donor darah ini merupakan agenda rutin yang bertujuan untuk menumbuhkan rasa kemanusiaan, solidaritas, dan kepedulian sosial di kalangan generasi muda. Selain itu, kegiatan ini juga menjadi bagian dari upaya mendukung program kemanusiaan PMI dalam menjaga ketersediaan darah yang aman dan cukup.</p>
        <p>Pelaksanaan donor darah dilakukan dengan tetap memperhatikan standar kesehatan dan keselamatan, bekerja sama dengan PMI setempat. Setiap pendonor menjalani pemeriksaan kesehatan terlebih dahulu sebelum proses pengambilan darah dilakukan oleh tenaga medis profesional.</p>
        <p>Melalui kegiatan Donor Darah Sukarela ini, KSR PMI Unit Universitas Pasundan berharap dapat memberikan manfaat nyata bagi masyarakat serta mengajak lebih banyak pihak untuk berpartisipasi dalam aksi kemanusiaan.</p>
      `,
    },
    2: {
      judul: "KSR PMI UNPAS Gelar Pelatihan Vertical Rescue untuk Meningkatkan Keterampilan Relawan",
      tanggal: "17 Februari 2025",
      date: "2025-02-17",
      gambar: "assets/berita2.jpg",
      ringkasan: "Pelatihan untuk meningkatkan kompetensi relawan baru.",
      konten: `
        <p>Bandung. KSR PMI Unit Universitas Pasundan melaksanakan kegiatan Pelatihan Vertical Rescue sebagai bagian dari upaya meningkatkan pengetahuan, keterampilan, dan kesiapsiagaan relawan dalam menghadapi situasi darurat pada medan vertikal.</p>
        <p>Kegiatan ini memberikan pembekalan kepada para peserta mengenai dasar-dasar penyelamatan pada medan dengan perbedaan ketinggian. Para relawan mendapatkan materi mengenai keselamatan dalam kegiatan vertical rescue, penggunaan peralatan pendukung, teknik dasar evakuasi, serta prosedur yang perlu diperhatikan selama proses penyelamatan.</p>
        <p>Selain pembekalan materi, peserta juga mengikuti praktik secara langsung. Melalui kegiatan praktik, para relawan dilatih untuk memahami penggunaan perlengkapan dan menerapkan teknik penyelamatan secara terarah dengan tetap memperhatikan keselamatan diri, korban, dan anggota tim.</p>
        <p>Pelatihan Vertical Rescue menjadi salah satu bentuk pengembangan kapasitas relawan KSR PMI UNPAS dalam menghadapi berbagai kondisi kebencanaan dan keadaan darurat. Keterampilan tersebut diharapkan dapat menjadi bekal bagi para relawan ketika menjalankan tugas kemanusiaan di lapangan.</p>
        <p>Kegiatan ini juga menjadi bagian dari komitmen KSR PMI UNPAS untuk terus meningkatkan kemampuan relawan melalui pelatihan dan simulasi. Dengan adanya pelatihan secara berkala, diharapkan para relawan semakin memahami pentingnya kerja sama tim, komunikasi, ketelitian, dan prosedur keselamatan.</p>
      `,
    },
    3: {
      judul: "KSR PMI Unit Universitas Pasundan Turun Membantu Penanganan Bencana Longsor di Cisarua",
      tanggal: "30 Januari 2026",
      date: "2026-01-30",
      gambar: "assets/berita3.jpeg",
      ringkasan: "Relawan diterjunkan untuk membantu masyarakat terdampak bencana.",
      konten: `
        <p>Cisarua. KSR PMI Unit Universitas Pasundan turut mengambil bagian dalam upaya kemanusiaan untuk membantu masyarakat yang terdampak bencana tanah longsor di wilayah Cisarua. Kegiatan ini menjadi salah satu bentuk kepedulian dan komitmen relawan mahasiswa KSR PMI UNPAS dalam membantu masyarakat ketika terjadi kondisi darurat.</p>
        <p>Sesampainya di lokasi, para relawan berkoordinasi dengan pihak terkait serta melakukan peninjauan terhadap kondisi lingkungan dan kebutuhan masyarakat yang terdampak. Dalam situasi bencana, koordinasi menjadi bagian penting agar bantuan dan pelayanan yang diberikan dapat berjalan dengan tertib serta sesuai dengan kondisi di lapangan.</p>
        <p>Kehadiran KSR PMI UNPAS tidak hanya menjadi bentuk bantuan secara langsung, tetapi juga merupakan wujud nyata semangat kerelawanan dan pengabdian kepada masyarakat. Para relawan berupaya membantu sesuai dengan kemampuan dan tugas yang diberikan, sekaligus tetap memperhatikan keselamatan selama berada di area terdampak bencana.</p>
        <p>Bencana longsor menjadi pengingat bahwa kesiapsiagaan dan kepedulian terhadap sesama sangat dibutuhkan, terutama ketika masyarakat menghadapi kondisi darurat.</p>
      `,
    },
    4: {
      judul: "KSR PMI UNPAS Gelar Pelatihan Water Rescue untuk Meningkatkan Kesiapsiagaan Relawan",
      tanggal: "30 Mei 2026",
      date: "2026-05-30",
      gambar: "assets/berita4.jpeg",
      ringkasan: "Pelatihan untuk meningkatkan keterampilan dan kesiapsiagaan relawan dalam menghadapi kondisi darurat di lingkungan perairan.",
      konten: `
        <p>Bandung. KSR PMI Unit Universitas Pasundan melaksanakan kegiatan Pelatihan Water Rescue sebagai bagian dari upaya meningkatkan pengetahuan, keterampilan, dan kesiapsiagaan relawan dalam menghadapi kondisi darurat di lingkungan perairan.</p>
        <p>Kegiatan ini memberikan pembekalan kepada para peserta mengenai dasar-dasar pertolongan dan penyelamatan di air. Para relawan mendapatkan materi yang berkaitan dengan keselamatan diri, teknik penyelamatan korban, penggunaan peralatan pendukung, serta langkah-langkah ketika menghadapi keadaan darurat di wilayah perairan.</p>
        <p>Selain mendapatkan materi, peserta juga mengikuti kegiatan praktik secara langsung. Praktik bertujuan agar para relawan tidak hanya memahami teori, tetapi juga mampu menerapkan teknik penyelamatan dengan memperhatikan prosedur keselamatan dan kondisi di lapangan.</p>
        <p>Pelatihan Water Rescue menjadi salah satu bentuk pengembangan kapasitas relawan KSR PMI UNPAS dalam menghadapi berbagai situasi kebencanaan.</p>
      `,
    },
    5: {
      judul: "KSR PMI UNPAS Siagakan Pos Medis dalam Aksi Demonstrasi Mahasiswa",
      tanggal: "29 Agustus 2025",
      date: "2025-08-29",
      gambar: "assets/berita5.jpeg",
      ringkasan: "KSR PMI UNPAS menyiagakan Pos Medis untuk dukungan pertolongan pertama dan kesiapsiagaan kesehatan.",
      konten: `
        <p>Bandung. KSR PMI Unit Universitas Pasundan turut berperan dalam kegiatan kemanusiaan dengan menyiagakan Pos Medis selama berlangsungnya aksi demonstrasi mahasiswa di lingkungan Universitas Pasundan dan sekitarnya. Pos medis disiapkan sebagai bentuk kesiapsiagaan untuk memberikan pertolongan pertama kepada peserta aksi maupun masyarakat yang membutuhkan bantuan kesehatan.</p>
        <p>Dalam pelaksanaannya, para relawan KSR PMI UNPAS melakukan pemantauan kondisi kesehatan di sekitar lokasi kegiatan serta bersiap memberikan penanganan awal apabila terdapat peserta yang mengalami keluhan kesehatan atau membutuhkan pertolongan.</p>
        <p>Keberadaan Pos Medis menjadi bagian penting dalam mendukung aspek keselamatan selama kegiatan berlangsung. Para relawan menjalankan tugas dengan mengutamakan prinsip kemanusiaan, keselamatan, serta pelayanan kesehatan tanpa membedakan latar belakang maupun pandangan peserta yang berada di lokasi.</p>
        <p>Bagi KSR PMI UNPAS, keterlibatan dalam Pos Medis merupakan bagian dari pengabdian dan penerapan keterampilan kerelawanan yang telah diperoleh melalui berbagai kegiatan pelatihan.</p>
      `,
    },
    6: {
      judul: "KSR PMI UNPAS Turun Membantu Penanganan Bencana Banjir di Bojongsoang",
      tanggal: "5 Desember 2025",
      date: "2025-12-05",
      gambar: "assets/berita6.jpg",
      ringkasan: "KSR PMI UNPAS turut membantu masyarakat terdampak banjir di Bojongsoang.",
      konten: `
        <p>Bojongsoang. KSR PMI Unit Universitas Pasundan turut turun ke lokasi terdampak bencana banjir di wilayah Bojongsoang, Kabupaten Bandung, pada 5 Desember 2025. Kehadiran para relawan merupakan bentuk kepedulian dan komitmen KSR PMI UNPAS dalam membantu masyarakat yang terdampak bencana.</p>
        <p>Banjir yang melanda sejumlah wilayah Kabupaten Bandung terjadi setelah hujan dengan intensitas tinggi. Bojongsoang menjadi salah satu wilayah yang terdampak. Dalam kegiatan tanggap darurat tersebut, relawan berupaya membantu sesuai dengan kebutuhan dan kondisi di lapangan.</p>
        <p>Para relawan turut melakukan pemantauan situasi, berkoordinasi dengan pihak terkait, serta memberikan dukungan kemanusiaan kepada masyarakat yang terdampak.</p>
        <p>Kegiatan ini menjadi salah satu bentuk penerapan keterampilan dan kesiapsiagaan yang telah diperoleh para relawan melalui berbagai pelatihan kebencanaan.</p>
      `,
    },
    7: {
      judul: "KSR PMI UNPAS Peringati Hari Anti Narkotika Internasional",
      tanggal: "26 Juni 2026",
      date: "2026-06-26",
      gambar: "assets/berita7.jpeg",
      ringkasan: "Ajakan untuk meningkatkan kesadaran mengenai bahaya penyalahgunaan narkotika dan pentingnya menjaga kesehatan.",
      konten: `
        <p>Bandung. Dalam rangka memperingati Hari Anti Narkotika Internasional (HANI), KSR PMI Unit Universitas Pasundan turut mengajak mahasiswa dan masyarakat untuk meningkatkan kesadaran mengenai pentingnya menjauhi penyalahgunaan narkotika serta menerapkan pola hidup sehat.</p>
        <p>Peringatan HANI menjadi momentum untuk meningkatkan pemahaman mengenai dampak penyalahgunaan narkotika, baik terhadap kesehatan, kehidupan sosial, pendidikan, maupun masa depan generasi muda.</p>
        <p>Melalui semangat kepalangmerahan dan kemanusiaan, KSR PMI UNPAS mendorong pentingnya membangun kesadaran sejak dini, berani mengatakan tidak terhadap penyalahgunaan narkotika, serta saling mengingatkan dan memberikan dukungan kepada sesama.</p>
        <p>Momentum Hari Anti Narkotika Internasional juga menjadi pengingat bahwa menjaga kesehatan merupakan bagian dari kepedulian terhadap diri sendiri dan orang lain.</p>
      `,
    },
  };

  const containerBerita = document.getElementById("daftarBerita");
  const sortBerita = document.getElementById("sortBerita");
  const detailModalElement = document.getElementById("detailBeritaModal");
  const detailModal = detailModalElement ? new bootstrap.Modal(detailModalElement) : null;

  function renderBerita(list) {
    if (!containerBerita) return;

    containerBerita.innerHTML = list
      .map((berita, index) => `
        <div class="col-md-6 col-xl-4 berita-item" data-date="${berita.date}" data-aos="fade-up" data-aos-delay="${(index % 3) * 100}">
          <article class="news-card h-100 shadow-sm">
            <img src="${berita.gambar}" class="card-img-top" alt="${escapeHtml(berita.judul)}" />
            <div class="card-body d-flex flex-column p-4">
              <small class="text-muted">${berita.tanggal}</small>
              <h5 class="mt-2">${escapeHtml(berita.judul)}</h5>
              <p class="text-muted">${escapeHtml(berita.ringkasan)}</p>
              <button type="button" class="btn btn-danger btn-sm mt-auto align-self-start" data-news-id="${Object.keys(dataBerita).find((key) => dataBerita[key] === berita)}">
                Baca Selengkapnya
              </button>
            </div>
          </article>
        </div>
      `)
      .join("");

    containerBerita.querySelectorAll("[data-news-id]").forEach((button) => {
      button.addEventListener("click", () => bukaDetail(button.dataset.newsId));
    });

    if (window.AOS) AOS.refresh();
  }

  function bukaDetail(id) {
    const berita = dataBerita[id];
    if (!berita || !detailModal) return;

    document.getElementById("detailBeritaModalLabel").textContent = berita.judul;
    document.getElementById("detailTanggal").textContent = berita.tanggal;
    document.getElementById("detailGambar").src = berita.gambar;
    document.getElementById("detailGambar").alt = berita.judul;
    document.getElementById("detailKonten").innerHTML = berita.konten;
    detailModal.show();
  }

  function escapeHtml(value) {
    return value.replace(/[&<>'"]/g, (char) => ({
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      "'": "&#39;",
      '"': "&quot;",
    }[char]));
  }

  function getNewsList() {
    return Object.values(dataBerita);
  }

  if (containerBerita) {
    renderBerita(getNewsList());
  }

  if (sortBerita) {
    sortBerita.addEventListener("change", function () {
      const berita = getNewsList();

      if (this.value === "terbaru") {
        berita.sort((a, b) => new Date(b.date) - new Date(a.date));
      } else if (this.value === "terlama") {
        berita.sort((a, b) => new Date(a.date) - new Date(b.date));
      }

      renderBerita(berita);
    });
  }

  window.hideBerita = function () {
    if (newsSection) {
      newsSection.classList.add("d-none");

      const kegiatanSection = document.getElementById("kegiatan");

      if (kegiatanSection) {
        kegiatanSection.scrollIntoView({
          behavior: "smooth",
          block: "start"
        });
      }
    }
  };

  const strukturTriggers = document.querySelectorAll(".struktur-trigger");
  const strukturModalElement = document.getElementById("strukturModal");

  const strukturModal = strukturModalElement
    ? new bootstrap.Modal(strukturModalElement)
    : null;

  strukturTriggers.forEach((foto) => {
    foto.addEventListener("click", function () {

      const nama = this.dataset.nama;
      const jabatan = this.dataset.jabatan;
      const gambar = this.getAttribute("src");

      document.getElementById("strukturModalNama").textContent = nama;

      document.getElementById("strukturModalJabatan").textContent = jabatan;

      const modalFoto = document.getElementById("strukturModalFoto");

      modalFoto.src = gambar;
      modalFoto.alt = nama;

      strukturModal.show();
    });
  });

    window.addEventListener("load", function () {
    if ("scrollRestoration" in history) {
      history.scrollRestoration = "manual";
    }

    if (newsSection) {
      newsSection.classList.add("d-none");
    }

    window.scrollTo({
      top: 0,
      behavior: "instant"
    });

    history.replaceState(null, null, "#beranda");
  });

  let lastScrollTop = 0;
  const navbar = document.querySelector(".navbar");

  window.addEventListener("scroll", () => {
    const currentScroll = window.scrollY;

    if (currentScroll > lastScrollTop && currentScroll > 100) {
      // Scroll ke bawah
      navbar.classList.add("hide");
    } else {
      // Scroll ke atas
      navbar.classList.remove("hide");
    }

    lastScrollTop = currentScroll;
  });

});
