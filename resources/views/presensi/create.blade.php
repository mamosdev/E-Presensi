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
	</style>
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
			<button id="takeabsen" class="btn btn-primary btn-block">
				<ion-icon name="camera-outline"></ion-icon>
				Absen Masuk
			</button>
		</div>
	</div>
@endsection {{-- End Section Content --}}
@push("myscript")
	<script>
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
		}

		function errorCallback() {

		}
	</script>
@endpush
