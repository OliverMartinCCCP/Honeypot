<?php
require_once 'core/init.php';

/*$user = DB::getInstance()->get('users', array('id', '=', '1'));*/
/*$user = DB::getInstance()->get('users', array('username', '=', 'alex'));*/
//echo Token::generate();
//echo Config::get('session/token_name');

$user = new User();

if (Session::exists('home')) {
    echo '<p style="background-color: darkgray;">' . Session::flash('home') . '</p>';
}

include 'header.php';
?>

<!--

****************************************************************************************************************************************************************************************************************
******************************************************************************* THIS WEBSITE IS DEVELOPED BY OLIVER MARTIN *************************************************************************************
****************************************************************************************************************************************************************************************************************


****************************************************************************************************************************************************************************************************************
******************************************************************************************** DISCLAIMER ********************************************************************************************************
****************************************************************************************************************************************************************************************************************
************************************************************ The information contained in this website is for general information purposes only. ***************************************************************
********************************************* The information is provided by Oliver Martin and while we endeavour to keep the information up to date and correct, **********************************************
********************* we make no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability or availability with respect to the website *********
****************** or the information, products, services, or related graphics contained on the website for any purpose. Any reliance you place on such information is therefore strictly at your own risk. ****
*                                                                                                                                                                                                              *
**************************************** In no event will we be liable for any loss or damage including without limitation, indirect or consequential loss or damage, ******************************************
************************************ or any loss or damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this website. *************************************
*                                                                                                                                                                                                              *
********************************************* Through this website you are able to link to other websites which are not under the control of Oliver Martin. ****************************************************
*********************************************************** We have no control over the nature, content and availability of those sites. ***********************************************************************
******************************************* The inclusion of any links does not necessarily imply a recommendation or endorse the views expressed within them. *************************************************
*                                                                                                                                                                                                              *
*************************************************************** Every effort is made to keep the website up and running smoothly. ******************************************************************************
************************** However, Oliver Martin takes no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control. ***************
****************************************************************************************************************************************************************************************************************



****************************************************************************************************************************************************************************************************************
************************************** DO YOU WANT A WEBSITE WITH FUNCTIONALITY LIKE THIS? FEEL FREE TO CONTACT ME ON LINKEDIN: https://www.linkedin.com/in/oliver-martin-4b207b112 ****************************
****************************************************************************************************************************************************************************************************************

-->

<div id="page">
    <div id="titel">
        <h1>Welcome to the official Monopole website</h1>
    </div>
    <div id="wrapper">
        <img src="img/wrapper.jpg">
    </div>
</div>


<?php
include 'footer.php';
?>

</body>
<script src="../../../../wamp/www/Projects/phpOef/honingpot/js/script.js"></script>
</html>