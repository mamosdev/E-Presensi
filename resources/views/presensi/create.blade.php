@extends("layouts.layout")

{{-- Section Header --}}
@section("header")
	<!-- App Header -->
	<div class="appHeader bg-primary text-light">
		<div class="left">
			<a href="javascript:;" class="headerButton goBack">
				<ion-icon name="chevron-back-outline"></ion-icon>
			</a>
		</div>
		<div class="pageTitle">E-Presensi</div>
		<div class="right"></div>
	</div>
	<!-- * App Header -->

	<style>
		.webcam-capture,
		.webcam-capture video {
			display: inline-block;
			width: 100% !important;
			height: auto !important;
			margin: auto;
			border-radius: 15px;
		}

		#map {
			height: 200px;
		}
	</style>

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
	<!-- Make sure you put this AFTER Leaflet's CSS -->
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection {{-- End Section Header --}}

{{-- Section Content --}}
@section("content")
	<!-- App Capsule -->
	<div id="appCapsule">

		<div class="row" style="margin-top: 70px">
			<div class="col">
				{{-- inputan koordinat lokasi yang otomatis dan disemunyikan --}}
				<input type="hidden" id="lokasi">
				<div class="webcam-capture"></div>
			</div>

		</div>

	</div>
	<!-- * App Capsule -->

	<div class="row">
		<div class="col">
			@if ($cek > 0)
				<button id="takeabsen" class="btn btn-danger btn-block">
					<ion-icon name="camera-outline"></ion-icon>
					Absen Pulang
				</button>
			@else
				<button id="takeabsen" class="btn btn-primary btn-block">
					<ion-icon name="camera-outline"></ion-icon>
					Absen Masuk
				</button>
			@endif
		</div>
	</div>
	<div class="row mt-2">
		<div class="col">
			<div id="map"></div>
		</div>
	</div>

	<audio id="notifikasi_masuk">
		<source src="{{ asset("assets/sound/notifikasi_masuk.mp3") }}" type="audio/mpeg">
	</audio>
	<audio id="notifikasi_pulang">
		<source src="{{ asset("assets/sound/notifikasi_pulang.mp3") }}" type="audio/mpeg">
	</audio>
	<audio id="notifikasi_radius">
		<source src="{{ asset("assets/sound/notifikasi_diluar_radius.mp3") }}" type="audio/mpeg">
	</audio>
@endsection {{-- End Section Content --}}

@push("myscript")
	<script>
		var notifikasi_masuk = document.getElementById('notifikasi_masuk');
		var notifikasi_pulang = document.getElementById('notifikasi_pulang');
		var notifikasi_radius = document.getElementById('notifikasi_radius');



		Webcam.set({
			height: 480,
			width: 640,
			image_format: 'jpeg',
			jpeg_quality: 80
		})

		Webcam.attach('.webcam-capture');

		var lokasi = document.getElementById('lokasi');
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
		}

		function successCallback(position) {
			lokasi.value = position.coords.latitude + ',' +
				position.coords.longitude;
			var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);

			L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
			}).addTo(map);

			var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

			var circle = L.circle([-7.540059309844185, 110.82576449824755], {
				color: 'green',
				fillColor: '#f03',
				fillOpacity: 0.5,
				radius: 200
			}).addTo(map);

		}

		function errorCallback() {

		}

		// Event ketika tombol absen diklik
		$("#takeabsen").click(function(e) {

			e.preventDefault(); // Cegah reload halaman
			Webcam.snap(function(uri) {
				image = uri;
			});
			var lokasi = $('#lokasi').val();
			$.ajax({
				type: "POST",
				url: "/presensi/store",
				data: {
					_token: "{{ csrf_token() }}",
					image: image,
					lokasi: lokasi

				},
				cache: false,
				success: function(respond) {
					var status = respond.split("|");
					if (status[0] == "Success") {
						if (status[2] == "in") {
							notifikasi_masuk.play();
						} else {
							notifikasi_pulang.play();
						}
						Swal.fire({
							title: "Absensi Berhasil!",
							text: status[1],
							icon: "success",
							// confirmButton: 'OK'
						})
						setTimeout("location.href='/dashboard'", 3000);
					} else {
						if (status[2] == "radius") {
							notifikasi_radius.play();
						}
						Swal.fire({
							title: 'Error!',
							text: status[1],
							icon: 'error',
						})
					}
				},
				error: function(xhr) {
					alert('Error: ' + xhr.responseText);
				}
			});
		});
	</script>
@endpush
