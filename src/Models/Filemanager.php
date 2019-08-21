<?php

namespace Devuniverse\Filemanager\Models;

use Illuminate\Database\Eloquent\Model;

class Filemanager extends Model
{
  /**
   * This allows to create a custom input field, to launch modal upload
   * @param customId
   * @param uniqueTo
   * @param placeholder
   */
    static public function customTextInput($customId, $module='',$uniqueTo=null,$placeholder =''){
      return '<input type="text" class="form-control uploadunique" id="'.$customId.'" placeholder="'.$placeholder.'" '.($uniqueTo ? 'data-uniqueto="'.$uniqueTo.'"' : '').' '.($module!="" ? 'data-module="'.$module.'"' : '').'  value="">';
    }
}
