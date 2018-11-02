<?php
	class Family {
		use \Dplus\Base\ThrowErrorTrait;
		use \Dplus\Base\MagicMethodTraits;
		use \Dplus\Base\CreateFromObjectArrayTraits;
		use \Dplus\Base\CreateClassArrayTraits;

		protected $famID;
		protected $name1;
		protected $name2;
		protected $name3;
		protected $longdesc;
		protected $image;
		protected $speca;
		protected $specb;
		protected $specc;
		protected $specd;
		protected $spece;
		protected $specf;
		protected $specg;
		protected $spech;
		protected $shortdesc;
		protected $catid;
		protected $tview;
		protected $ftype;
		protected $recno;
		protected $schempic;
		protected $width;
		protected $height;
		protected $name4;
		protected $name5;
		protected $dummy;

		
		/* =============================================================
		    CRUD FUNCTIONS
		============================================================ */
		public static function load($famID, $debug = false) {
			return get_family($famID, $debug);
		}
	}
