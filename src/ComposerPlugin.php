<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2018-08-19
 * Time: 16:55
 */

namespace NickWilde1990\DrupalSpecToolCommands;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;

class ComposerPlugin implements PluginInterface, Capable
{


  /**
   * Apply plugin modifications to Composer
   *
   * @param Composer $composer
   * @param IOInterface $io
   */
  public function activate(Composer $composer, IOInterface $io)
  {
  }

  public function getCapabilities()
  {
    return [
      'Composer\Plugin\Capability\CommandProvider' => 'NickWilde1990\DrupalSpecToolCommands\Command\DrupalSpecCommands',
    ];
  }
}
