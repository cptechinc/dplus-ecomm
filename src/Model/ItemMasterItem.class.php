<?php
	use ProcessWire\Page;
	use Dplus\ProcessWire\DplusWire;
	
	class ItemMasterItem {
		use \Dplus\Base\ThrowErrorTrait;
		use \Dplus\Base\MagicMethodTraits;
		use \Dplus\Base\CreateFromObjectArrayTraits;
		use \Dplus\Base\CreateClassArrayTraits;

		
        protected $itemid;
        protected $name1;
        protected $name2;
        protected $shortdesc;
        protected $familyid;
        protected $image;
        protected $categoryid;
        protected $tview;
        protected $itemgroup;
		protected $dummy;

		/* =============================================================
		    CRUD FUNCTIONS
		============================================================ */
		public static function load($itemid, $debug = false) {
			return get_item($itemid, $debug);
		}
	}
