<?php

namespace NickWilde1990\DrupalSpecToolCommands;

use Composer\IO\IOInterface;

trait GoogleSpreadsheetAccessTrait  {

  /**
   * Returns an authorized API client.
   *
   * @param string $name
   *   The name of the app.
   * @param string $credentials_path
   *   The path to check/store credentials.
   * @param IOInterface $io
   *   The IOInterface to interact with the user.
   *
   * @return \Google_Client the authorized client object
   *
   * @throws \Google_Exception
   * @throws \Exception
   */
  function getClient($name, $credentials_path, IOInterface $io) {
    $client = new \Google_Client();
    $client->setApplicationName($name);
    $client->setScopes(\Google_Service_Sheets::SPREADSHEETS_READONLY);
    $client->setAuthConfig("$credentials_path/credentials.json");
    $client->setAccessType('offline');

    // Load previously authorized credentials from a file.
    $token_path = "$credentials_path/token.json";
    if (file_exists($token_path)) {
      $access_token = json_decode(file_get_contents($token_path), TRUE);
    }
    else {
      // Request authorization from the user.
      $io->write("Authorization to access Google Spreadsheet needed. Open the following link in your browser:\n{$client->createAuthUrl()}\n");
      $verification = $io->ask("Enter verification code: ");

      // Exchange authorization code for an access token.
      $access_token = $client->fetchAccessTokenWithAuthCode($verification);

      // Check to see if there was an error.
      if (array_key_exists('error', $access_token)) {
        throw new \Exception(join(', ', $access_token));
      }

      // Store the credentials to disk.
      if (!file_exists(dirname($token_path))) {
        mkdir(dirname($token_path), 0700, TRUE);
      }
      file_put_contents($token_path, json_encode($access_token));
      printf("Credentials saved to %s\n", $token_path);
    }
    $client->setAccessToken($access_token);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
      $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
      file_put_contents($token_path, json_encode($client->getAccessToken()));
    }
    return $client;
  }

  /**
   * @param \Google_Client $client
   *   An authorized API client
   * @param string $spreadsheet
   *   The ID of the spreasheet
   * @param string $range
   *   The location to get data from [Sheet Name]![TopLeftCell]:[BottomRightCell]

   * @return array
   *   An multi-level array of retrieved values keyed by row and then column.
   *   0 indexed and the rows/columns start at 0 based on the *range* not the
   *   whole sheet.
   */
  public function getData(\Google_Client $client, $spreadsheet, $range) {
    $service = new \Google_Service_Sheets($client);
    $response = $service->spreadsheets_values->get($spreadsheet, $range);
    $values = $response->getValues();
    return $values;
  }
}
