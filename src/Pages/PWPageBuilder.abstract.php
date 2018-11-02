<?php 
    namespace Dplus\Ecomm\Pages;
    
    use Processwire\Page;
    use ModelClass;
    
    /**
     * Class to define what functions extending classes need to manipulate ProcessWire Pages
     */
    abstract class ProcessWirePageBuilder {
        use \Dplus\Base\ThrowErrorTrait;
		use \Dplus\Base\MagicMethodTraits;

        /**
         * ProcessWire Template this class Manipulates Pages for
         * @var string
         */
        protected $template;

        /**
         * Default Parent Selector for Processwire
         * @var string
         */
        protected $parentselector_default;
        
        /**
         * Creates a ProcessWire Page
         * @param  ModelClass $object         Object to Make Page out of
         * @param  string     $parentselector ProcessWire Selector for Parent
         * @return bool                       Was Page Created?
         */
        public function create_page(ModelClass $object, $parentselector = '') {

        }
        
        /**
         * Updates a ProcessWire Page
         * @param  Page       $p              ProcessWire Page
         * @param  ModelClass $object         Object to Make Page out of
         * @param  string     $parentselector ProcessWire Selector for Parent
         * @return bool                       Was Page updated?
         */
        public function update_page(Page $p, ModelClass $object, $parentselector = '') {

        }
        /**
         * Imports Page of type
         * @param  ModelClass $object         Object to Make Page out of
         * @param  string     $parentselector ProcessWire Selector for PArent
         * @return bool                       Was Page Created / Updated?
         */
        public function import(ModelClass $object, $parentselector = '') {

        }
        
        /**
         * Imports All the pages of type
         * @param  string $parentselector  ProcessWire Selector for Parent
         * @return array                   Results keyed by Page Name
         */
        public function import_all($parentselector = '') {

        }

        /**
         * Validates if Page Exists with given selector
         * @param string $selector ProcessWire Selector
         * @return bool            Does Page Exist?
         */
        protected function page_exists($selector) {
            return boolval(DplusWire::wire('pages')->count($selector));
        }

        protected function get_page($selector) {
            if ($this->page_exists($selector)) {
                $page = DplusWire::wire('pages')->get($selector);

                if (get_class($page) == 'ProcessWire\Page') {
                    return $page;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        /**
         * Returns the default Parent Selector for this Class
         *
         * @param ModelClass $object
         * @return string
         */
        protected function get_defaultparentselector(ModelClass $object) {

        }

        /**
         * Hide Template Pages
         * @return void
         */
        protected function hide_templatepages() {
            $pages = DplusWire::wire('pages')->find('template=$this->template');
            foreach ($pages as $page) {
                $page->of(false);
				$page->status(['hidden' => true, 'unpublished' => true]); 
            }
        }
    }
