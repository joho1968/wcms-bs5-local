<?php
/**
 * wcms-bs5-local.php
 * WonderCMS Bootstrap 5 local inclusion plugin
 * Copyright (C) 2023 Joaquim Homrighausen; all rights reserved.
 * Please see README.md and LICENSE for details.
 *
 * We're currently at Bootstrap 5.3.1.
 */


/**
 * Hook to add reference to local Bootstrap 5 CSS
 */
function wcms_bs5_local_css( array $args ) {
    global $Wcms; // The WonderCMS instance/object

    $GLOBALS['plugin.wcms_bs5_local'] = true;
    // Possibly cache busting, in case of a source change
    $css_mtime = filemtime( dirname( __FILE__ ) . '/bs5/css/bootstrap.min.css' );
    if ( $css_mtime !== false ) {
        $css_mtime = '?' . $css_mtime;
    } else {
        $css_mtime = '';
    }
    // Generate our stylesheet info
    $args[0] .= '<link rel="stylesheet" href="' .
                $Wcms->url( 'plugins/' ) . basename( __FILE__, '.php' ) . '/bs5/css/bootstrap.min.css' .
                $css_mtime . '" />';
    return( $args );
}

/**
 * Hook to add reference to local Bootstrap 5 JS
 */
function wcms_bs5_local_js( array $args ) {
    global $Wcms; // The WonderCMS instance/object

    // Possibly cache busting, in case of a source change
    $js_mtime = filemtime( dirname( __FILE__ ) . '/bs5/js/bootstrap.bundle.min.js' );
    if ( $js_mtime !== false ) {
        $js_mtime = '?' . $js_mtime;
    } else {
        $js_mtime = '';
    }
    // Generate our script info
    $args[0] .= '<script src="' . $Wcms->url( 'plugins/' ) . basename( __FILE__, '.php' ) . '/bs5/js/bootstrap.bundle.min.js' . $js_mtime . '"></script>';

    // Add some JS init code for Bootstrap popper/popover
    $args[0] .= "\n" . '<!-- Start me up -->' . "\n" .
                       '<script>' . "\n" .
                       'function documentSetup() { const popoverTriggerList = document.querySelectorAll(\'[data-bs-toggle=\"popover\"]\');' .
                       'const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));' .
                       '}' . "\n" .
                       'if (document.readyState === \'complete\' || ' .
                       '(document.readyState !== \'loading\' && !document.documentElement.doScroll)) {' .
                       'documentSetup();' .
                       '} else {' .
                       'document.addEventListener(\'DOMContentLoaded\', documentSetup);' .
                       '}' . '</script>' . "\n";
    return( $args );
}


global $Wcms; // The WonderCMS instance/object

$GLOBALS['plugin.wcms_bs5_local'] = true; // In case someone wants to find us

$Wcms->addListener( 'css', 'wcms_bs5_local_css' );
$Wcms->addListener( 'js', 'wcms_bs5_local_js' );


/**
 * That's all there's too it really. A theme can now check the $GLOBALS[]
 * variable above. Possibly not the most elegant solution. But since there's
 * no "namespace" for a WCMS plugin in the actual WCMS instance, it'll have to
 * do for now :-)
 */
