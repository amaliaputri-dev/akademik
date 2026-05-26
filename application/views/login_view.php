<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo isset($page_title) ? $page_title : 'Login SIAKAD'; ?></title>
	<style>
		:root {
			--bg: #eef3fb;
			--paper: #ffffff;
			--paper-soft: #f7faff;
			--text: #102542;
			--muted: #6b7b93;
			--primary: #0f5492;
			--accent: #2a7de1;
			--border: #dce5f0;
			--danger: #b94a48;
			--success: #1f8b4c;
			--shadow: 0 24px 60px rgba(16, 37, 66, 0.12);
		}

		* { box-sizing: border-box; }

		body {
			margin: 0;
			font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
			color: var(--text);
			background: linear-gradient(180deg, #f6f9fe 0%, var(--bg) 100%);
		}

		.page {
			max-width: 1120px;
			margin: 0 auto;
			padding: 36px 20px 44px;
		}

		.layout {
			display: grid;
			grid-template-columns: minmax(0, 1.1fr) minmax(360px, 0.9fr);
			gap: 24px;
			align-items: stretch;
		}

		.panel {
			background: var(--paper);
			border: 1px solid var(--border);
			border-radius: 22px;
			box-shadow: var(--shadow);
			overflow: hidden;
		}

		.hero {
			background:
				linear-gradient(135deg, rgba(15, 84, 146, 0.98), rgba(11, 70, 122, 0.92)),
				linear-gradient(45deg, rgba(255, 255, 255, 0.06), transparent);
			color: #fff;
			padding: 34px;
			height: 100%;
		}

		.brand {
			display: inline-flex;
			align-items: center;
			gap: 14px;
			margin-bottom: 26px;
		}

		.brand-badge {
			width: 64px;
			height: 64px;
			border-radius: 20px;
			background: rgba(255, 255, 255, 0.96);
			color: var(--primary);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 1.15rem;
			font-weight: 900;
		}

		.brand-copy small {
			display: block;
			text-transform: uppercase;
			letter-spacing: 0.16em;
			color: rgba(255, 255, 255, 0.72);
			font-weight: 800;
			margin-bottom: 4px;
		}

		.brand-copy strong {
			font-size: 1.5rem;
		}

		.hero h1 {
			margin: 0 0 14px;
			font-size: 2.8rem;
			line-height: 1.04;
		}

		.hero p {
			margin: 0;
			line-height: 1.85;
			color: rgba(255, 255, 255, 0.86);
			max-width: 540px;
		}

		.info-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
			gap: 14px;
			margin-top: 28px;
		}

		.info-card {
			padding: 16px;
			border-radius: 18px;
			background: rgba(255, 255, 255, 0.08);
			border: 1px solid rgba(255, 255, 255, 0.12);
		}

		.info-card strong {
			display: block;
			margin-bottom: 8px;
		}

		.info-card span {
			font-size: 0.95rem;
			line-height: 1.6;
			color: rgba(255, 255, 255, 0.82);
		}

		.content {
			padding: 30px;
		}

		.back-link {
			display: inline-block;
			margin-bottom: 18px;
			text-decoration: none;
			color: var(--primary);
			font-weight: 700;
		}

		.title {
			margin: 0 0 8px;
			font-size: 1.8rem;
			color: var(--primary);
			font-weight: 800;
		}

		.subtitle {
			margin: 0 0 22px;
			color: var(--muted);
			line-height: 1.7;
		}

		.alert {
			margin-bottom: 16px;
			padding: 14px 16px;
			border-radius: 16px;
			background: rgba(185, 74, 72, 0.10);
			border: 1px solid rgba(185, 74, 72, 0.18);
			color: var(--danger);
			font-weight: 600;
		}

		.alert.success {
			background: rgba(31, 139, 76, 0.10);
			border-color: rgba(31, 139, 76, 0.18);
			color: var(--success);
		}

		.field {
			margin-bottom: 16px;
		}

		.field label {
			display: block;
			margin-bottom: 8px;
			font-weight: 700;
			color: var(--primary);
		}

		.field input {
			width: 100%;
			padding: 14px 16px;
			border-radius: 16px;
			border: 1px solid var(--border);
			background: #fff;
			font-size: 1rem;
			color: var(--text);
		}

		.submit {
			width: 100%;
			border: 0;
			padding: 14px 18px;
			border-radius: 14px;
			background: linear-gradient(135deg, var(--primary), #1668b4);
			color: #fff;
			font-size: 1rem;
			font-weight: 800;
			cursor: pointer;
		}

		.helper {
			margin-top: 14px;
			color: var(--muted);
			font-size: 0.94rem;
			line-height: 1.7;
		}

		.account-list {
			margin-top: 18px;
			padding-top: 18px;
			border-top: 1px solid var(--border);
			display: grid;
			gap: 10px;
		}

		.account-item {
			padding: 12px 14px;
			border-radius: 14px;
			background: var(--paper-soft);
			border: 1px solid var(--border);
			font-size: 0.92rem;
			line-height: 1.6;
		}

		.account-item strong {
			display: block;
			color: var(--primary);
			margin-bottom: 4px;
		}

		@media (max-width: 980px) {
			.layout {
				grid-template-columns: 1fr;
			}

			.hero h1 {
				font-size: 2.2rem;
			}
		}

		@media (max-width: 640px) {
			.page {
				padding: 18px 14px 30px;
			}

			.hero,
			.content {
				padding: 22px;
			}
		}
	</style>
</head>
<body>
	<div class="page">
		<div class="layout">
			<div class="panel">
				<div class="hero">
					<div class="brand">
						<div class="brand-badge">UBS</div>
						<div class="brand-copy">
							<small>Portal Kampus</small>
							<strong>SIAKAD Akademik</strong>
						</div>
					</div>

					<h1>Masuk ke Portal Akademik</h1>
					<p>
						Satu akses untuk layanan kampus yang terintegrasi. Setelah login, sistem akan
						menyesuaikan hak akses dan tampilan berdasarkan akun pengguna yang terdaftar.
					</p>

					<div class="info-grid">
						<div class="info-card">
							<strong>Akademik</strong>
							<span>KRS, jadwal, nilai, dan hasil studi dalam satu sistem.</span>
						</div>
						<div class="info-card">
							<strong>Administrasi</strong>
							<span>Pengelolaan data, layanan kampus, dan monitoring unit kerja.</span>
						</div>
						<div class="info-card">
							<strong>Berjenjang</strong>
							<span>Akses akan mengikuti peran pengguna tanpa perlu memilih role saat login.</span>
						</div>
					</div>
				</div>
			</div>

			<div class="panel">
				<div class="content">
					<a class="back-link" href="<?php echo site_url('dashboard'); ?>">Kembali</a>
					<h2 class="title">Login</h2>
					<p class="subtitle">Masukkan username atau email dan password untuk melanjutkan ke sistem.</p>

					<?php if (!empty($error_message)) : ?>
						<div class="alert"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></div>
					<?php endif; ?>

					<?php if (!empty($success_message)) : ?>
						<div class="alert success"><?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?></div>
					<?php endif; ?>

					<form action="<?php echo site_url('auth/attempt'); ?>" method="post">
						<div class="field">
							<label for="identity">Username / Email</label>
							<input type="text" name="identity" id="identity" value="<?php echo htmlspecialchars((string) $last_identity, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Masukkan username atau email" required>
						</div>

						<div class="field">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" placeholder="Masukkan password" required>
						</div>

						<button type="submit" class="submit">Masuk ke SIAKAD</button>
					</form>

					<p class="helper">
						Jika akses Anda belum tersedia atau mengalami kendala login, hubungi administrator akademik kampus.
					</p>

					<div class="account-list">
						<div class="account-item"><strong>Admin</strong> `admin@kampus.ac.id` / `admin123`</div>
						<div class="account-item"><strong>BAAK</strong> `baak@kampus.ac.id` / `baak123`</div>
						<div class="account-item"><strong>Dekan</strong> `dekan@kampus.ac.id` / `dekan123`</div>
						<div class="account-item"><strong>Wakil Dekan</strong> `wadek@kampus.ac.id` / `wadek123`</div>
						<div class="account-item"><strong>Dosen</strong> `dosen@kampus.ac.id` / `dosen123`</div>
						<div class="account-item"><strong>Mahasiswa</strong> `mahasiswa@kampus.ac.id` / `mahasiswa123`</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
