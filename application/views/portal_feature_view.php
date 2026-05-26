<?php $this->load->view('templates/header'); ?>

<style>
	.feature-shell {
		max-width: 1320px;
		margin: 22px auto 0;
		display: grid;
		grid-template-columns: minmax(0, 1.75fr) minmax(300px, 0.85fr);
		gap: 22px;
	}

	.feature-hero {
		background: #fff;
		border: 1px solid var(--border);
		border-radius: 18px;
		box-shadow: var(--shadow);
	}

	.feature-hero .panel-body p {
		color: var(--muted);
		line-height: 1.8;
	}

	.feature-stats {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
		gap: 16px;
		margin-top: 18px;
	}

	.feature-list {
		display: grid;
		gap: 16px;
	}

	.feature-list-item {
		padding: 16px;
		border: 1px solid var(--border);
		border-radius: 14px;
		background: #fff;
	}

	.feature-list-item strong {
		display: block;
		margin-bottom: 6px;
		color: #0a2d54;
	}

	.feature-list-item span {
		color: var(--muted);
		line-height: 1.65;
	}

	@media (max-width: 980px) {
		.feature-shell {
			grid-template-columns: 1fr;
		}
	}
</style>

<div class="feature-shell">
	<div>
		<section class="feature-hero">
			<div class="panel-body">
				<h1 style="margin: 0 0 10px; color: #082e57;"><?php echo htmlspecialchars($feature['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
				<p><?php echo htmlspecialchars($feature['description'], ENT_QUOTES, 'UTF-8'); ?></p>
				<div class="hero-actions">
					<a class="btn-light" href="<?php echo site_url('dashboard'); ?>">Kembali ke Beranda</a>
					<a class="btn-outline" href="<?php echo site_url('roles'); ?>">Lihat Role Kampus</a>
				</div>
				<div class="feature-stats">
					<?php foreach ($feature['stats'] as $stat) : ?>
						<div class="stat-card">
							<div class="stat-label"><?php echo htmlspecialchars($stat['label'], ENT_QUOTES, 'UTF-8'); ?></div>
							<div class="stat-value"><?php echo htmlspecialchars((string) $stat['value'], ENT_QUOTES, 'UTF-8'); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<h2 class="section-title">Detail Fitur</h2>
				<div class="feature-list">
					<?php foreach ($feature['list'] as $item) : ?>
						<div class="feature-list-item">
							<strong><?php echo htmlspecialchars(isset($item['title']) ? $item['title'] : $item['tanggal'], ENT_QUOTES, 'UTF-8'); ?></strong>
							<span><?php echo htmlspecialchars(isset($item['meta']) ? $item['meta'] : $item['agenda'], ENT_QUOTES, 'UTF-8'); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>

	<div>
		<section class="panel">
			<div class="panel-body">
				<h2 class="section-title">Kategori</h2>
				<div class="mini-card">
					<strong><?php echo htmlspecialchars($feature['category'], ENT_QUOTES, 'UTF-8'); ?></strong>
					<p>Fitur ini termasuk kelompok layanan yang tampil pada dropdown navigasi portal akademik.</p>
				</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<h2 class="section-title">Informasi Tambahan</h2>
				<div class="mini-list">
					<div class="mini-card">
						<strong>Data Akademik</strong>
						<p>Informasi pada halaman ini sudah terhubung dengan struktur data portal dan siap dilanjutkan sesuai kebutuhan modul.</p>
					</div>
					<div class="mini-card">
						<strong>Hak Akses</strong>
						<p>Akses modul mengikuti akun pengguna yang login agar proses akademik tetap tertata dan sesuai peran.</p>
					</div>
					<div class="mini-card">
						<strong>Pengembangan Modul</strong>
						<p>Form pengajuan, unggah dokumen, dan alur persetujuan dapat ditambahkan bertahap sesuai prioritas implementasi.</p>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<?php $this->load->view('templates/footer'); ?>
