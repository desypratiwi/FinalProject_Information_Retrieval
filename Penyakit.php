<?php
	class Penyakit{
		public $id_penyakit=-1;
		public $judul='';
		public $deskripsi = '';
		public $deskripsi_text = '';
		public $penyakit = '';
		public $url_page = '';
		public $url_page_ori = '';
		public $slug = '';
                public function __construct($id,$judul,$desc,$desc_text,$penyakit,$page,$url_ori,$slug) {
                    $this->id_penyakit = $id;
                    $this->judul = $judul;
                    $this->deskripsi = $desc;
                    $this->deskripsi_text = $desc_text;
                    $this->penyakit = $penyakit;
                    $this->url_page = $page;
                    $this->url_page_ori = $url_ori;
                    $this->slug = $slug;;
                }
	}
?>