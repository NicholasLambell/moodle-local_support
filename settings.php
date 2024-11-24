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

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    global $ADMIN;

    // Add subheader to local plugins section.
    $ADMIN->add(
        'localplugins',
        new admin_category(
            'support',
            get_string('pluginname', 'local_support')
        )
    );

    // Create the new settings page
    $settings = new admin_settingpage('local_support', get_string('generalsettings', 'admin'));
    $ADMIN->add('support', $settings);

    $settings->add(new admin_setting_configtextarea(
        'local_support/sites',
        get_string('setting:sites', 'local_support'),
        get_string('setting:sites_desc', 'local_support'),
        ''
    ));
}