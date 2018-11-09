<?php 
    namespace Dplus\Ecomm\Pages;

    use Processwire\Page;
    use Dplus\ProcessWire\DplusWire;

    /**
	 * Use Statements for Model Classes which are non-namespaced
	 */
    use ModelClass;
    use ItemGroup;
    
    
    /**
     * Class that handles the manipulation of ItemGroup Pages
     */
    class ItemGroupPages extends ProcessWirePageBuilder {
        protected $template = 'item-group';

        public function create_page(ModelClass $itemgroup, $parentselector = '') {
            $parent = false;

            if (!empty($parentselector)) {
                $parent = DplusWire::wire('pages')->get($parentselector);
            }
            if (!$parent) {
                $parent = DplusWire::wire('pages')->get($this->get_defaultparentselector($itemgroup) );
            }

            if (get_class($parent) == 'ProcessWire\Page') {
                $p = new Page(); // create new page object
                $p->template = $this->template; // set template
                $p->parent = $parent; // set the parent
                $p->name = DplusWire::wire('sanitizer')->pageName($itemgroup->code); // give it a name used in the url for the page
                $p->title = $itemgroup->desc;
                $p->status(['hidden' => false, 'unpublished' => false]); 
                $p->save();
                return ($p->id) ? $this->update_page($p, $itemgroup, $parentselector) : false;
            } else {
                return false;
            }
        }

        /**
         * Updates a ItemGroup Page
         * @param  Page       $p              ItemGroup Page
         * @param  ModelClass $itemgroup         Object to Make Page out of
         * @param  string     $parentselector ItemGroup Selector for Parent
         * @return bool                       Was Page updated?
         */
        public function update_page(Page $p, ModelClass $itemgroup, $parentselector = '') {
            $p->of(false);
            $p->title = $itemgroup->desc;
			$p->code = $itemgroup->code;
			$p->name = DplusWire::wire('sanitizer')->pageName($itemgroup->code); // give it a name used in the url for the page
            return $p->save();
        }


        protected function get_defaultparentselector(ModelClass $itemgroup) {
            return "template=products";
        }

        
        /**
         * Imports a family record from the database and makes a page in Processwire
         * @param  ModelClass $itemgroup      ItemGroup object to pull data from
         * @param  string     $parentselector ProcessWire Selector for Parent
         * @return bool                       Was ItemGroup Created / Updated?
         */
        public function import(ModelClass $itemgroup, $parentselector = '') {
            $p = $this->get_page("template=$this->template, itemgroup=$itemgroup->code");

            if (get_class($p) == 'ProcessWire\Page') {
                return $this->update_page($p, $itemgroup, $parentselector);
            } else {
                return $this->create_page($itemgroup, $parentselector);
            }
        }

       /**
         * Imports ItemGroup Pages
         * @param  string $parentselector  ProcessWire Selector for Parent
         * @return array                   Results keyed by Page Name
         */
        public function import_all($parentselector = '') {
            $results = array();
            $families = get_itemgroups();
            $this->hide_templatepages(); 

            foreach ($families as $itemgroup) {
                $results["$itemgroup->code"] = $this->import($itemgroup, $parentselector);
            }
            return $results;
        }
    }
