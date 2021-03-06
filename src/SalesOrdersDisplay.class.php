<?php
	namespace Dplus\Ecomm;
	
	use Purl\Url;
	use Dplus\ProcessWire\DplusWire;
	use Dplus\Content\Paginator;
	use Dplus\Dpluso\OrderDisplays\SalesOrderPanel;

	/**
	 * Use Statements for Model Classes which are non-namespaced
	 */
	use Order;

	class SalesOrdersDisplay extends SalesOrderPanel {

        public function __construct($sessionID, Url $pageurl, $modal, $loadinto, $ajax) {
			parent::__construct($sessionID, $pageurl, $modal, $loadinto, $ajax);
			$this->pageurl = new Url($pageurl->getUrl());
			$this->setup_pageURL();
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
			$url = new Url(DplusWire::wire('pages')->get('/user/orders/redir/')->url);
			$url->query->set('action', 'get-order-details');
			$url->query->set('ordn', $order->ordernumber);
			return $url->getUrl();
		}
	}
