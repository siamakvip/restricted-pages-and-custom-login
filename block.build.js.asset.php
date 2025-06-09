<?php
$asset = array(
    'dependencies' => ['wp-blocks', 'wp-components', 'wp-editor', 'wp-element', 'wp-i18n'],
    'version' => filemtime(__DIR__ . '/block.build.js')
);

return $asset;