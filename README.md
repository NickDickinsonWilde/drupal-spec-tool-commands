# Drupal Spec Tool Commands

Provides composer command functionality to automate populate/update gherkin files as defined with [acquia/drupal-spec-tool](https://github.com/acquia/drupal-spec-tool).
No more copy and paste every time you adjust your specification spreadsheet.
Instead, do a couple configuration steps at the start of your project and use this to keep your feature files up to date.
This project requires a [Composer](https://getcomposer.org/) setup since the commands are composer commands.

## Getting started

### Composer Config
The command needs a bit of outside information. The current method of providing that is through the extra config in your
composer.json. Under extra, put a subkey `drupal-spec-tools`, and provide the following keys under that:
  - `spreadsheet`: The ID for your Drupal Spec Tool spreadsheet. It is the long random looking string/UUID in the url to access your spreadsheet. 
    For example, in `https://docs.google.com/spreadsheets/d/1h-SieCV9Dtrj8F4bqMvsbcHwIibN30j2oR9FMRDFT-8/edit?usp=sharing` the id is `1h-SieCV9Dtrj8F4bqMvsbcHwIibN30j2oR9FMRDFT-8`
  - `credentials-path`: The folder to get your google credentials from and store auth keys.
    __WARNING:__ For security reasons under many situations, the credentials should not be committed to your repository.
  - `feature-path` (Optional)[default:'tests/features']: Where to put/update feature files. __WARNING:__ Files sharing the same name
    as the Drupal Spec Tool features will be overwritten if they already exist.

Minimal example:
```json
{
  "extra": {
    "drupal-spec-tool": {
        "credentials-path": "tests/drupal-spec-tool",
        "spreadsheet": "1a1B-4YFjueF0xM34CWA_xKcVc89rk_MlKW1aNFcfx3c"
    }
  }
}
```

### Credentials
You will need [Google API Credentials](https://developers.google.com/sheets/api/quickstart/php) - just complete step 1
and save your credentials.json to your credentials-path. As this only provides API access/can use up your API limits,
this is probably safe to save in your repository if private.

## Usage
In your project root, run `composer drupal-spec-dump-gherkin`.

On first run, this will ask you for access to the sheet. You will need to copy/paste the output authorization url
and log in to Google and confirm access. This will save a token in the defined credentials path and as long as it is there
you should not need to re-authenticate on futher runs.

## Known issues

[See open bug reports in the issue queue.](https://github.com/NickWilde1990/drupal-spec-tool-commands/issues)

## Contribution

Contributions are welcome!

## License

Copyright (C) 2018 Nick Wilde.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>
