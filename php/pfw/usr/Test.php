<?php
  ////////////////////////////////////////////////////////////////
  //  Tool  /  R. All Rights Reserved  /  R < a@a.a >
  ////////////////////////////////////////////////////////////////

  /*
   *
   */
  class Test
  {
    /*
     *
     */
    public static function o( $aTestVar, $aOpt = null )
    {
      echo '<pre>';

      if ( $aOpt === 1 ) {
        print_r( $aTestVar );
      }
      else {
        var_dump( $aTestVar );
      }

      echo '</pre>';
    }
  }
?>
