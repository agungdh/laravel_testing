<?php

if (!function_exists('DummyFunction')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function DummyFunction()
    {

    }
}

if (!function_exists('tanggalIndo')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function tanggalIndo($tanggal)
    {
    	return date("d-m-Y", strtotime($tanggal));
    }
}

if (!function_exists('tanggalWaktuIndo')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function tanggalWaktuIndo($tanggal_waktu)
    {
    	return date("d-m-Y H:i:s", strtotime($tanggal_waktu));
    }
}

if (!function_exists('tanggalIndoString')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function tanggalIndoString($tanggal)
    {
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
     
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
}

if (!function_exists('tanggalIndoStringBulanTahun')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function tanggalIndoStringBulanTahun($bulan_tahun)
    {
    	$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $bulan_tahun);
     
        return $bulan[ (int)$pecahkan[0] ] . ' ' . $pecahkan[1];
    }
}
