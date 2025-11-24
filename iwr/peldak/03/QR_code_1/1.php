<?php

require 'phpqrcode/qrlib.php';

// outputs image directly into browser, as PNG stream
QRcode::png('Subotica Tech');

// http://phpqrcode.sourceforge.net/