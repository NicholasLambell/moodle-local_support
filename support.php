<?php

use local_support\output\renderer;

require(__DIR__ . '/../../config.php');
require_once("$CFG->libdir/adminlib.php");

admin_externalpage_setup('tool_support_supportpage');

$heading = get_string('support:name', 'local_support');

/** @var renderer|core_renderer $output */
$output = $PAGE->get_renderer('local_support');

echo $output->header();

echo $output->heading($heading);

echo $output->footer();