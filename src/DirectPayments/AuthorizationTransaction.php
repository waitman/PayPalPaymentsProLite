<?php
namespace PayPalPaymentsProLite;
include_once(__DIR__.'/../PayFlowAPI.php');
class AuthorizationTransaction extends PayFlowAPI{

	protected $validation_parameters;
	
	
	public function __construct()
	{
		$this->validation_parameters = array(

			'AMT',
			'ACCT',
			'EXPDATE',
			'TRXTYPE',
			'TENDER',	
		);
		
		$this->call_variables['TRXTYPE'] = 'A';
		$this->call_variables['TENDER'] = 'C';
		
		
		parent::__construct();
	}
	
}