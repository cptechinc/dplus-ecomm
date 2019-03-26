<?php
	namespace Dplus\Ecomm;

	use Purl\Url;
	use Dplus\ProcessWire\DplusWire;
	use Dplus\Content\Paginator;
	use Dplus\Dpluso\OrderDisplays\SalesOrderHistoryPanel;

	/**
	 * Use Statements for Model Classes which are non-namespaced
	 */
	use SalesOrderHistory, Order;

	class SalesOrderHistoryDisplay extends SalesOrderHistoryPanel {

        /**
		 * Sales Order Number
		 * @var string
		 */
		protected $ordn;

		public function __construct($sessionID, Url $pageurl, $modal, $ordn) {
			parent::__construct($sessionID, $pageurl, $modal);
			$this->ordn = $ordn;
		}

        /* =============================================================
			OrderPanelInterface Functions
			LINKS ARE HTML LINKS, AND URLS ARE THE URLS THAT THE HREF VALUE
		============================================================ */
        public function setup_pageURL() {
			$this->pageurl->query->remove('display');
		}

        public function generate_searchURL() {
			$url = new Url($this->pageurl->getUrl());
			$url = Paginator::paginate_purl($url, 1, $this->paginationinsertafter);
			return $url->getUrl();
		}

		public function generate_loaddetailsURL(Order $order) {
			$url = new Url(DplusWire::wire('pages')->get('/sales-orders-history/redir/')->url);
			$url->query->set('action', 'get-order-details');
			$url->query->set('ordn', $order->ordernumber);
			return $url->getUrl();
		}

        /* =============================================================
			GETTER FUNCTIONS
		============================================================ */
		/**
		 * Returns Sales Order from database
		 * @param  bool             		$debug Run in debug? If So, returns SQL Query
		 * @return SalesOrderHistory        Sales Order
		 */
		public function get_order($debug = false) {
			return SalesOrderHistory::load($this->ordn, $debug);
		}
	}
