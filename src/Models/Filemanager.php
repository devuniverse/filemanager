<?php

namespace Devuniverse\Filemanager\Models;

use Illuminate\Database\Eloquent\Model;

class Filemanager extends Model
{
  /**
   * This allows to create a custom input field, to launch modal upload
   * @param customId
   * @param module
   * @param uniqueTo
   * @param placeholder
   */
    static public function customTextInput($customId, $module='',$uniqueTo=null,$placeholder ='', $type="input"){
      switch ($type) {
        case 'button':
        $html = '<div class="custominput-container">'.
              '<button type="button" class="form-control uploadunique" id="'.$customId.'" '.($uniqueTo ? 'data-uniqueto="'.$uniqueTo.'"' : '').' '.($module!="" ? 'data-module="'.$module.'"' : '').'>'.$placeholder.'</button>'.
              '</div>';
        break;
        default:
          $html = '<div class="custominput-container">'.
                '<input type="text" class="form-control uploadunique" id="'.$customId.'" placeholder="'.$placeholder.'" '.($uniqueTo ? 'data-uniqueto="'.$uniqueTo.'"' : '').' '.($module!="" ? 'data-module="'.$module.'"' : '').'  value="">'.
                '</div>';
        break;
      }
      return $html;
    }
}
