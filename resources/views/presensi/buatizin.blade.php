@extends("layouts.layout")
{{-- Calendar --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

@section("header")
	{{-- App Header --}}
	<div class="appHeader bg-primary text-light">
		<div class="left">
			<a href="javascript:;" class="headerButton goBack">
				<ion-icon name="chevron-back-outline"></ion-icon>
			</a>
		</div>
		<div class="pageTitle">Form Izin/Sakit</div>
		<div class="right"></div>
	</div> {{-- End App Header --}}
@endsection

@section("content")
	<!-- php CI model code, convert string to date -->
	<!-- 'tanggal_izin' => date("Y-m-d", strtotime($this->input->post('tanggal_izin'))) -->
	<div class="container" style="margin-top: 70px">
		<div class="col">
			<form action="/presensi/storeizin" class="" method="post" id="formizin">
				<div class="row">
					<div class="col">
						<div class="form-group">
							<input type=text name="tanggal_izin" id="tanggal_izin" class="form-control datepicker" required>
							<label for="tanggal_izin">Tanggal Izin</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="form-group">
							<select name="status" id="status" class="form-control">
								<option value="">Izin / Sakit</option>
								<option value="i">Izin</option>
								<option value="s">Sakit</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="form-group">
							<textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control" placeholder="Keterangan"></textarea>
						</div>
						<div class="form-group">
							<button class="btn btn-primary w-100"> Kirim </button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

@push("myscript")
	<script>
		var currYear = (new Date()).getFullYear();

		$(document).ready(function() {
			$(".datepicker").datepicker({
				defaultDate: new Date(currYear - 0, 1, 31),
				maxDate: new Date(currYear, 11, 31),
				yearRange: [2000, currYear],
				format: "dd-mm-yyyy"
			});

			$("#formizin").submit(function() {
				var tanggal_izin = $("#tanggal_izin").val();
				var status = $("#status").val();
				var keterangan = $("#keterangan").val();

				if (tanggal_izin === "") {
					Swal.fire({
						title: "Oops!",
						text: 'Tanggal Harus Diisi',
						icon: "warning",
					});
					return false;
				} else if (status === "") {
					Swal.fire({
						title: "Oops!",
						text: 'Status Harus Diisi',
						icon: "warning",
					});
					return false;
				} else if (keterangan === "") {
					Swal.fire({
						title: "Oops!",
						text: 'Keterangan Harus Diisi',
						icon: "warning",
					});
					return false;
				}
			});
		});
	</script>
@endpush
