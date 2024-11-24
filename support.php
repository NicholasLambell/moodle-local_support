<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

use local_support\local\page\support_page;
use local_support\output\renderer;

require(__DIR__ . '/../../config.php');
require_once("$CFG->libdir/adminlib.php");

admin_externalpage_setup('tool_support_supportpage');

$heading = get_string('support:name', 'local_support');

/** @var renderer|core_renderer $output */
$output = $PAGE->get_renderer('local_support');
$supportpage = new support_page($output);

$supportpage->process_form();

echo $output->header();

echo $output->heading($heading);
$supportpage->output_body();

echo $output->footer();