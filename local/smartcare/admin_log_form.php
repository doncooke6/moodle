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

/**
 * Version information
 *
 * @package    local_smartcare
 * @copyright 2019 TitusLearning {@link http://www.tituslearning.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');
 require_once(__DIR__.'/../../config.php');
 require_once($CFG->libdir.'/formslib.php');
 require_once($CFG->dirroot . '/local/smartcare/locallib.php');
 require_once($CFG->dirroot . '/local/smartcare/reportlib.php');


 require_login();

class local_smartcare_admin_form extends moodleform {

    public function __construct() {
        global $CFG;
        parent::__construct();
    }
        /**
         * Called to define this moodle form
         *
         * @return void
         */
    public function definition() {
        global $CFG, $COURSE, $DB, $PAGE;

        // Added so we can push the page refresh on course selection for quiz repopulation.
        // Get data dynamically based on the selection from the dropdown.
        $mform = $this->_form;
        $mform->addElement('header', 'smartcareadminlog', get_string('admin_heading', 'local_smartcare'));
        $logtype = get_smartcare_success();
        $select = $mform->addElement('select', 'successstatus', get_string('successstatus', 'local_smartcare'), $logtype);
        $select->setMultiple(false);

        $mform->addElement('date_selector', 'logstart', get_string('from'));
        $mform->addElement('date_selector', 'logfinish', get_string('to'));

        $logformat = get_smartcare_format();
        $select = $mform->addElement('select', 'exportformat', get_string('exportformat', 'local_smartcare'), $logformat);
        $select->setMultiple(false);

        //normally you use add_action_buttons instead of this code
        $buttonarray=array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', get_string('producereport', 'local_smartcare'));
        $buttonarray[] = $mform->createElement('cancel');
        $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);

    }

    /**
     * Perform minimal validation on the settings form
     * @param array $data
     * @param array $files
     */
    public function validation($data, $files) {
         $errors = parent::validation($data, $files);
         return $errors;
    }

    /**
     * Each module which defines definition_after_data() must call this method using parent::definition_after_data();
     */
    public function definition_after_data() {
        parent::definition_after_data();
        $mform     =& $this->_form;

    }

    public function get_data() {
        global $DB;
        $data = parent::get_data();

        if (!empty($data)) {
            $mform =& $this->_form;
        }

        return $data;
    }
}
