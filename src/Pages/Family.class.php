<?php 
    namespace Dplus\Ecomm\Pages;

    use Processwire\Page;
    use Dplus\ProcessWire\DplusWire;
    use Family;
    
    /**
     * Class that handles the manipulation of Family Pages
     */
    class FamilyPages extends ProcessWirePageBuilder {
        protected $template = 'family';

        public function create_page(ModelClass $family, $parentselector = '') {
            $parent = false;
            if (!empty($parentselector)) {
                $parent = DplusWire::wire('pages')->get($parentselector);
            }
            if (!$parent) {
                $parent = DplusWire::wire('pages')->get($this->get_defaultparentselector($family) );
            }

            if (get_class($parent) == 'ProcessWire\Page') {
                $p = new Page(); // create new page object
                $p->template = $this->template; // set template
                $p->parent = $parent; // set the parent
                $p->name = DplusWire::wire('sanitizer')->pageName($family->famID); // give it a name used in the url for the page
                $p->title = $family->name1;
                $p->save();
                return ($p->id) ? $this->update_page($p) : false;
            } else {
                return false;
            }
        }

        /**
         * Updates a Family Page
         * @param  Page       $p              Family Page
         * @param  ModelClass $family         Object to Make Page out of
         * @param  string     $parentselector Family Selector for Parent
         * @return bool                       Was Page updated?
         */
        public function update_page(Page $p, ModelClass $family, $parentselector = '') {
            $p->of(false);
            $p->title = $family->name1;
            $p->famID = $family->famID;
            $p->names2 = $family->name2;
            $p->name3 = $family->name3;
            $p->imagetext = "image of $family->name1";
            $p->longdesc = $family->longdesc;
            $p->speca = $family->speca;
            $p->specb = $family->specb;
            $p->specc = $family->specc;
            $p->specd = $family->specd;
            $p->spece = $family->spece;
            $p->specf = $family->specf;
            $p->specg = $family->specg;
            $p->spech = $family->spech;
            $p->shortdesc = $family->shortdesc;
            $p->tview = $family->tview;
            $p->name4 = $family->name4;
            $p->name5 = $family->name5;
            $p->name = DplusWire::wire('sanitizer')->pageName($family->famID); // give it a name used in the url for the page

            if (file_exists(DplusWire::wire('config')->dplusproductimagedirectory.$family->image) && !empty($family->image)) {
                $p->product_image = DplusWire::wire('config')->dplusproductimagedirectory.$family->image;
            }
            return $p->save();
        }


        protected function get_defaultparentselector(ModelClass $family) {
            return "template=category,catID=$family->catid";
        }

        
        /**
         * Imports a family record from the database and makes a page in Processwire
         * @param  ModelClass $family         Family object to pull data from
         * @param  string     $parentselector ProcessWire Selector for Parent
         * @return bool                       Was Family Created / Updated?
         */
        public function import(ModelClass $family, $parentselector = '') {
            $p = $this->get_page("template=$this->template, famID=$family->famID");

            if (get_class($p) == 'ProcessWire\Page') {
                $p->of(false);
                return $this->update_page($p, $family, $parentselector);
            } else {
                return $this->create_page($family, $parentselector);
            }
        }

       /**
         * Imports Family Pages
         * @param  string $parentselector  ProcessWire Selector for Parent
         * @return array                   Results keyed by Page Name
         */
        public function import_all($parentselector = '') {
            $results = array();
            $families = get_families();
            $this->hide_templatepages(); 

            foreach ($families as $family) {
                $results[$family->famID] = $this->import($family, $parentselector);
            }
            return $results;
        }
    }
