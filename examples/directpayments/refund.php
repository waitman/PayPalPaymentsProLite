<?php
include('../../src/DirectPayments/RefundTransaction.php');
use PayPalPaymentsProLite\RefundTransaction;
$dcc = new RefundTransaction();

//Place any variables into this array:  https://www.paypalobjects.com/webstatic/en_US/developer/docs/pdf/payflowgateway_guide.pdf
$variables = array(
		//Get the PNREF from original transaction
		'ORIGID' => $_GET['PNREF'],
		
		'AMT' => '100.00',
		'CURRENCYCODE' => 'USD',

		//Set userid as custom field
		'CUSTOM' => 'This is a test',

		//Line Items
		'L_NAME0' => 'Test Item',
		'L_DESC0' => 'Teset ITem desc',
		'L_AMT0' => '100.00',
);

//Place the variables onto the stack
$dcc->pushVariables($variables);

//Execute the Call via CURL
$dcc->executeCall();

//Get the response decoded into an array
$response = $dcc->getCallResponseDecoded();

//Get the raw response
$string = $dcc->getCallResponse();

?>

<h3>Submitted</h3>
<div style="max-width:800px;word-wrap:break-word;">curl -i <?php echo $dcc->getCallEndpoint() ?> -d "<?php echo $dcc->getCallQuery() ?>" </div>

<h3>Return String</h3>
<div style="max-width:800px;word-wrap:break-word;"><?php echo $dcc->getCallResponse() ?></div>

<h3>Return Decoded</h3>
<pre>
<?php
$decoded = $dcc->getCallResponseDecoded();
print_r($decoded);
?>
</pre>

<a href="../index.php">Back to Home</a>
<?php 
$callvars = $dcc->getCallVariables();
?>
<a href="inquiry.php?PNREF=<?php echo $decoded['PNREF'] ?>">Inquiry Transaction</a><br />
<?php
if($callvars['TRXTYPE'] == 'S'): ?>
<a href="refund.php?PNREF=<?php echo $decoded['PNREF'] ?>">Refund Transaction</a>
<?php elseif($callvars['TRXTYPE'] == 'A') :?>
<a href="capture.php?PNREF=<?php echo $decoded['PNREF'] ?>">Capture Transaction</a>
<a href="void.php?PNREF=<?php echo $decoded['PNREF'] ?>">Void Transaction</a>
<?php endif; ?>
