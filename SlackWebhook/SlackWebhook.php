<?php
/**
 * TestLink Slack Webhook Plugin
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * @filesource  SlackWebhook.php
 * @copyright   2021, naofum
 * @link        https://github.com/naofum
 *
 */

require_once(TL_ABS_PATH . '/lib/functions/tlPlugin.class.php');

/**
 * This plugin listens to testsuite creation etc.
 *
 * Class SlackWebhookPlugin
 */
class SlackWebhookPlugin extends TestlinkPlugin
{
  function _construct()
  {

  }

  function register()
  {
    $this->name = 'SlackWebhook';
    $this->description = 'Slack Webhook Plugin';

    $this->version = '0.1';

    $this->author = 'naofum';
    $this->contact = '';
    $this->url = 'https://github.com/naofum';
  }

  function config()
  {
    return array(
      'config1' => ''
    );
  }

  function hooks()
  {
    $hooks = array(
      'EVENT_TEST_SUITE_CREATE' => 'testsuite_create',
      'EVENT_TEST_PROJECT_CREATE' => 'testproject_create',
      'EVENT_TEST_PROJECT_UPDATE' => 'testproject_update',
      'EVENT_TEST_CASE_CREATE' => 'testcase_create',
      'EVENT_TEST_CASE_UPDATE' => 'testcase_update',
      'EVENT_TEST_REQUIREMENT_CREATE' => 'testrequirement_create',
      'EVENT_TEST_REQUIREMENT_UPDATE' => 'testrequirement_update',
      'EVENT_TEST_REQUIREMENT_DELETE' => 'testrequirement_delete',
      'EVENT_EXECUTE_TEST'  => 'testExecute'
    );
    return $hooks;
  }

  function testsuite_create($args)
  {
    $arg = func_get_args();   // To get all the arguments
    $db = $this->db;      // To show how to get a Database Connection
    #echo plugin_lang_get("testsuite_display_message");
    $msg = "In testsuite create";
    tLog($msg, "WARNING");
    slack($msg);
  }

  function testproject_create()
  {
    $arg = func_get_args();   // To get all the arguments
    $msg = "In TestProject Create with id: " . $arg[1] . ", name: " . $arg[2] . ", prefix: " . $arg[3];
    tLog($msg, "WARNING");
    slack($msg);
  }

  function testproject_update()
  {
    $arg = func_get_args();   // To get all the arguments
    $msg = "In TestProject Update with id: " . $arg[1] . ", name: " . $arg[2] . ", prefix: " . $arg[3];
    tLog($msg, "WARNING");
    slack($msg);
  }

  function testcase_create()
  {
    $arg = func_get_args();   // To get all the arguments
    $msg = "In TestCase Create with id: " . $arg[1] . ", planid: " . $arg[2] . ", title: " . $arg[3] . ", summary" . $arg[4];
    tLog($msg, "WARNING");
    slack($msg);
  }

  function testcase_update()
  {
    $arg = func_get_args();   // To get all the arguments
    $msg = "In TestCase Update with id: " . $arg[1] . ", planid: " . $arg[2] . ", title: " . $arg[3] . ", summary" . $arg[4];
    tLog($msg, "WARNING");
    slack($msg);
  }

  function testrequirement_create()
  {
    $arg = func_get_args();   // To get all the arguments
    $msg = "In TestRequirement Create with id: " . $arg[1];
    tLog($msg, "WARNING");
    slack($msg);
  }

  function testrequirement_update()
  {
    $arg = func_get_args();   // To get all the arguments
    $msg = "In TestRequirement Update with id: " . $arg[1];
    tLog($msg, "WARNING");
    slack($msg);
  }

  function testrequirement_delete()
  {
    $arg = func_get_args();   // To get all the arguments
    $msg = "In TestRequirement Delete with id: " . $arg[1];
    tLog($msg, "WARNING");
    slack($msg);
  }

  function testExecute() {
    $arg = func_get_args();   // To get all the arguments
    $msg = "In TestRun with testrunid: " . $arg[1] . ", planid: " . $arg[2] . ", buildid: " . $arg[3] . ", testcaseid: " . $arg[4] . ", Notes: " . $arg[5] . ", Status: " . $arg[6];
    tLog($msg, "WARNING");
    slack($msg);
  }

}

function slack($message="") {
    # config here
    $webhook_url = "<webhook_url>";
    $channel = "<channel>";
    $username = "<username>";
    $icon = ":ghost:";

    $data = array(
      'username' => $username,
      'text' => $message,
      'channel' => "#{$channel}",
      'icon_emoji' => $icon
    );
    $options = array(
      'http' => array(
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode($data),
      )
    );
    $response = file_get_contents($webhook_url, false, stream_context_create($options));
    return $response === 'ok';
}

