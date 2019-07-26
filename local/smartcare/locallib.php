<?php
function loc_create_smartcare_log_entry($smartcare_surname, $smartcare_nrc, $smartcare_dob, $smartcare_actions) {
      global $DB;
      // TODO Use the offset from the correct profile custom field for nrc
      $nrc_offset = 1; // TODO set to the real offset value or work it out based on the field name
      $moodle_userid = 0; // Default to not found
      // Take smartcare surname, nrc, dob  and one of more action entries


         // validate the entry against the surname and the nrc (held as custom field)
         $s = "SELECT  u.id as mdluserid, u.lastname as mdlsurname, ud.data
               FROM  {user} u
               JOIN  {user_info_data}  ud ON u.id = ud.userid
              WHERE  LOWER(u.lastname) = :surname
                AND  ud.fieldid = :nrcfieldoffset
                AND  ud.userid = u.id";

         $parms = array('surname' => $smartcare_surname, 'nrcfieldoffset' => $nrc_offset);

           // if valid then set moodle userid matching the user otherwise
          if ($recusermatch = $DB->get_record_sql($s, $parms)) {
             // user is matched - set userid
             $moodle_userid = $recusermatch->mdluserid;
             $error_status = get_string('status_success', 'local_smartcare');
          } else {
             // user not matched - set error text
             $error_text = get_string('error_usernotfound', 'local_smartcare');
             $error_status = get_string('status_failure', 'local_smartcare');
          }

          // For the list of actions

          //TODO get the actions text into the array of $action objects

          // Loop through the list of actions
          // For each actions
          foreach ($smartcare_actions as $action ) {
               // we need to escape the remark

               $smartcare_action_desc = htmlentities ( $action['description'], ENT_COMPAT|ENT_QUOTES);
               $smartcare_action_remark = htmlentities ( $action['remarks'], ENT_COMPAT|ENT_QUOTES);

               // we need to escape the description
               // add a new log record to the smartcare log tables
               $s = 'INSERT INTO {local_smartcare_log} (userid, name, nrc, dob, logtype, logdate,
                               logdescription, logremarks, read_status)
                        VALUES (:userid, :name, :nrc , :dob, :logtype , :logdate ,
                                :logdescription, :logremarks, :readstatus)
                  ';

               $parms = array('userid' => $moodle_userid,
                           'name' => $smartcare_surname,
                           'nrc' => $smartcare_nrc,
                           'dob' => $smartcare_dob,
                           'logtype' => $action['type'],
                           'logdate' => $action['date'],
                           'logdescription' => $smartcare_action_desc,
                           'logremarks' => $smartcare_action_remark,
                           'readstatus' => $error_status);

                $DB->execute($s, $parms);
          }      // end of loop

          return $error_status;
}
