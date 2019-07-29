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


 require_once("$CFG->libdir/externallib.php");
 require_once($CFG->dirroot . '/local/smartcare/locallib.php');

class local_smartcare_external extends external_api {

  /**
   * Returns description of method parameters
   *
   * @return external_function_parameters
   * @since Moodle 2.4
   */
  public static function create_smartcare_log_entry_parameters() {
      return new external_function_parameters(
          array (
              'surname' => new external_value(
                  PARAM_ALPHANUMEXT,
                  'log surname'),
              'nrc' => new external_value(
                  PARAM_ALPHANUMEXT,
                  'log nrc'),
              'dob' => new external_value(
                  PARAM_ALPHANUMEXT,
                  'log user dob'),
              'actions' => new external_multiple_structure(
                new external_single_structure(
                  array(
                      'type' =>  new external_value(
                          PARAM_ALPHANUMEXT,
                          'log entry type'),
                      'date' =>  new external_value(
                          PARAM_ALPHANUMEXT,
                          'log entry date'),
                      'description' =>  new external_value(
                          PARAM_ALPHANUMEXT,
                          'log entry description'),
                      'remarks' =>  new external_value(
                          PARAM_ALPHANUMEXT,
                          'log entry remarks'),
                    ) ) ) ) );
}



  public static function create_smartcare_log_entry($smartcare_surname, $smartcare_nrc, $smartcare_dob, $smartcare_actions) {
   global $DB;


// expects data in the format
// loc_create_smartcare_log_entry('cooke','12345','01/01/2019',
//                           array( array ('type' => '7', 'date' => '25:34.5', 'description' => 'USER LOGIN', 'remarks' => 'NULL'),
//                                  array ('type' => '7', 'date' => '27:30.0', 'description' => 'USER LOGIN', 'remarks' => 'NULL'),
//                                  array ('type' => '14', 'date' => '28:09.2', 'description' => 'MERGE', 'remarks' => 'Create Transport DB merge occured.  Current Site: Kashikishi (HMISCode: 4060190)  Start Time: 9/17/2018 1:28:01 PM  End Time: 9/17/2018 1:28:09 PM  Inital Transport Database Patient Count: 0  Final Transport Database Patient Count: 1  Inital Local Facility Database Patient Count: 3939  Application Version #: 4.5.0.6  Transport Database Version #: 5  ')
//                                ) );

     loc_create_smartcare_log_entry($smartcare_surname, $smartcare_nrc, $smartcare_dob, $smartcare_actions);
//{
// // TODO  code below moved to local library for
//    // TODO Use the offset from the correct profile custom field for nrc
//    $nrc_offset = 1; // TODO set to the real offset value or work it out based on the field name
//    $moodle_userid = 0; // Default to not found
//    // Take smartcare surname, nrc, dob  and one of more action entries
//
//
//    // validate the entry against the surname and the nrc (held as custom field)
//     $s = "SELECT  u.id as mdluserid, u.lastname as mdlsurname, ud.value
//             FROM  {user} u
//             JOIN  {user_info_data}  uf ON u.id = uf.userid
//            WHERE  LOWER(u.surname) = :surname
//              AND  ud.fieldid = :nrcfieldoffset
//     ";
//
//     $parms = array('surname' => $smartcare_surname, 'nrcfieldoffset' => $smartcare_nrc);
//
//
//         // if valid then set moodle userid matching the user otherwise
//        if ($recusermatch = $DB->get_record_sql($s, $parms)) {
//           // user is matched - set userid
//           $moodle_userid = $recusermatch->mdluserid;
//           $error_status = get_string('status_success', 'local_smartcare');
//        } else {
//           // user not matched - set error text
//           $error_text = get_string('error_usernotfound', 'local_smartcare');
//           $error_status = get_string('status_failure', 'local_smartcare');
//        }
//
//        // For the list of actions
//
//        //TODO get the actions text into the array of $action objects
//
//        // Loop through the list of actions
//        // For each actions
//        foreach ($actions as $action ) {
//             // we need to escape the remark
//             $smartcare_action_desc = htmlentities ( $action->desc, ENT_COMPAT|ENT_QUOTES);
//             $smartcare_action_remark = htmlentities ( $action->remark, ENT_COMPAT|ENT_QUOTES);
//
//             // we need to escape the description
//             // add a new log record to the smartcare log tables
//             $s = 'INSERT INTO {local_smartcare_log} (userid, name, nrc, dob, logtype, logdate,
//                             logdescription, logremarks, read_status)
//                      VALUES (:userid, :name, :nrc , :dob, :logtype , :logdate ,
//                              :logdescription, :logremarks, :readstatus)
//                ';
//
//             $parms = array('userid' => $moodle_userid,
//                         'name' => $smartcare_surname,
//                         'nrc' => $smartcare_nrc,
//                         'dob' => $smartcare_dob,
//                         'logtype' => $action->type,
//                         'logdate' => $action->date,
//                         'logdesciption' => $smartcare_action_desc,
//                         'logremarks' => $smartcare_action_remark,
//                         'readstatus' => $error_status);
//
//              $DB->execute($s, $parms);
//        }
//
//   // end of loop
  }


    /**
     * Returns description of method result value
     *
     * @return external_boolean
     * @since Moodle 2.4
     */
     //TODO - fix to return a boolean value
    public static function create_smartcare_log_entry_returns() {
        return new external_warnings();
    }
}
