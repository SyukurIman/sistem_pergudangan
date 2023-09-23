@extends('layouts.app')

@section('content')
<div class="info-data">
	
	<div class="card">
		<div class="head">
			<div>
				<h2>{{ $barang }}</h2>
				<p>Barang</p>
			</div>
			<i class='bx bx-trending-down icon down' ></i>
		</div>
	</div>
	<div class="card">
		<div class="head">
			<div>
				<h2>{{ $rak }}</h2>
				<p>Rak</p>
			</div>
			<i class='bx bx-trending-up icon' ></i>
		</div>
	</div>
</div>

<div class="data">
	<div class="content-data">
		<div class="head">
			<h3>Barang Report</h3>
			<div class="menu">
				<i class='bx bx-dots-horizontal-rounded icon'></i>
				<ul class="menu-link">
					<li><a href="#">Edit</a></li>
					<li><a href="#">Save</a></li>
					<li><a href="#">Remove</a></li>
				</ul>
			</div>
		</div>
		<div class="chart">
			<div id="chart"></div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		const barang_masuk = @json($barang_masuk);
		const barang_keluar = @json($barang_keluar);

		
		let data_count_in = [];
		let label_in = []

		let data_count_out = [];
		for (let index = 0; index < barang_masuk.length; index++) {
			data_count_in.push(barang_masuk[index][0])
			label_in.push(barang_masuk[index][1])

			data_count_out.push(barang_keluar[index][0])
		}
		console.log(data_count_in)

		@if($title == 'Dashboard')
			// APEXCHART
			var options = {
				series: [{
					name: 'Barang Masuk',
					data: data_count_in
				}, {
					name: 'Barang Keluar',
					data: data_count_out
				}],
				chart: {
					height: 350,
					type: 'area'
				},
				dataLabels: {
					enabled: false
				},
				stroke: {
					curve: 'smooth'
				},
				xaxis: {
					type: 'string',
					categories: label_in
				},
			};

			var chart = new ApexCharts(document.querySelector("#chart"), options);
			chart.render();
		@endif
	});
</script>
@endsection