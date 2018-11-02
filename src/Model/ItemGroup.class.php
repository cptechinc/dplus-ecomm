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
        protected $code;
        
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

		/* =============================================================
		    CRUD FUNCTIONS
		============================================================ */
		public static function load($itemgroup, $debug = false) {
			return get_itemgroup($itemgroup, $debug);
		}
}
