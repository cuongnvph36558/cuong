<?php

/**
 * Front controller shim for shared hosting.
 *
 * Use this layout only when the whole project is uploaded into the web root
 * (`public_html`) and the document root cannot be pointed at `public/`.
 * It simply forwards the request to the real front controller.
 */

require __DIR__.'/public/index.php';
