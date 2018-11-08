<?php 
    namespace Dplus\Ecomm\Pages;

    use Processwire\Page;
    use Dplus\ProcessWire\DplusWire;
    use ItemMasterItem;
    
    /**
     * Class that handles the manipulation of ItemMasterItem Pages
     */
    class ItemMasterItemPages extends ProcessWirePageBuilder {
        protected $template = 'imitem';

        public function create_page(ModelClass $item, $parentselector = '') {
            $parent = false;

            if (!empty($parentselector)) {
                $parent = DplusWire::wire('pages')->get($parentselector);
            }
            if (!$parent) {
                $parent = DplusWire::wire('pages')->get($this->get_defaultparentselector($item));
            }

            if (get_class($parent) == 'ProcessWire\Page') {
                $p = new Page(); // create new page object
                $p->template = $this->template; // set template
                $p->parent = $parent; // set the parent
                $p->name = DplusWire::wire('sanitizer')->pageName($item->itemid); // give it a name used in the url for the page
				$p->title = $item->name1;
                $p->status(['hidden' => false, 'unpublished' => false]); 
                $p->save();
                return ($p->id) ? $this->update_page($p, $item, $parentselector) : false;
            } else {
                return false;
            }
        }

        /**
         * Updates a ItemMasterItem Page
         * @param  Page       $p              ItemMasterItem Page
         * @param  ModelClass $item           ItemMasterItem  to Make Page out of
         * @param  string     $parentselector ItemMasterItem Selector for Parent
         * @return bool                       Was Page updated?
         */
        public function update_page(Page $p, ModelClass $item, $parentselector = '') {
            $imgtypes = array('jpg', 'gif', 'png', 'jpeg');
            $p->of(false);
            $p->itemid = $item->itemid;
            $p->title = $item->name1;
            $p->name2 = $item->name2;
            $p->shortdesc = $item->shortdesc;
			$p->famID = $item->familyid;
            $p->imagetext = "image of $item->name1";
			$p->itemgroup = $item->itemgroup;
			$p->name = DplusWire::wire('sanitizer')->pageName("$item->name1 - $item->itemid"); // give it a name used in the url for the page

			if (file_exists(DplusWire::wire('config')->dplusproductimagedirectory.$item->image) && !empty($item>image)) {
				$p->product_image = DplusWire::wire('config')->dplusproductimagedirectory.$item->image;
			} else {
                foreach ($imgtypes as $imgtype) {
                    $image = DplusWire::wire('config')->dplusproductimagedirectory."$this->itemid.$imgtype";
                    if (file_exists($image)) {
                        $p->product_image = $image;
                        break;
                    }
                }              
            }
            return $p->save();
        }


        protected function get_defaultparentselector(ModelClass $item) {
            if (DplusWire::wire('config')->templateparent_product == 'item-group') {
				return "template=item-group,itemgroup=$item->itemgroup";
			} else {
				return "template=family,famID=$item->familyid";
			}
        }

        
        /**
         * Imports a ItemMaster record from the database and makes a page in Processwire
         * @param  ModelClass $item         ItemMasterItem object to pull data from
         * @param  string     $parentselector ProcessWire Selector for Parent
         * @return bool                       Was ItemMasterItem Created / Updated?
         */
        public function import(ModelClass $item, $parentselector = '') {
            $p = $this->get_page("template=$this->template, itemgroup=$item->itemgroup");

            if (get_class($p) == 'ProcessWire\Page') {
                return $this->update_page($p, $item, $parentselector);
            } else {
                return $this->create_page($item, $parentselector);
            }
        }

       /**
         * Imports ItemMasterItem Pages
         * @param  string $parentselector  ProcessWire Selector for Parent
         * @return array                   Results keyed by Page Name
         */
        public function import_all($parentselector = '') {
            $results = array();
            $families = get_items();
            $this->hide_templatepages(); 

            foreach ($families as $item) {
                $results[$item->code] = $this->import($item, $parentselector);
            }
            return $results;
        }
    }
