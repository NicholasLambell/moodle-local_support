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

namespace local_support\form;

use core\form\persistent;

/**
 * Support form.
 *
 * @package    local_support
 * @copyright  2024 Nicholas Lambell
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class entry_form extends persistent {

    protected static $persistentclass = 'local_support\persistent\entry';

    /**
     * From definition.
     *
     * @return void
     */
    protected function definition(): void {
        $this->define_base_fields();
        $this->define_time_section();

        $this->add_action_buttons(false, get_string('submit'));
    }

    /**
     * Add base fields to the form.
     *
     * @return void
     */
    private function define_base_fields(): void {
        global $USER;

        $mform = $this->_form;

        $mform->addElement('header', 'detailsheader', get_string('supportform:headerdetails', 'local_support'));

        $mform->addElement('text', 'name', get_string('supportform:name', 'local_support'));
        $mform->setType('name', PARAM_TEXT);
        $mform->setDefault('name', fullname($USER));
        $mform->addRule('name', null, 'required', null, 'client');

        $mform->addElement('date_selector', 'date', get_string('supportform:date', 'local_support'));
        $mform->addRule('date', null, 'required', null, 'client');

        $siteoptions = self::site_options();
        $mform->addElement('select', 'site', get_string('supportform:site', 'local_support'), $siteoptions);
        $mform->addRule('site', null, 'required', null, 'client');
    }

    /**
     * Add time section to the form.
     *
     * @return void
     */
    private function define_time_section(): void {
        $mform = $this->_form;

        // For each support type add a new header and set of support level fields.
        foreach ([ 'email', 'phone' ] as $type) {
            $mform->addElement('header', "${type}header", get_string("supportform:header$type", 'local_support'));

            for ($i = 1; $i <= 4; $i++) {
                $elementname = "${type}level$i";

                $mform->addElement('text', $elementname, get_string("supportform:level$i", 'local_support'));
                $mform->setType($elementname, PARAM_INT);
                $mform->setDefault($elementname, 0);
                $mform->addRule($elementname, null, 'required', null, 'client');
            }
        }
    }

    /**
     * Get the list of site options.
     *
     * @return string[] List of options.
     */
    private static function site_options(): array {
        $options = [];
        $options[''] = get_string('supportform:sitenone', 'local_support');

        $sitesconfig = get_config('local_support', 'sites');
        $siteoptions = explode(PHP_EOL, $sitesconfig);
        foreach ($siteoptions as $siteoption) {
            $options[] = $siteoption;
        }

        return $options;
    }
}