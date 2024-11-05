@extends("layouts.layout")

@section("content")
	<div class="section" id="user-section">
		<div id="user-detail">
			<div class="avatar">
				<img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
			</div>
			<div id="user-info">
				<h2 id="user-name">{{ Auth::guard("karyawan")->user()->nama_lengkap }}</h2>
				<span id="user-role">{{ Auth::guard("karyawan")->user()->jabatan }}</span>
			</div>
		</div>
	</div>

	<div class="section" id="menu-section">
		<div class="card">
			<div class="card-body text-center">
				<div class="list-menu">
					<div class="item-menu text-center">
						<div class="menu-icon">
							<a href="" class="green" style="font-size: 40px;">
								<ion-icon name="person-sharp"></ion-icon>
							</a>
						</div>
						<div class="menu-name">
							<span class="text-center">Profil</span>
						</div>
					</div>
					<div class="item-menu text-center">
						<div class="menu-icon">
							<a href="" class="danger" style="font-size: 40px;">
								<ion-icon name="calendar-number"></ion-icon>
							</a>
						</div>
						<div class="menu-name">
							<span class="text-center">Cuti</span>
						</div>
					</div>
					<div class="item-menu text-center">
						<div class="menu-icon">
							<a href="" class="warning" style="font-size: 40px;">
								<ion-icon name="document-text"></ion-icon>
							</a>
						</div>
						<div class="menu-name">
							<span class="text-center">Histori</span>
						</div>
					</div>
					<div class="item-menu text-center">
						<div class="menu-icon">
							<a href="" class="orange" style="font-size: 40px;">
								<ion-icon name="location"></ion-icon>
							</a>
						</div>
						<div class="menu-name">
							Lokasi
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="section mt-2" id="presence-section">
		<div class="todaypresence">
			<div class="row">
				<div class="col-6">
					<div class="card gradasigreen">
						<div class="card-body">
							<div class="presencecontent">
								<div class="iconpresence">
									@if ($presensihariini != null)
										@php
											$path = Storage::url("/uploads/absensi/" . $presensihariini->foto_in);
										@endphp
										<img src="{{ url($path) }}" alt="Image Absen Masuk" class="imaged w64">
									@else
										<ion-icon name="camera"></ion-icon>
									@endif

								</div>
								<div class="presencedetail">
									<h4 class="presencetitle">Masuk</h4>
									<span>{{ $presensihariini != null ? $presensihariini->jam_in : "Belum Absen Masuk" }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="card gradasired">
						<div class="card-body">
							<div class="presencecontent">
								<div class="iconpresence">
									@if ($presensihariini != null && $presensihariini->jam_out != null)
										@php
											$path = Storage::url("/uploads/absensi/" . $presensihariini->foto_out);
										@endphp
										<img src="{{ url($path) }}" alt="Image Absen Masuk" class="imaged w64">
									@else
										<ion-icon name="camera"></ion-icon>
									@endif
								</div>
								<div class="presencedetail">
									<h4 class="presencetitle">Pulang</h4>
									<span>{{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : "Belum Absen Pulang" }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="rekappresensi">
			<h3>Rekap Presensi Bulan {{ $namabulan[$bulanini] }} {{ $tahunini }}</h3>
			<div class="row">
				<div class="col-3">
					<div class="card">
						<div class="card-body !important p-2 text-center">
							<span class="badge bg-danger"
								style="position: absolute; top:3px;right:8px;">{{ $rekappresensi->jumlahhadir }}</span>
							<ion-icon name="accessibility-outline" class="text-primary" style="font-size: 1.6rem"></ion-icon>
							<div>Hadir</div>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="card">
						<div class="card-body !important p-2 text-center">
							<span class="badge bg-danger" style="position: absolute; top:3px;right:8px;">10</span>

							<ion-icon name="newspaper-outline" class="text-success" style="font-size: 1.6rem"></ion-icon>
							<div>Izin</div>

						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="card">
						<div class="card-body !important p-2 text-center">
							<span class="badge bg-danger" style="position: absolute; top:3px;right:8px;">10</span>

							<ion-icon name="medkit-outline" class="text-danger" style="font-size: 1.6rem"></ion-icon>
							<div>Sakit</div>

						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="card">
						<div class="card-body !important p-2 text-center">
							<span class="badge bg-danger"
								style="position: absolute; top:3px;right:8px;">{{ $rekappresensi->jumlahhadir }}</span>

							<ion-icon name="time-outline" class="text-warning" style="font-size: 1.6rem"></ion-icon>
							<div>Terlambat</div>

						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="presencetab mt-2">
			<div class="tab-pane fade show active" id="pilled" role="tabpanel">
				<ul class="nav nav-tabs style1" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#home" role="tab">
							Bulan Ini
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#profile" role="tab">
							Leaderboard
						</a>
					</li>
				</ul>
			</div>

			<div class="tab-content mt-2" style="margin-bottom:100px;">
				<div class="tab-pane fade show active" id="home" role="tabpanel">
					<ul class="listview image-listview">

						@foreach ($historybulanini as $item)
							@php
								$path = Storage::url("uploads/absensi/" . $item->foto_in);
							@endphp
							<li>
								<div class="item">
									<div class="icon-box bg-primary">
										<ion-icon name="finger-print-outline"></ion-icon>
									</div>
									<div class="in">
										<div>{{ date("d-m-Y", strtotime($item->tanggal_presensi)) }}</div>
										<span class="badge badge-success">{{ $item->jam_in }}</span>
										<span
											class="badge badge-danger">{{ $presensihariini != null && $item->jam_out != null ? $item->jam_out : "Belum Absen" }}</span>
									</div>
								</div>
							</li>
						@endforeach

					</ul>
				</div>
				<div class="tab-pane fade" id="profile" role="tabpanel">
					<ul class="listview image-listview">
						@foreach ($leaderboard as $d)
							<li>
								<div class="item">
									<img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
									<div class="in">
										<div>
											<h4>{{ $d->nama_lengkap }}</h4>
											<div class="small">{{ $d->jabatan }}</div>
										</div>
										<span class="badge {{ $d->jam_in < "07:00" ? "bg-success" : "bg-danger" }}">
											{{ $d->jam_in }}
										</span>
									</div>
								</div>
							</li>
						@endforeach
						{{-- <li>
							<div class="item">
								<img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
								<div class="in">
									<div>Emelda Scandroot</div>
									<span class="badge badge-primary">3</span>
								</div>
							</div>
						</li>
						<li>
							<div class="item">
								<img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
								<div class="in">
									<div>Henry Bove</div>
								</div>
							</div>
						</li>
						<li>
							<div class="item">
								<img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
								<div class="in">
									<div>Henry Bove</div>
								</div>
							</div>
						</li>
						<li>
							<div class="item">
								<img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
								<div class="in">
									<div>Henry Bove</div>
								</div>
							</div>
						</li> --}}
					</ul>
				</div>

			</div>
		</div>
	</div>
@endsection
