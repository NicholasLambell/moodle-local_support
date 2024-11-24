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


namespace local_support\output;

use moodleform;
use renderable;
use renderer_base;
use stdClass;
use templatable;

/**
 * Support page form renderable.
 *
 * @package    local_support
 * @copyright  2024 Nicholas Lambell
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class support_page_form implements templatable, renderable {

    private moodleform $form;

    /**
     * @param moodleform $form Main form.
     */
    public function __construct(moodleform $form) {
        $this->form = $form;
    }

    /**
     * Export data for template renderer.
     *
     * @param renderer_base $output Renderer.
     * @return stdClass
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();
        $data->form = $this->form->render();

        return $data;
    }
}