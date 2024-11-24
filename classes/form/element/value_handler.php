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

namespace local_support\form\element;

use HTML_QuickForm_element;

/**
 * Dummy form element purely for handling values from custom page elements via native form methods.
 *
 * @package mod_pdp
 * @copyright 2024 Nicholas Lambell
 * @license https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class value_handler extends HTML_QuickForm_element {

    /**
     * @param string|null $elementName Name of the element.
     * @param string|null $elementLabel Label of the element.
     * @param array|null $attributes Associative array of tag attributes or HTML attributes name='value' pairs
     */
    public function __construct(string $elementName = null, string $elementLabel = null, array $attributes = null) {
        parent::__construct($elementName, $elementLabel, $attributes);
    }


    /**
     * Sets the input field name
     *
     * @param string $name Input field name attribute
     */
    public function setName($name): void {
        $this->updateAttributes([ 'name' => $name ]);
    }

    /**
     * Returns the element name
     */
    public function getName(): string {
        return $this->getAttribute('name');
    }

    /**
     * Sets the template type to be used by the element renderer.
     *
     * @return string Template type.
     */
    public static function getElementTemplateType(): string {
        return 'static';
    }
}