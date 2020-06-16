<?php

namespace App\Libraries;

use \Google_Client;
use \Google_Service_Analytics;

class ToolboxGoogleAnalytics
{
  public function getProfileName(): string
  {
    $analytics = $this->initializeAnalytics();
    $profile = $this->getFirstProfileId($analytics);
    $results = $this->getProfileInfoResults($analytics, $profile);
    if ($results->getRows() != null && count($results->getRows()) > 0) {

      // Get the profile name.
      $profileName = $results->getProfileInfo()->getProfileName();

      // Print the results.
      return "Profile name: $profileName";
    } else {
      return 'Profile info not found';
    }
  }

  public function getSessionsForLast7Days():int
  {
    $analytics = $this->initializeAnalytics();
    $profile = $this->getFirstProfileId($analytics);
    $results = $this->getSessionsResults($analytics, $profile);
    if ($results->getRows() != null && count($results->getRows()) > 0) {
      // Get the entry for the first entry in the first row.
      $rows = $results->getRows();
      $sessions = $rows[0][0];

      // Print the results.
      return $sessions;
    } else {
      return 0;
    }
  }

  public function getSessionsPerDayForLast7Days():array
  {
    $analytics = $this->initializeAnalytics();
    $profile = $this->getFirstProfileId($analytics);
    $results = $this->getSessionsPerDayResults($analytics, $profile);
    if ($results->getRows() != null && count($results->getRows()) > 0) {
      // Get the entry for the first entry in the first row.
      $rows = $results->getRows();

      $days = array_map(
        function($day) {
          return [
            'date' => $day[0],
            'sessions' => $day[1],
            'dayOfWeek' => date('l', strtotime($day[0]))
          ];
        },
        $rows
      );

      // Print the results.
      return $days;
    } else {
      return [];
    }
  }

  public function getViewsPerDayForLast7Days(): array
  {
    $analytics = $this->initializeAnalytics();
    $profile = $this->getFirstProfileId($analytics);
    $results = $this->getViewsPerDayResults($analytics, $profile);
    if ($results->getRows() != null && count($results->getRows()) > 0) {
      // Get the entry for the first entry in the first row.
      $rows = $results->getRows();

      $days = array_map(
        function($day) {
          return [
            'date' => $day[0],
            'views' => $day[1],
            'dayOfWeek' => date('l', strtotime($day[0]))
          ];
        },
        $rows
      );

      // Print the results.
      return $days;
    } else {
      return [];
    }
  }

  public function getMostPopularPages(): array
  {
    $analytics = $this->initializeAnalytics();
    $profile = $this->getFirstProfileId($analytics);
    $results = $this->getMostPopularPagesResults($analytics, $profile);
    if ($results->getRows() != null && count($results->getRows()) > 0) {
      // Get the entry for the first entry in the first row.
      $rows = $results->getRows();

      $pages = array_map(
        function($row) {
          return [
            'title' => $row[0],
            'url' => $row[1],
            'views' => $row[2]
          ];
        },
        $rows
      );

      // Print the results.
      return $pages;
    } else {
      return [];
    }
  }


  function initializeAnalytics()
  {
    // Creates and returns the Analytics Reporting service object.

    // Use the developers console and download your service account
    // credentials in JSON format. Place them in this directory or
    // change the key file location if necessary.
    $KEY_FILE_LOCATION = base_path() . '/service-account-credentials.json';

    // Create and configure a new client object.
    $client = new Google_Client();
    $client->setApplicationName("Hello Analytics Reporting");
    $client->setAuthConfig($KEY_FILE_LOCATION);
    $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
    $analytics = new Google_Service_Analytics($client);

    return $analytics;
  }

  function getFirstProfileId($analytics) {
    // Get the user's first view (profile) ID.

    // Get the list of accounts for the authorized user.
    $accounts = $analytics->management_accounts->listManagementAccounts();

    if (count($accounts->getItems()) > 0) {
      $items = $accounts->getItems();
      $firstAccountId = $items[0]->getId();

      // Get the list of properties for the authorized user.
      $properties = $analytics->management_webproperties
      ->listManagementWebproperties($firstAccountId);

      if (count($properties->getItems()) > 0) {
        $items = $properties->getItems();
        $firstPropertyId = $items[0]->getId();

        // Get the list of views (profiles) for the authorized user.
        $profiles = $analytics->management_profiles
        ->listManagementProfiles($firstAccountId, $firstPropertyId);

        if (count($profiles->getItems()) > 0) {
          $items = $profiles->getItems();

          // Return the first view (profile) ID.
          return $items[0]->getId();

        } else {
          throw new Exception('No views (profiles) found for this user.');
        }
      } else {
        throw new Exception('No properties found for this user.');
      }
    } else {
      throw new Exception('No accounts found for this user.');
    }
  }

  function getProfileInfoResults($analytics, $profileId) {
    // Calls the Core Reporting API and queries for the number of sessions
    // for the last seven days.
    return $analytics->data_ga->get(
      'ga:' . $profileId,
      '7daysAgo',
      'today',
      'ga:sessions'
    );
  }

  function getSessionsResults($analytics, $profileId) {
    // Calls the Core Reporting API and queries for the number of sessions
    // for the last seven days.
    return $analytics->data_ga->get(
      'ga:' . $profileId,
      '7daysAgo',
      'today',
      'ga:sessions');
  }

  function getSessionsPerDayResults($analytics, $profileId) {
    // Calls the Core Reporting API and queries for the number of sessions
    // for the last seven days.
    return $analytics->data_ga->get(
      'ga:' . $profileId,
      '7daysAgo',
      'today',
      'ga:sessions',
      ['dimensions' => 'ga:date']
    );
  }

  function getViewsPerDayResults($analytics, $profileId) {
    // Calls the Core Reporting API and queries for the number of views per day
    // for the last seven days.
    return $analytics->data_ga->get(
      'ga:' . $profileId,
      '7daysAgo',
      'today',
      'ga:pageviews',
      ['dimensions' => 'ga:date']
    );
  }

  function getMostPopularPagesResults($analytics, $profileId) {
    // Calls the Core Reporting API and queries for the number of views per day
    // for the last seven days.
    return $analytics->data_ga->get(
      'ga:' . $profileId,
      '7daysAgo',
      'today',
      'ga:pageviews',
      [
        'max-results' => 5,
        'dimensions' => 'ga:pageTitle,ga:pagePath',
        'sort' => '-ga:pageviews',
        'filters' => 'ga:pagePath=~^\/(albums//[^\/]+|photos)/[^\/]+$',
      ]
    );
  }

}