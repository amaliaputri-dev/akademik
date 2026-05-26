<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo isset($page_title) ? $page_title : 'SIAKAD'; ?></title>
	<style>
		:root {
			--bg: #eef3fb;
			--paper: #ffffff;
			--paper-soft: #f7faff;
			--text: #102542;
			--muted: #6b7b93;
			--primary: #0f5492;
			--primary-strong: #0b4478;
			--accent: #2a7de1;
			--border: #dce5f0;
			--shadow: 0 18px 38px rgba(16, 37, 66, 0.08);
		}

		* {
			box-sizing: border-box;
		}

		html {
			scroll-behavior: smooth;
		}

		body {
			margin: 0;
			font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
			color: var(--text);
			background: linear-gradient(180deg, #f6f9fe 0%, var(--bg) 100%);
		}

		a {
			color: inherit;
		}

		.shell {
			max-width: 1640px;
			margin: 0 auto;
			padding: 0 22px 28px;
		}

		.navbar {
			margin: 0 -22px 0;
			padding: 26px 22px 0;
			background:
				linear-gradient(135deg, #0f5492 0%, #0b467a 70%),
				linear-gradient(45deg, rgba(255, 255, 255, 0.06), transparent);
			color: #fff;
			border-bottom: 1px solid rgba(255, 255, 255, 0.12);
		}

		.navbar-inner {
			max-width: 1320px;
			margin: 0 auto;
		}

		.navbar-top {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			justify-content: space-between;
			gap: 18px;
			padding-bottom: 20px;
		}

		.brand-wrap {
			display: flex;
			align-items: center;
			gap: 18px;
		}

		.brand-logo {
			width: 92px;
			height: 92px;
			border-radius: 28px;
			background: rgba(255, 255, 255, 0.96);
			color: var(--primary);
			display: flex;
			align-items: center;
			justify-content: center;
			font-weight: 900;
			font-size: 1.35rem;
			box-shadow: inset 0 0 0 1px rgba(15, 84, 146, 0.08);
		}

		.brand-kicker {
			font-size: 0.95rem;
			color: rgba(255, 255, 255, 0.72);
			font-weight: 500;
		}

		.brand-title {
			font-size: 2rem;
			font-weight: 800;
			color: #fff;
		}

		.brand-subtitle {
			font-size: 0.92rem;
			color: rgba(255, 255, 255, 0.82);
		}

		.portal-nav {
			display: flex;
			flex-wrap: wrap;
			gap: 22px;
			align-items: center;
			padding-top: 14px;
		}

		.nav-item {
			position: relative;
		}

		.nav-link {
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			gap: 8px;
			padding: 14px 8px 16px;
			font-weight: 700;
			color: rgba(255, 255, 255, 0.86);
			border-bottom: 3px solid transparent;
			transition: 0.2s ease;
		}

		.nav-link:hover,
		.nav-link.active {
			color: #fff;
			border-color: #fff;
		}

		.nav-arrow {
			font-size: 0.8rem;
			opacity: 0.85;
		}

		.nav-dropdown {
			position: absolute;
			left: 0;
			top: calc(100% + 10px);
			width: 440px;
			padding: 18px 22px;
			border-radius: 16px;
			background: #0f5492;
			box-shadow: 0 20px 40px rgba(8, 34, 68, 0.24);
			opacity: 0;
			visibility: hidden;
			transform: translateY(10px);
			transition: 0.22s ease;
			z-index: 30;
		}

		.nav-item:hover .nav-dropdown,
		.nav-item:focus-within .nav-dropdown {
			opacity: 1;
			visibility: visible;
			transform: translateY(0);
		}

		.dropdown-heading {
			margin-bottom: 12px;
			font-size: 0.82rem;
			text-transform: uppercase;
			letter-spacing: 0.08em;
			color: rgba(255, 255, 255, 0.72);
			font-weight: 800;
		}

		.dropdown-list {
			display: grid;
			gap: 0;
		}

		.dropdown-item {
			display: grid;
			grid-template-columns: 52px minmax(0, 1fr);
			gap: 12px;
			align-items: center;
			padding: 14px 0;
			text-decoration: none;
			color: #fff;
			border-top: 1px solid rgba(255, 255, 255, 0.10);
		}

		.dropdown-list .dropdown-item:first-child {
			border-top: 0;
		}

		.dropdown-icon {
			width: 40px;
			height: 40px;
			border-radius: 12px;
			background: rgba(255, 255, 255, 0.12);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 0.8rem;
			font-weight: 900;
			letter-spacing: 0.04em;
		}

		.dropdown-item strong {
			display: block;
			font-size: 0.94rem;
			margin-bottom: 3px;
		}

		.dropdown-item span {
			display: block;
			font-size: 0.82rem;
			color: rgba(255, 255, 255, 0.74);
			line-height: 1.55;
		}

		.utility-strip {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			align-items: center;
			gap: 12px;
			max-width: 1320px;
			margin: 18px auto 0;
			padding: 0 2px;
		}

		.utility-text {
			color: var(--muted);
			font-size: 0.94rem;
		}

		.utility-pills {
			display: flex;
			flex-wrap: wrap;
			gap: 10px;
		}

		.utility-pills span {
			padding: 8px 12px;
			border-radius: 999px;
			background: rgba(15, 84, 146, 0.08);
			color: var(--primary);
			font-size: 0.84rem;
			font-weight: 700;
			border: 1px solid rgba(15, 84, 146, 0.12);
		}

		.account-box {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			gap: 10px;
			margin-left: 10px;
		}

		.account-chip {
			padding: 10px 14px;
			border-radius: 999px;
			background: rgba(255, 255, 255, 0.08);
			border: 1px solid rgba(255, 255, 255, 0.14);
			color: #fff;
			font-size: 0.9rem;
			font-weight: 700;
		}

		.account-chip small {
			display: block;
			color: rgba(255, 255, 255, 0.72);
			font-weight: 600;
			font-size: 0.76rem;
			margin-top: 3px;
		}

		.account-action {
			text-decoration: none;
			padding: 10px 14px;
			border-radius: 999px;
			font-weight: 700;
			border: 1px solid rgba(255, 255, 255, 0.18);
			background: rgba(255, 255, 255, 0.12);
			color: #fff;
		}

		.top-icons {
			display: flex;
			align-items: center;
			gap: 18px;
			margin-right: 14px;
		}

		.top-icon {
			position: relative;
			width: 24px;
			height: 24px;
			display: flex;
			align-items: center;
			justify-content: center;
			color: #fff;
			font-size: 1.1rem;
		}

		.top-icon.badged::after {
			content: attr(data-badge);
			position: absolute;
			right: -8px;
			top: -8px;
			min-width: 20px;
			height: 20px;
			padding: 0 5px;
			border-radius: 999px;
			background: #ff861f;
			color: #fff;
			font-size: 0.72rem;
			font-weight: 800;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.layout-grid {
			display: grid;
			grid-template-columns: minmax(0, 1.8fr) minmax(320px, 0.8fr);
			gap: 22px;
			align-items: start;
			max-width: 1320px;
			margin: 22px auto 0;
		}

		.panel {
			background: var(--paper);
			border: 1px solid var(--border);
			border-radius: 18px;
			box-shadow: var(--shadow);
		}

		.panel-body {
			padding: 26px;
		}

		.hero-panel {
			background: var(--paper);
			color: var(--text);
		}

		.hero-panel h1,
		.hero-panel h2 {
			margin: 0 0 12px;
			font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
			line-height: 1.05;
			color: #0d2746;
		}

		.hero-panel p {
			margin: 0;
			line-height: 1.8;
			max-width: 720px;
			color: var(--muted);
		}

		.hero-actions {
			display: flex;
			flex-wrap: wrap;
			gap: 12px;
			margin-top: 22px;
		}

		.hero-actions a {
			text-decoration: none;
			font-weight: 700;
			padding: 11px 16px;
			border-radius: 999px;
		}

		.btn-light {
			background: var(--primary);
			color: #fff;
			border: 1px solid var(--primary);
		}

		.btn-outline {
			border: 1px solid #bcd0e8;
			color: var(--primary);
			background: #fff;
		}

		.stats-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
			gap: 16px;
		}

		.stat-card {
			padding: 18px;
			border-radius: 14px;
			background: var(--paper-soft);
			border: 1px solid var(--border);
		}

		.stat-label {
			font-size: 0.84rem;
			text-transform: uppercase;
			letter-spacing: 0.08em;
			color: var(--muted);
			font-weight: 700;
		}

		.stat-value {
			margin-top: 8px;
			font-size: 2rem;
			font-weight: 800;
			color: var(--primary);
		}

		.stat-note {
			margin-top: 8px;
			color: var(--muted);
			line-height: 1.6;
			font-size: 0.95rem;
		}

		.section-title {
			margin: 0 0 14px;
			font-size: 1.2rem;
			font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
			font-weight: 800;
			color: var(--primary);
		}

		.card-list,
		.mini-list,
		.role-grid {
			display: grid;
			gap: 14px;
		}

		.role-grid {
			grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
		}

		.info-card,
		.mini-card,
		.role-card {
			padding: 18px;
			border-radius: 14px;
			border: 1px solid var(--border);
			background: #fff;
		}

		.info-card strong,
		.mini-card strong,
		.role-card strong {
			display: block;
			margin-bottom: 8px;
			font-size: 1.02rem;
			color: var(--primary);
		}

		.info-card p,
		.mini-card p,
		.role-card p {
			margin: 0;
			color: var(--muted);
			line-height: 1.7;
		}

		.role-meta {
			display: inline-block;
			margin-bottom: 10px;
			padding: 6px 10px;
			border-radius: 999px;
			background: rgba(42, 125, 225, 0.10);
			color: var(--primary);
			font-size: 0.78rem;
			font-weight: 800;
			letter-spacing: 0.04em;
			text-transform: uppercase;
		}

		.link-arrow {
			display: inline-block;
			margin-top: 12px;
			color: var(--primary);
			font-weight: 800;
			text-decoration: none;
		}

		.table-wrap {
			overflow-x: auto;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		th,
		td {
			padding: 14px 12px;
			text-align: left;
			border-bottom: 1px solid var(--border);
		}

		th {
			font-size: 0.8rem;
			text-transform: uppercase;
			letter-spacing: 0.08em;
			color: var(--muted);
			background: #f8fbff;
		}

		tbody tr:hover {
			background: #f8fbff;
		}

		.status-pill {
			display: inline-block;
			padding: 6px 10px;
			border-radius: 999px;
			background: rgba(42, 125, 225, 0.10);
			color: var(--primary);
			font-size: 0.8rem;
			font-weight: 700;
		}

		.alert {
			margin-bottom: 16px;
			padding: 14px 16px;
			border-radius: 14px;
			border: 1px solid rgba(31, 139, 76, 0.18);
			background: rgba(31, 139, 76, 0.10);
			color: #1f8b4c;
			font-weight: 700;
		}

		.form-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
			gap: 14px;
		}

		.field-group label {
			display: block;
			margin-bottom: 8px;
			font-weight: 700;
			color: var(--primary);
		}

		.field-group input {
			width: 100%;
			padding: 12px 14px;
			border-radius: 12px;
			border: 1px solid var(--border);
			background: #fff;
			color: var(--text);
		}

		.form-actions {
			display: flex;
			flex-wrap: wrap;
			gap: 10px;
			margin-top: 18px;
		}

		.btn-danger {
			border: 1px solid rgba(185, 74, 72, 0.18);
			background: rgba(185, 74, 72, 0.10);
			color: #b94a48;
		}

		.timeline {
			display: grid;
			gap: 12px;
		}

		.timeline-item {
			padding: 16px 16px 16px 18px;
			border-left: 4px solid var(--accent);
			border-radius: 14px;
			background: #fff;
			border-top: 1px solid var(--border);
			border-right: 1px solid var(--border);
			border-bottom: 1px solid var(--border);
		}

		.timeline-item strong {
			display: block;
			margin-bottom: 6px;
			color: var(--primary);
		}

		.timeline-item span {
			color: var(--muted);
			font-size: 0.92rem;
		}

		.footer-text {
			margin-top: 22px;
			text-align: center;
			color: var(--muted);
			font-size: 0.92rem;
		}

		@media (max-width: 980px) {
			.layout-grid {
				grid-template-columns: 1fr;
			}
		}

		@media (max-width: 720px) {
			.shell {
				padding: 0 14px 22px;
			}

			.navbar {
				margin: 0 -14px 0;
				padding: 18px 14px 0;
			}

			.portal-nav {
				gap: 14px;
			}

			.nav-dropdown {
				width: min(92vw, 420px);
				left: 0;
			}

			.panel-body {
				padding: 20px;
			}

			.brand-title {
				font-size: 1.4rem;
			}

			.hero-panel h1,
			.hero-panel h2 {
				font-size: 1.6rem;
			}

			.brand-logo {
				width: 72px;
				height: 72px;
				border-radius: 22px;
			}

			.top-icons {
				display: none;
			}
		}
	</style>
</head>
<body>
	<?php
		$role_ui = isset($role_ui) ? $role_ui : array();
		$brand_kicker = isset($role_ui['brand_kicker']) ? $role_ui['brand_kicker'] : 'SIM Akademik';
		$brand_title = isset($role_ui['brand_title']) ? $role_ui['brand_title'] : 'Universitas Bani Saleh';
		$brand_subtitle = isset($role_ui['brand_subtitle']) ? $role_ui['brand_subtitle'] : 'Portal akademik terpadu untuk administrasi, perkuliahan, dan hasil studi';
		$utility_text = isset($role_ui['utility_text']) ? $role_ui['utility_text'] : 'Portal kampus terintegrasi untuk operasional akademik, persetujuan, dan layanan mahasiswa.';
		$utility_pills = isset($role_ui['utility_pills']) ? $role_ui['utility_pills'] : array('Semester Ganjil 2026/2027', 'Portal Akademik');
		$avatar_label = isset($role_ui['avatar_label']) ? $role_ui['avatar_label'] : 'UBS';
	?>
	<div class="shell">
		<nav class="navbar">
			<div class="navbar-inner">
				<div class="navbar-top">
					<div class="brand-wrap">
						<div class="brand-logo"><?php echo htmlspecialchars($avatar_label, ENT_QUOTES, 'UTF-8'); ?></div>
						<div class="brand-block">
							<div class="brand-kicker"><?php echo htmlspecialchars($brand_kicker, ENT_QUOTES, 'UTF-8'); ?></div>
							<div class="brand-title"><?php echo htmlspecialchars($brand_title, ENT_QUOTES, 'UTF-8'); ?></div>
							<div class="brand-subtitle"><?php echo htmlspecialchars($brand_subtitle, ENT_QUOTES, 'UTF-8'); ?></div>
						</div>
					</div>
					<div class="account-box">
						<div class="top-icons">
							<div class="top-icon badged" data-badge="<?php echo isset($notification_count) ? (int) $notification_count : 0; ?>">&#128276;</div>
							<div class="top-icon">&#9638;</div>
						</div>
						<?php if (!empty($current_user)) : ?>
							<div class="account-chip">
								<?php echo htmlspecialchars($current_user['name'], ENT_QUOTES, 'UTF-8'); ?>
								<small><?php echo htmlspecialchars($current_user['role_name'], ENT_QUOTES, 'UTF-8'); ?></small>
							</div>
							<a class="account-action" href="<?php echo site_url('logout'); ?>">Logout</a>
						<?php else : ?>
							<a class="account-action" href="<?php echo site_url('login'); ?>">Login</a>
						<?php endif; ?>
					</div>
				</div>
				<div class="portal-nav">
					<?php $menus = isset($portal_navigation) ? $portal_navigation : $navigation; ?>
					<?php foreach ($menus as $item) : ?>
						<div class="nav-item">
							<a class="nav-link <?php echo (isset($active_menu) && $active_menu === $item['key']) ? 'active' : ''; ?>" href="<?php echo $item['url']; ?>">
								<?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
								<?php if (!empty($item['children'])) : ?>
									<span class="nav-arrow">&#9662;</span>
								<?php endif; ?>
							</a>
							<?php if (!empty($item['children'])) : ?>
								<div class="nav-dropdown">
									<div class="dropdown-heading"><?php echo htmlspecialchars(isset($item['heading']) ? $item['heading'] : $item['label'], ENT_QUOTES, 'UTF-8'); ?></div>
									<div class="dropdown-list">
										<?php foreach ($item['children'] as $child) : ?>
											<a class="dropdown-item" href="<?php echo $child['url']; ?>">
												<div class="dropdown-icon"><?php echo htmlspecialchars($child['icon'], ENT_QUOTES, 'UTF-8'); ?></div>
												<div>
													<strong><?php echo htmlspecialchars($child['label'], ENT_QUOTES, 'UTF-8'); ?></strong>
													<span><?php echo htmlspecialchars($child['description'], ENT_QUOTES, 'UTF-8'); ?></span>
												</div>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</nav>
		<div class="utility-strip">
			<div class="utility-text"><?php echo htmlspecialchars($utility_text, ENT_QUOTES, 'UTF-8'); ?></div>
			<div class="utility-pills">
				<?php foreach ($utility_pills as $pill) : ?>
					<span><?php echo htmlspecialchars($pill, ENT_QUOTES, 'UTF-8'); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
