What is this?
-------------
The MtGOX API is sort-of confusing for some, and can be annoying to work with,
So, I have created a simple class file which makes using the API fairly easy
by creating functions which automatically parse the API into normal PHP arrays
that are easy to implement in your normal PHP scripts.

**tl;dr This is a PHP class to let you jump straight into the MtGox API without having to write your own methods to access it**

It's released under the LGPL, which means you CAN use it in a proprietary script
as long as you keep the copyright notice, and let people know that you're using it.

How do I use it in my applications?
------------------------------
Place Gox.class.php in the same directory as your script and include the file.
Directly below that, or where it is needed, initialize the class by giving it
your API Key and secret obtained from the [MtGox Security Centre](https://www.mtgox.com/security) under **Advanced API Key Creation**

	$gox = new Gox('myLongAPIKey', 'Mysecretsecret');

Not much else needs to be explained, **I have documented each function with phpDocumentor** comments, so if you use an IDE like phpDesigner, it should explain every function as you type them. If not, just open up the class in your favourite editor and read through the comments, they're pretty self explanatory.

**EXAMPLE CODE**

	<?php
	include("Gox.class.php");
	// Change these values to the ones obtained from http://mtgox.com/security
	$gox = new Gox("YourAPIKey", "YourAPISecret");
	$ticker = $gox->ticker(); // No parameters defaults to BTCUSD
	if($ticker['result'] == "success") {
	    echo "The current average price for BTC in USD is "
		.$ticker['data']['avg']['value']
		."\r\n";
	} else {
	    echo "An error occurred obtaining the ticker";
	}
	?>
This code will output something similar to this:
>The current average price for BTC in USD is 130.33057
	

DEPENDENCIES
------------
- PHP 5
- cURL (Please remember to enable it!)

LICENSE/COPYRIGHT NOTICE
------------------------
THIS SCRIPT HAS BEEN RELEASED UNDER THE LGPL V3. Please make sure that you understand
the LGPL before using my class in your application.

DONATIONS
---------
Donations are accepted:

- BTC: 1SoMGuYknDgyYypJPVVKE2teHBN4HDAh3
- LTC: LSomguyTSwcw3hZKFts4P453sPfn4Y5Jzv

If this script has helped you, please donate to the Bitcoin or Litecoin address above ^

