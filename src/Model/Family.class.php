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

		/**
		 * Imports a family record from the database and makes a page in Processwire
		 * @param  string $parentcode Code to be parsed for parent page
		 * @return bool               Was Family Created / Updated
		 */
        public function import_family($parentcode = '') {
            $p = DplusWire::wire('pages')->get("template=family, famID=$this->famID");

			if (get_class($p) == 'ProcessWire\Page') {
				$p->of(false);
				return $this->update_page($p);
			} else {
				return $this->create_page();
			}
        }

		/* =============================================================
		    FAMILY PAGE FUNCTIONS
		============================================================ */
		public function update_page(Page $p, $parentcode = '') {
			// $p->parent = wire('pages')->get('/about/'); // set the parent
			$p->title = $this->name1;
			$p->famID = $this->famID;
			$p->names2 = $this->name2;
			$p->name3 = $this->name3;
			$p->imagetext = "image of $this->name1";
			$p->longdesc = $this->longdesc;
			$p->speca = $this->speca;
			$p->specb = $this->specb;
			$p->specc = $this->specc;
			$p->specd = $this->specd;
			$p->spece = $this->spece;
			$p->specf = $this->specf;
			$p->specg = $this->specg;
			$p->spech = $this->spech;
			$p->shortdesc = $this->shortdesc;
			$p->tview = $this->tview;
			$p->name4 = $this->name4;
			$p->name5 = $this->name5;
			$p->name = DplusWire::wire('sanitizer')->pageName($this->famID); // give it a name used in the url for the page

			if (file_exists(DplusWire::wire('config')->dplusproductimagedirectory.$this->image) && !empty($this->image)) {
				$p->product_image = DplusWire::wire('config')->dplusproductimagedirectory.$this->image;
			}
			return $p->save();
		}

		public function create_page($parentcode = '') {
			$parent = DplusWire::wire('pages')->get("template=category,catID=$this->catid");

			if (get_class($parent) == 'ProcessWire\Page') {
				$p = new Page(); // create new page object
				$p->template = 'family'; // set template
				$p->parent = $parent; // set the parent
				$p->name = DplusWire::wire('sanitizer')->pageName($this->famID); // give it a name used in the url for the page
				$p->title = $this->name1;
				$p->save();
				return ($p->id) ? $this->update_page($p) : false;
			} else {
				return false;
			}
		}

		public static function import_families() {
			$results = array();
			$families = get_families();
			foreach ($families as $family) {
				$results[$family->famID] = $family->import_family();
			}
			return $results;
		}

		/* =============================================================
		    CRUD FUNCTIONS
		============================================================ */
		public static function load($famID, $debug = false) {
			return get_family($famID, $debug);
		}
	}
