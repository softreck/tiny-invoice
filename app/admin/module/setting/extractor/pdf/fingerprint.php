<?php
/**
 * Module Extractor
 *
 * @author Christophe Gosiau <christophe@tigron.be>
 * @author Gerry Demaret <gerry@tigron.be>
 * @author David Vandemaele <david@tigron.be>
 */

use Skeleton\Pager\Web\Pager;
use Skeleton\Core\Web\Session;
use Skeleton\Core\Web\Module;
use Skeleton\Core\Web\Template;

class Web_Module_Setting_Extractor_Pdf_Fingerprint extends Module {

    /**
     * The template
     *
     * @access public
     */
    public $template = 'setting/extractor/pdf/fingerprint.twig';


	/**
	 * Display fingerprints
	 *
	 * @access public
	 */
    public function display() {
		$extractor_pdf = Extractor_Pdf::get_by_id($_GET['id']);

		$template = Template::get();
		$template->assign('extractor_pdf', $extractor_pdf);
    }

	/**
	 * Add a fingerprint
	 *
	 * @access public
	 */
    public function display_add_fingerprint() {
		$coordinates = json_decode($_POST['coordinates'], true)[0];
		$sort = $coordinates['id'];
		unset($coordinates['id']);
		$fingerprint = new Extractor_Pdf_Fingerprint();
		$fingerprint->extractor_pdf_id = $_GET['id'];
		$fingerprint->load_array($coordinates);
		$fingerprint->sort = $sort;
		$fingerprint->save();

		$this->template = 'setting/extractor/pdf/ajax_fingerprint.twig';
		$template = Template::get();
		$template->assign('fingerprint', $fingerprint);
    }

    /**
     * Clear fingerprints
     *
     * @access public
     */
    public function display_clear_fingerprints() {
    	$extractor_pdf = Extractor_Pdf::get_by_id($_GET['id']);
    	$fingerprints = $extractor_pdf->get_extractor_pdf_fingerprints();
    	foreach ($fingerprints as $fingerprint) {
    		$fingerprint->delete();
    	}
    	$this->template = false;
    }
}
