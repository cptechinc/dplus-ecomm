<?php
	class Product {
		use \Dplus\Base\ThrowErrorTrait;
		use \Dplus\Base\MagicMethodTraits;
		use \Dplus\Base\CreateFromObjectArrayTraits;
		use \Dplus\Base\CreateClassArrayTraits;

		protected $famID;
        protected $itemid;
		protected $name1;
		protected $name2;
		protected $name3;
        protected $name4;
        protected $unit;
        protected $uomdesc;
        protected $pricecode;
        protected $price;
        protected $listprice;
        protected $priceqty1;
        protected $priceprice1;
        protected $priceqty2;
        protected $priceprice2;
        protected $priceqty3;
        protected $priceprice3;
        protected $priceqty4;
        protected $priceprice4;
        protected $priceqty5;
        protected $priceprice5;
        protected $priceqty6;
        protected $priceprice6;
        protected $vpn;
        protected $shortdesc;
		protected $longdesc;
		protected $speca;
		protected $specb;
		protected $specc;
		protected $specd;
		protected $spece;
		protected $specf;
		protected $specg;
		protected $spech;
        protected $short_itemid;
        protected $upc;
        protected $mfgrid;
        protected $mfgr_itemid;
		protected $image;
		protected $dummy;

		/**
		 * Imports a family record from the database and makes a page in Processwire
		 * @param  string $parentcode Code to be parsed for parent page
		 * @return bool               Was Family Created / Updated
		 */
        public function import_product($parentcode = '') {
            $p = DplusWire::wire('pages')->get("template=product, itemid=$this->itemid");

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
			$p->famID = $this->familyid;
            $p->itemid = $this->itemid;
			$p->name2 = $this->name2;
			$p->name3 = $this->name3;
            $p->name4 = $this->name4;
			$p->imagetext = "image of $this->name1";
            $p->unit = $this->unit;
            $p->uomdesc = $this->uomdesc;
            $p->pricecode = $this->pricecode;
            $p->price = $this->price;
            $p->listprice = $this->listprice;
            $p->priceqty1 = $this->priceqty1;
            $p->priceprice1 = $this->priceprice1;
            $p->priceqty2 = $this->priceqty2;
            $p->priceprice2 = $this->priceprice2;
            $p->priceqty3 = $this->priceqty3;
            $p->priceprice3 = $this->priceprice3;
            $p->priceqty4 = $this->priceqty4;
            $p->priceprice4 = $this->priceprice4;
            $p->priceqty5 = $this->priceqty5;
            $p->priceprice5 = $this->priceprice5;
            $p->priceqty6 = $this->priceqty6;
            $p->priceprice6 = $this->priceprice6;
            $p->vpn = $this->vpn;
            $p->shortdesc = $this->shortdesc;
			$p->longdesc = $this->longdesc;
			$p->speca = $this->speca;
			$p->specb = $this->specb;
			$p->specc = $this->specc;
			$p->specd = $this->specd;
			$p->spece = $this->spece;
			$p->specf = $this->specf;
			$p->specg = $this->specg;
			$p->spech = $this->spech;
            $p->short_itemid = $this->short_itemid;
            $p->upc = $this->upc;
            $p->mfgrid = $this->mfgrid;
            $p->mfgr_itemid = $this->mfgr_itemid;
			$p->name = DplusWire::wire('sanitizer')->pageName($this->itemid); // give it a name used in the url for the page

			if (file_exists(DplusWire::wire('config')->dplusproductimagedirectory.$this->image) && !empty($this->image)) {
				$p->product_image = DplusWire::wire('config')->dplusproductimagedirectory.$this->image;
			}
			return $p->save();
		}

		public function create_page($parentcode = '') {
			$parent = DplusWire::wire('pages')->get("template=family,famID=$this->familyid");

			if (get_class($parent) == 'ProcessWire\Page') {
				$p = new Page();
				$p->template = 'product';
				$p->parent = $parent;
				$p->name = DplusWire::wire('sanitizer')->pageName($this->itemid); // give it a name used in the url for the page
				$p->title = $this->name1;
				$p->save();
				return ($p->id) ? $this->update_page($p) : false;
			} else {
				return false;
			}
		}

		public static function import_products() {
			$results = array();
			$products = get_products();
			foreach ($products as $product) {
				$results[$product->itemid] = $product->import_product();
			}
			return $results;
		}

		/* =============================================================
		    CRUD FUNCTIONS
		============================================================ */
		public static function load($itemid, $debug = false) {
			return get_product($itemid, $debug);
		}
	}
