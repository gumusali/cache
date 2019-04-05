<?php
	class cache {
		# construct
		public function __construct($diff_dir = null) {
			$this->content = "";
			$this->file    = "";
			$this->root    = $_SERVER['DOCUMENT_ROOT'];
			$this->dir     = ($diff_dir) ? $this->root. '/'. trim($diff_dir, '/'). '/' : $this->root. '/files/cache/';
		}

		# start content
		public function begin_cache() {
			# flush old content if exists
			flush();

			# start content
			ob_start();
		}

		# end content
		public function end_cache() {
			# get content
			$this->content = ob_get_contents();

			# flush
			ob_get_clean();
		}

		# cache file
		public function cfile($file = null, $folder = null) {
			if($file == null)
				return false;

			# file
			$this->file = $this->dir. $file;

			if($folder != null)
				$this->file = $this->dir. $folder. '/'. $file;

			return $this;
		}

		# read cache
		public function read() {
			if(file_exists($this->file) && filesize($this->file) != 0)
				return file_get_contents($this->file);

			return false;
		}

		# create cache file
		public function create($cont = null) {
			# content
			if($cont != null)
				$this->content = $cont;

			# create
			$open = fopen($this->file, "w+");
			$wrte = fwrite($open, $this->content);
					fclose($open);

			if($wrte)
				return true;

			return false;
		}

		# clear cache file
		public function clear() {
			# clear
			$clear = unlink($this->file);

			if($clear)
				return true;

			return false;
		}

	}
?>