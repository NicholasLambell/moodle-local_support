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

use renderable;
use renderer_base;
use stdClass;
use templatable;

/**
 * Support entry times section renderable.
 *
 * @package    local_support
 * @copyright  2024 Nicholas Lambell
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class entry_times_section implements templatable, renderable {

    private array $fieldvalues;

    /**
     * @param array<string, int> $fieldvalues List of existing field values indexed by field name.
     */
    public function __construct(array $fieldvalues) {
        $this->fieldvalues = $fieldvalues;
    }

    /**
     * Export data for template renderer.
     *
     * @param renderer_base $output Renderer.
     * @return stdClass
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();

        $supporttypes = [
            'email' => [
                'label' => get_string('supportform:headeremail', 'local_support'),
                'icon' => 'fa-envelope-o',
            ],
            'phone' => [
                'label' => get_string('supportform:headerphone', 'local_support'),
                'icon' => 'fa-phone',
            ],
        ];
        $supportlevels = [
            1 => 6,
            2 => 15,
            3 => 30,
            4 => 45,
        ];

        $data->supporttypes = [];
        foreach ($supporttypes as $type => $typedata) {
            $supporttype = (object)$typedata;
            $supporttype->type = $type;
            $supporttype->levels = [];

            foreach ($supportlevels as $level => $minutes) {
                $fieldname = "${type}level$level";
                $labeldata = [
                    'level' => $level,
                    'minutes' => $minutes,
                ];

                $supporttype->levels[] = (object)[
                    'level' => $level,
                    'label' => get_string('supportform:level', 'local_support', $labeldata),
                    'name' => $fieldname,
                    'minutes' => $minutes,
                    'value' => $this->fieldvalues[$fieldname] ?? 0,
                ];
            }

            $data->supporttypes[] = $supporttype;
        }

        return $data;
    }
}