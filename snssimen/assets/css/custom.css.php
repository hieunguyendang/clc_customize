<?php
/* Get Theme Options here and echo custom CSS */

echo snssimen_get_option('advance_customcss');

// Remmove html margin on mobile
?>
@media screen and ( max-width: 600px ) {
	html { margin-top: 0px !important; }
	* html body { margin-top: 0px !important; }
}