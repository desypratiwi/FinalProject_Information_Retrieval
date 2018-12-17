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
                public $banyak_word=-1;
                public $list_word_count;
                public $words;
                public function __construct($id,$judul,$desc,$desc_text,$penyakit,$page,$url_ori,$slug,$banyak_word,$l_word_count,$words) {
                    $this->id_penyakit = $id;
                    $this->judul = $judul;
                    $this->deskripsi = $desc;
                    $this->deskripsi_text = $desc_text;
                    $this->penyakit = $penyakit;
                    $this->url_page = $page;
                    $this->url_page_ori = $url_ori;
                    $this->slug = $slug;
                    $this->banyak_word= $banyak_word;
                    $this->list_word_count = $l_word_count;
                    $this->words = $words;
                }
	}
?>