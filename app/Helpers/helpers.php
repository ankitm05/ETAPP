<?php
    function getAuthcheck() {
       return $admindata = \App\Models\Admin::select('type','username')->where('id',auth()->user()->id)->first();
    }
?>