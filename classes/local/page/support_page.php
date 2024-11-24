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

namespace local_support\local\page;

use core_renderer;
use local_support\form\support_form;
use local_support\output\renderer;
use moodleform;
use stdClass;

/**
 * Support page.
 *
 * @package    local_support
 * @copyright  2024 Nicholas Lambell
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class support_page {

    private moodleform $form;

    /**
     * @var renderer|core_renderer $renderer
     */
    private $renderer;

    /**
     * @param renderer|core_renderer $renderer
     */
    public function __construct($renderer) {
        $this->renderer = $renderer;

        $this->init_form();
    }

    /**
     * Initialize main page form.
     *
     * @return void
     */
    private function init_form(): void {
        $this->form = new support_form();
    }

    /**
     * Handle form submission events where required.
     *
     * @return void
     */
    public function process_form(): void {
        global $PAGE;

        if ($this->form->is_cancelled()) {
            redirect($PAGE->url);
        }

        $data = $this->form->get_data();
        if (!$data) {
            return;
        }

        $this->process_form_data($data);

        notice(get_string('support:success', 'local_support'), $PAGE->url);
    }

    /**
     * Output the main page content.
     *
     * @return void
     */
    public function output_body(): void {
        $this->form->display();
    }

    /**
     * Process form submission data.
     *
     * @param stdClass $data Form data.
     * @return void
     */
    private function process_form_data(stdClass $data): void {

    }
}