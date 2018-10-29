<?php
    use ProcessWire\Page;
    use Dplus\ProcessWire\DplusWire;
    
	class ItemGroup {
		use \Dplus\Base\ThrowErrorTrait;
		use \Dplus\Base\MagicMethodTraits;
		use \Dplus\Base\CreateFromObjectArrayTraits;
		use \Dplus\Base\CreateClassArrayTraits;
        
        /**
         * Item Group Code
         * @var string
         */
        protected $itemgroup;
        
        /**
         * Item Group Description
         * @var string
         */
        protected $desc;
        
        /**
         * Date Updated
         * @var int
         */
        protected $date;
        
        /**
         * Time Updated
         * @var int
         */
        protected $time;
        
        /**
		 * Imports an itemgroup record from the database and makes a page in Processwire
		 * @param  string $parentcode Code to be parsed for parent page
		 * @return bool               Was Family Created / Updated
		 */
        public function import_itemgroup($parentcode = '') {
            $p = DplusWire::wire('pages')->get("template=item-group, itemgrousp=$this->itemgroup");

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
			$p->title = $this->desc;
			$p->itemgroup = $this->itemgroup;
			$p->name = DplusWire::wire('sanitizer')->pageName($this->itemgroup); // give it a name used in the url for the page
			return $p->save();
		}

		public function create_page($parentcode = '') {
			$parent = DplusWire::wire('pages')->get("template=category,catID=$this->catid");

			if (get_class($parent) == 'ProcessWire\Page') {
				$p = new Page(); // create new page object
				$p->template = 'item-group'; // set template
				$p->parent = $parent; // set the parent
				$p->name = DplusWire::wire('sanitizer')->pageName($this->famID); // give it a name used in the url for the page
				$p->title = $this->desc;
				$p->save();
				return ($p->id) ? $this->update_page($p) : false;
			} else {
				return false;
			}
		}

		public static function import_families() {
			$results = array();
			$families = get_itemgroups();
			foreach ($families as $family) {
				$results[$family->famID] = $family->import_itemgroup();
			}
			return $results;
		}

		/* =============================================================
		    CRUD FUNCTIONS
		============================================================ */
		public static function load($itemgroup, $debug = false) {
			return get_itemgroup($itemgroup, $debug);
		}
}
