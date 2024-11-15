@extends("layouts.layout")
@section("header")
	{{-- App Header --}}
	<div class="appHeader bg-primary text-light">
		<div class="left">
			<a href="javascript:;" class="headerButton goBack">
				<ion-icon name="chevron-back-outline"></ion-icon>
			</a>
		</div>
		<div class="pageTitle">History Presensi</div>
		<div class="right"></div>
	</div> {{-- End App Header --}}
@endsection

@section("content")
	<div class="row" style="margin-top: 70px">
		<!-- Kolom Form untuk Bulan dan Tahun -->
		<div class="col">
			{{-- Bulan --}}
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<select name="bulan" id="bulan" class="form-control">
							<option value="">Bulan</option>
							@for ($bulan = 1; $bulan <= 12; $bulan++)
								<option value="{{ $bulan }}" {{ date("m") == $bulan ? "selected" : "" }}>{{ $namabulan[$bulan] }}</option>
							@endfor
						</select>
					</div>
				</div>
			</div> {{-- *End Bulan --}}

			{{-- Tahun --}}
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<select name="tahun" id="tahun" class="form-control">
							<option value="">Tahun</option>
							@php
								$tahunmulai = 2022;
								$tahunsekarang = date("Y");
							@endphp
							@for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)
								<option value="{{ $tahun }}" {{ date("Y") == $tahun ? "selected" : "" }}>{{ $tahun }}</option>
							@endfor
						</select>
					</div>
				</div>
			</div> {{-- *End Tahun --}}

			{{-- Button Submit --}}
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<button class="btn btn-primary btn-block" id="caridata">
							<ion-icon name="search-outline"></ion-icon>Submit
						</button>
					</div>
				</div>
			</div> {{-- *End Button Submit --}}
		</div>

		<!-- Kolom untuk Menampilkan History -->
		<div class="col-12" id="showhistory"></div>
	</div>
@endsection

@push("myscript")
	<script>
		$(function() {
			$('#caridata').click(function(e) {
				var bulan = $("#bulan").val();
				var tahun = $("#tahun").val();
				console.log("Mengirim data:", {
					bulan: bulan,
					tahun: tahun
				});

				$.ajax({
					type: 'POST',
					url: '/gethistory',
					data: {
						_token: "{{ csrf_token() }}",
						bulan: bulan,
						tahun: tahun
					},
					cache: false,
					success: function(respond) {
						$("#showhistory").html(respond);
					},
					error: function(xhr, status, error) {
						console.error("Error detail:", xhr.responseText);
						alert("Terjadi kesalahan saat mengambil data. Silakan coba lagi.");
					}
				});
			});
		});
	</script>
@endpush
