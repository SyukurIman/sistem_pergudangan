@include('layouts.style')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- SIDEBAR -->
<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand"><i class='bx bxs-smile icon'></i> Pergudangan</a>
		<ul class="side-menu">
			<li><a href="/admin" class="active"><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
			<li class="divider" data-text="main">Main</li>
			<li>
				<a href="#"><i class='bx bxs-inbox icon' ></i> Master Data <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="/admin/pegawai">Pegawai</a></li>
					<li><a href="/admin/barang">Barang</a></li>
					<li><a href="/rak">Rak</a></li>
					
				</ul>
			</li>
			<li>
				<a href="#"><i class='bx bx-table icon' ></i> transaksi <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="/admin/barang/in">Barang masuk</a></li>
					<li><a href="/admin/barang/out">Barang keluar</a></li>
					
				</ul>
			</li>
			<li>
				<a href="#"><i class='bx bxs-notepad icon' ></i> Jurnal Movement <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="/penempatan">Penempatan</a></li>
					<li><a href="/pemindahan">Pemindahan</a></li>
					
				</ul>
			</li>
		</ul>
		
	</section>
	<!-- SIDEBAR -->

	<!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->
		<nav id="navbar">
			<i class='bx bx-menu toggle-sidebar' ></i>
			<form action="#">
				<div class="form-group">
					{{-- <input type="text" placeholder="Search...">
					<i class='bx bx-search icon' ></i> --}}
				</div>
			</form>
			<span class="divider"></span>
			<div class="profile">
				<img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
				<ul class="profile-link">
					<li><a href="/admin/user"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
					<li><a href="#"><i class='bx bxs-cog' ></i> Settings</a></li>
					<li><a href="/logout"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->

    
    <!-- SCRIPT -->
