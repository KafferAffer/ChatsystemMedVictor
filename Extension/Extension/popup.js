// Copyright 2018 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.
    



var socket = require('lib/*');

  $(function () {
    var socket = io();
    $('form').submit(function(e){
      e.preventDefault(); // prevents page reloading
      socket.emit('chat message', $('#m').val());
      $('#m').val('');
      return false;
    });
  });


var $fixed = document.createElement( "div" );
$fixed.style = "position: fixed; bottom: 0; right: 0; width: 200px; height: 200px; border: 3px solid #73AD21;background-color: #ffffff;";
    var $beskeder = document.createElement( "div" );
    $beskeder.style = "position: absolute;bottom: 20px;height: 160px;width: 100%;";
        $beskeder.append("<br>");
    $fixed.append($beskeder);
    var $chatnavn = document.createElement( "div" );
    $chatnavn.style = "position: absolute;top: 0px;height: 20px;width: 100%;border: 3px solid #73AD21;";
        $chatnavn.append("Chat navn");
    $fixed.append($chatnavn);
$($fixed).appendTo("body");