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
 require_once($CFG->dirroot . '/local/mwabu_reports/lib.php');

 require_login();

 /**
  * Local plugin for mwabu competency reports
  *
  * @package   mod_assign
  * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
  * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
  */
class local_mwabu_reports_detail_form extends moodleform {
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
        $mform->addElement('header', 'proficiency_report', get_string('detail_heading', 'local_mwabu_reports'));
        $designations = get_mwabudesignations(true);
        $select = $mform->addElement('select', 'role', get_string('selectdesignation', 'local_mwabu_reports'), $designations);
        $select->setMultiple(false);

        $facilities = get_mwabufacilities(true);
        $select = $mform->addElement('select', 'facility', get_string('selectfacility', 'local_mwabu_reports'), $facilities);

        $reporttypes = get_mwabureporttype();
        $select = $mform->addElement('select', 'reporttype', get_string('selectreporttype', 'local_mwabu_reports'), $reporttypes);

        // $quizes = get_mwabuquizzes();
        // $select = $mform->addElement('select', 'facility', get_string('selectquiz', 'local_mwabu_reports'), $quizes);
        // $select->setMultiple(false);

        $reportdestination = get_mwabureportoutput();
        $select = $mform->addElement('select', 'reportdestination', get_string('outputto', 'local_mwabu_reports'), $reportdestination);

        //$mform->addElement('button', 'reporttoscreen', get_string('reporttoscreen', 'local_mwabu_reports'));
        //$mform->addElement('button', 'reporttocsv', get_string('reporttocsv', 'local_mwabu_reports'));

        $this->add_action_buttons(true, get_string('runreport', 'local_mwabu_reports'));
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
        //$mform->getElement('course')->setValue($this->_courseid);
        //$mform->getElement('quiz')->setValue($this->_quizid);
        //$mform->getElement('badgetobeissued')->setValue($this->_badgeid);
        //getElement('criteriagrade')->setValue($this->_criteria);
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
