@extends('template/template')

@section('nav')
	@include('welcome/nav')
@endsection

@section('content')
	<div class="row">
	  <div class="col-md-12">
	    <div class="tile">
	      <h3 class="tile-title">Grafik Data Perusahaan dan Tenaga Kerja</h3>

	      <div class="form-group">
            <label class="control-label">Kabupaten</label>
            <select class="form-control select2" name="kab_id" id="kab_id">
    		<option value="0">Semua</option>
            	@foreach ($kabupaten as $item)
            		<option value="{{ $item->id }}">{{ ucwords(strtolower($item->nama_kab)) }}</option>
            	@endforeach
            </select>
          </div>
	      
	      <div class="embed-responsive embed-responsive-16by9">
	        <canvas class="embed-responsive-item" id="satu"></canvas>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="row">
	  <div class="col-md-12">
	    <div class="tile">
	      <h3 class="tile-title">Grafik Data Perusahaan dan Tenaga Kerja per Kecamatan</h3>

	      <div class="form-group">
            <label class="control-label">Kabupaten</label>
            <select class="form-control select2" name="kab_id_dua" id="kab_id_dua">
            	@foreach ($kabupaten as $item)
            		<option value="{{ $item->id }}">{{ ucwords(strtolower($item->nama_kab)) }}</option>
            	@endforeach
            </select>
          </div>

          <div class="form-group">
            <label class="control-label">Tahun</label>
    		<input class="form-control" required type="number" min="1900" max="2900" name="tahun_dua" id="tahun_dua" value="{{ date('Y') - 1 }}">
          </div>
	      
	      <div class="form-group">
        	<a href="#" onclick="exportpdf()" class="btn btn-success">Export PDF</a>
        	<a href="#" onclick="exportpdfall()" class="btn btn-success">Export PDF Semua Kabupaten</a>
          </div>
	      
	    </div>
	  </div>
	</div>

	<div class="row">
	  <div class="col-md-6">
	    <div class="tile">
	      <h3 class="tile-title">Grafik Data Perusahaan per Kecamatan</h3>
	    	<div class="embed-responsive embed-responsive-16by9" id="div_dua">
	        	<canvas class="embed-responsive-item" id="dua"></canvas>
	      	</div>
	    </div>
	  </div>
	  <div class="col-md-6">
	    <div class="tile">
	      <h3 class="tile-title">Grafik Data Tenaga Kerja per Kecamatan</h3>
	    	<div class="embed-responsive embed-responsive-16by9">
	        	<canvas class="embed-responsive-item" id="dua_juga"></canvas>
	      	</div>
	    </div>
	  </div>
	</div>
@endsection

@section('js')
	<script type="text/javascript">
		$(".select2").select2();

		function exportpdf() {
			var url = "{{ action('WelcomeController@index') }}/";
			window.open(url + 'pdf/' + $("#kab_id_dua").val() + '/' + $("#tahun_dua").val());
		}

		function exportpdfall() {
			var url = "{{ action('WelcomeController@index') }}/";
			window.open(url + 'pdfall/' + $("#tahun_dua").val());
		}
	</script>

	<script type="text/javascript">
		var lineChart;

		@if(session('level') != 'a')
		$("#kab_id").val('{{ session('kab_id') }}');
		$('.select2').select2();
		$("#kab_id").prop('disabled', true);
		@endif
		ajaxTampilDataChart1Data();

		$("#kab_id").change(function() {
			ajaxTampilDataChart1Data();			
		});

		function ajaxTampilDataChart1Data() {
			$.get("{{ action('WelcomeController@index') }}/ajaxchart1/" + $("#kab_id").val(), function(data) {
				try {
					lineChart.destroy();
				} catch {}
				tampilChart1Data(JSON.parse(data));
			});	
		}

		function tampilChart1Data(data) {
			var ctxl = $("#satu").get(0).getContext("2d");
			lineChart = new Chart(ctxl).Line(data, {
			   responsive : true,
			   animation: true,
			   barValueSpacing : 5,
			   barDatasetSpacing : 1,
			   tooltipFillColor: "rgba(0,0,0,0.8)",                
			   multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
			});
		}
	</script>

	<script type="text/javascript">
		var pieChart1;
		var pieChart2;

		@if(session('level') != 'a')
		$("#kab_id_dua").val('{{ session('kab_id') }}');
		$('.select2').select2();
		$("#kab_id_dua").prop('disabled', true);
		@endif
		ajaxTampilDataChart2Data();
		ajaxTampilDataChart2Data2();

		$("#kab_id_dua").change(function() {
			ajaxTampilDataChart2Data();
			ajaxTampilDataChart2Data2();
		});

		$("#tahun_dua").on("keyup paste change", function() {
		    ajaxTampilDataChart2Data();
		    ajaxTampilDataChart2Data2();
		});

		function ajaxTampilDataChart2Data() {
			$.get("{{ action('WelcomeController@index') }}/ajaxchart11/" + $("#kab_id_dua").val() + '/' + $("#tahun_dua").val(), function(data) {
				try {
					pieChart1.destroy();
				} catch {}
				var ctxp = $("#dua").get(0).getContext("2d");
				pieChart1 = new Chart(ctxp).Pie(JSON.parse(data));
			});
		}

		function ajaxTampilDataChart2Data2() {
			$.get("{{ action('WelcomeController@index') }}/ajaxchart12/" + $("#kab_id_dua").val() + '/' + $("#tahun_dua").val(), function(data) {
				try {
					pieChart2.destroy();
				} catch {}
				var ctxp = $("#dua_juga").get(0).getContext("2d");
				pieChart2 = new Chart(ctxp).Pie(JSON.parse(data));
			});
		}
	</script>
@endsection