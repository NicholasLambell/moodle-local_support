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
use local_support\form\element\value_handler;
use local_support\output\entry_times_section;
use stdClass;

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
        $mform = $this->_form;

        $this->define_base_fields();

        $mform->addElement('static', 'timesectionplaceholder');

        $this->add_action_buttons(false, get_string('submit'));
    }

    /**
     * From definition after data has been set.
     *
     * @return void
     */
    public function definition_after_data() {
        $this->define_time_section();
    }

    /**
     * Define extra validation mechanisms.
     *
     * @param stdClass $data Data to validate.
     * @param array $files Array of files.
     * @param array $errors Currently reported errors.
     * @return array List of additional errors, or overridden errors.
     **/
    protected function extra_validation($data, $files, array &$errors): array {
        if ($data->site == -1) {
            $errors['site'] = get_string('required');
        }

        return $errors;
    }

    /**
     * Add base fields to the form.
     *
     * @return void
     */
    private function define_base_fields(): void {
        $mform = $this->_form;

        $mform->addElement('text', 'name', get_string('supportform:name', 'local_support'));
        $mform->setType('name', PARAM_TEXT);
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
        global $OUTPUT;

        $mform = $this->_form;

        $supportlevels = [
            1 => 6,
            2 => 15,
            3 => 30,
            4 => 45,
        ];

        // For each level in each support type add a value handler matching the custom HTML.
        $fieldvalues = [];
        foreach ([ 'email', 'phone' ] as $type) {
            foreach ($supportlevels as $level => $minutes) {
                $elementname = "${type}level$level";

                $valuehandler = new value_handler($elementname);
                $mform->addElement($valuehandler);

                $fieldvalues[$elementname] = $mform->exportValue($elementname);
            }
        }

        $renderable = new entry_times_section($fieldvalues);
        $sectionhtml = $OUTPUT->render($renderable);

        $sectionelement = $mform->createElement('html', $sectionhtml);
        $mform->insertElementBefore($sectionelement, 'timesectionplaceholder');
        $mform->removeElement('timesectionplaceholder');
    }

    /**
     * Get the list of site options.
     *
     * @return string[] List of options.
     */
    private static function site_options(): array {
        $options = [];
        $options[-1] = get_string('supportform:sitenone', 'local_support');

        $sitesconfig = get_config('local_support', 'sites');
        $siteoptions = explode(PHP_EOL, $sitesconfig);
        foreach ($siteoptions as $siteoption) {
            $options[] = $siteoption;
        }

        return $options;
    }
}