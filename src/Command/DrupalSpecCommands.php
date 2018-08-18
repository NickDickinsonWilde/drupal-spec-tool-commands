<?php

namespace NickWilde1990\DrupalSpecToolCommands\Command;

use Composer\Plugin\Capability\CommandProvider;

class DrupalSpecCommands implements CommandProvider
{
  public function getCommands()
  {
    return [
      new DrupalSpecGherkinDumper()
    ];
  }

}
