<?php
	use ProcessWire\Page;
	
	class ItemMasterItem {
		use \Dplus\Base\ThrowErrorTrait;
		use \Dplus\Base\MagicMethodTraits;
		use \Dplus\Base\CreateFromObjectArrayTraits;
		use \Dplus\Base\CreateClassArrayTraits;

		
        protected $itemid;
        protected $name1;
        protected $name2;
        protected $shortdesc;
        protected $famID;
        protected $image;
        protected $catID;
        protected $tview;
        protected $itemgroup;
		protected $dummy;

		/**
		 * Imports a family record from the database and makes a page in Processwire
		 * @param  string $parentcode Code to be parsed for parent page
		 * @return bool               Was Product Created / Updated
		 */
        public function import_item($parentcode = '') {
            $p = DplusWire::wire('pages')->get("template=imitem, itemid=$this->itemid");

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
		/**
		 * Updates Item Page Values
		 * @param  Page   $p          ProcessWire Page to update
		 * @param  string $parentcode Code to be parsed for parent page
		 * @return bool               Was Item Updated
		 */
		public function update_page(Page $p, $parentcode = '') {
            $p->itemid = $this->itemid;
            $p->title = $this->name1;
            $p->name2 = $this->name2;
            $p->shortdesc = $this->shortdesc;
			$p->famID = $this->familyid;
            $p->imagetext = "image of $this->name1";
			
			$p->itemgroup = $this->itemgroup;
			
            
			$p->name = DplusWire::wire('sanitizer')->pageName($this->name1); // give it a name used in the url for the page

			if (file_exists(DplusWire::wire('config')->dplusproductimagedirectory.$this->image) && !empty($this->image)) {
				$p->product_image = DplusWire::wire('config')->dplusproductimagedirectory.$this->image;
			}
			return $p->save();
		}
		
		/**
		 * Creates Processwire/Page for Item
		 * @param  string $parentcode Code to be parsed for parent page
		 * @return bool               Was Page created?
		 */
		public function create_page($parentcode = '') {
			if (DplusWire::wire('config')->templateparent_product == 'item-group') {
				$parent = DplusWire::wire('pages')->get("template=item-group,itemgroup=$this->itemgroup");
			} else {
				$parent = DplusWire::wire('pages')->get("template=family,famID=$this->familyid");
			}

			if (get_class($parent) == 'ProcessWire\Page') {
				$p = new Page();
				$p->template = 'itemitem';
				$p->parent = $parent;
				$p->name = DplusWire::wire('sanitizer')->pageName($this->itemid); // give it a name used in the url for the page
				$p->title = $this->name1;
				$p->save();
				return ($p->id) ? $this->update_page($p) : false;
			} else {
				return false;
			}
		}
		
		/**
		 * Imports an array of Item then updates/creates Pages for them
		 * @return array Keyed by Item ID and the value if Page was updated / created
		 */
		public static function import_items() {
			$results = array();
			$products = get_items();
			foreach ($products as $product) {
				$results[$product->itemid] = $product->import_item();
			}
			return $results;
		}

		/* =============================================================
		    CRUD FUNCTIONS
		============================================================ */
		public static function load($itemid, $debug = false) {
			return get_item($itemid, $debug);
		}
	}
